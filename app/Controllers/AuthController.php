<?php

namespace App\Controllers;

// use Config\Services;

class AuthController extends BaseController {
    // const ACCESS_TYPE_USER = "USER"; // Normal User
    // const ACCESS_TYPE_ADMIN = "ADMIN"; // An Administrator

    private $_cognito;
    private $_user;
    private $_access_type;
    private $_user_pool_id;

    public function __construct() {
        $this->_user = service("user");
        $this->_cognito = service("cognito");
        $this->_cookie = service("cookie");

        $access = $this->_user->access_role();

        $this->_access_type = $access["type"];
        $this->_user_pool_id = $access["pool_id"];
    }

    public function index() {
    }

    public function login() {
        $message = "";
        $message_type = "";

        // ADMIN | USER
        // $this->_access_type = $this->_get_user_access_type_from_session();

        // Does the user belong to the Administers Pool or Users Pool
        // $user_pool_id = $this->_get_user_pool_id();

        // check if it is a system Admin or a normal user login.
        // segment1 is "login" as per the route configuration
        // $uri = $this->request->getUri();
        // $segment1 = $uri->getSegment(1);
        
        // $this->_access_type = ACCESS_TYPE_USER;
        // $user_pool_id = $_ENV['COGNITO_USER_POOL_ID'];

        // if($segment1 == "admin") {
        //     $this->_access_type = ACCESS_TYPE_ADMIN;
        //     $user_pool_id = $_ENV['COGNITO_ADMIN_USER_POOL_ID'];
        // }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                // $auth_result = $this->_cognito->login($_POST["username"],$_POST["password"], $user_pool_id);

                $auth_result = $this->_user->login($_POST["username"],$_POST["password"], $this->_user_pool_id);
                //    var_dump($user_pool_id);
                //    return;
                // New accounts may require users to change password upon login for the first time!
                // In such cases, the AWS Cognito "confirmation status" will be "Force change password"
                if($auth_result["status"] == $this->_cognito::USER_ACCOUNT_STATUS_CONFIRMED && $auth_result["access_token"] !== null) {
                   // Prepare the session TBD
                    return redirect()->to("/admin/dashboard");
                }
                else if($auth_result["status"] == $this->_cognito::USER_LOGIN_FAIL) {
                    $message = "Wrong Username or Password!";
                    $data = [
                        "message"   => $message,
                        "message_type"  => "danger",
                        "access_type"       => $this->_access_type,
                    ];

                    $this->session->destroy();

                    return view("auth/login", $data);
                }
                else if($auth_result["status"] == $this->_cognito::USER_ACCOUNT_STATUS_NEW_PASSWORD_REQUIRED) {
                    $message = "You need to change your password before signing in for the first time!<br />Your session will expire in 3 minutes!";

                    $this->session->set([
                        "isValidUser"   => true,
                        "session"       => $auth_result["result"]["Session"],
                        "username"      => $auth_result["user"]["Username"],
                        "accessType"    => $this->_access_type,
                        "userPoolId"    => $this->_user_pool_id,
                        "forced"        => "yes",
                    ]);

                    return redirect()->to("/change-password")->withCookies()->with("warning-message", $message);
                }
                else if($auth_result["status"] == $this->_cognito::USER_ACCOUNT_STATUS_MFA_SETUP_REQUIRED) {
                    $mfa_enabled = $this->_cognito->get_user_attribute_value($auth_result["user"]["UserAttributes"],"custom:MFA_ENABLED");

                    // Get MAF setup secret
                    $secret_result = $this->_cognito->get_maf_setup_secret($auth_result["result"]["Session"]);

                    if($secret_result["successful"]) {
                        $auth_result["result"]["Session"] = $secret_result["result"]["Session"];
                        $secret = $secret_result["result"]["SecretCode"];

                        // $this->_cookie->create("username", $auth_result["user"]["Username"]);
                        // $this->_cookie->create("session", $auth_result["result"]["Session"]);
                        // $this->_cookie->create("mfa-setup-secret", $secret);

                        $this->session->set([
                            "isValidUser"       => true,
                            "session"           => $auth_result["result"]["Session"],
                            "username"          => $auth_result["user"]["Username"],
                            "userPoolId"        => $this->_user_pool_id,
                            "accessType"        => $this->_access_type,
                            "mfa-setup-secret"  => $secret,
                        ]);
                        // $this->session->set([
                        //     "isValidUser"   => true,
                        //     "username"      => $auth_result["user"]["Username"],
                        // ]);

                        return redirect()->to("/mfa-setup")->withCookies();
                    } else {
                        $message = $secret_result["error_message"];

                        if($this->_access_type == ACCESS_TYPE_ADMIN) {
                            return redirect()->to("admin/login")->withCookies()->with("fail-message", $message);
                        }

                        return redirect()->to("/login")->withCookies()->with("fail-message", $message);
                    }

                    // } else {
                        
                    // }
                }
                else if($auth_result["status"] == $this->_cognito::USER_ACCOUNT_STATUS_MFA_CODE_REQUIRED) {
                    $this->session->set([
                        "isValidUser"       => true,
                        "session"           => $auth_result["result"]["Session"],
                        "username"          => $auth_result["user"]["Username"],
                        "userPoolId"        => $this->_user_pool_id,
                        "accessType"        => $this->_access_type,
                    ]);
                    if($this->_access_type == ACCESS_TYPE_ADMIN) {
                        return redirect()->to("/admin/mfa-code-entry")->withCookies();
                    }

                    return redirect()->to("/mfa-code-entry")->withCookies();
                }
                else {
                    $message = "Something went wrong!";

                    $data = [
                        "message"   => $message,
                        "message_type"  => "danger",
                        "access_type"       => $this->_access_type,
                    ];

                    $this->session->destroy();

                    return view("auth/login", $data);
                }
            } catch(Exception $e) {
                $data = [
                    "message"   => $e->getMessage(),
                    "message_type" => "danger",
                    "forced"    => "no",
                    "access_type"       => $this->_access_type,
                ];

                $this->session->destroy();
                return view("auth/login", $data);
            }
		}

        // GET method

        if (session()->getFlashdata('fail-message')) { // ex. after session expiry
            $message = session()->getFlashdata('fail-message');
            $message_type = "danger";
        } else if (session()->getFlashdata('success-message')) { // ex. after logout
            $message = session()->getFlashdata('success-message');
            $message_type = "success";
        } else if (session()->getFlashdata('warning-message')) { // ex. after logout
            $message = session()->getFlashdata('warning-message');
            $message_type = "warning";
        }

        $data = [
            "message"           => $message,
            "message_type"      => $message_type,
            "access_type"       => $this->_access_type,
        ];

        $this->session->destroy();
        return view("auth/login", $data);
    }

    public function logout() {
        // $user_pool_id = $this->_get_user_pool_id();

        // ADMIN | USER
        // $this->_access_type = $this->_get_user_access_type_from_session();

        $auth_result = $this->_user->logout();

        $msg = "";
        $msg_type = "";

        if ($auth_result["successful"]) {
            $msg = $msg . "You were logged out successfully";
            $msg_type = "success-message";
        } else {
            $msg = $msg . "Could not revoke all tokens for some reason!!!";
            $msg_type = "fail-message";
        }

        return redirect()->to("/");

        // if($this->_access_type == ACCESS_TYPE_ADMIN) {
        //     return redirect()->to("admin/login")->with($msg_type, $msg);
        // }

        // return redirect()->to("/login")->with($msg_type, $msg);
    }

    public function change_password() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {

            if (session()->getFlashdata('fail-message')) { // ex. after session expiry
                $message = session()->getFlashdata('fail-message');
                $message_type = "danger";
            } else if (session()->getFlashdata('success-message')) { // ex. after logout
                $message = session()->getFlashdata('success-message');
                $message_type = "success";
            } else if (session()->getFlashdata('warning-message')) {
                $message = session()->getFlashdata('warning-message');
                $message_type = "warning";
            } else {
                $message = "";
                $message_type = "";
            }

            $data = [
                "message"       => $message,
                "message_type"  => $message_type,
            ];
            
            if(!$this->session->get("forced") || !$this->session->get("session")) {
                $message = "A Bad Request!";

                if($this->_access_type == ACCESS_TYPE_ADMIN) {
                    return redirect()->to("admin/login")->with("fail-message", $message);
                }

                return redirect()->to("/login")->with("fail-message", $message);
            }

            return view("auth/change_password", $data);
        }

        //POST request
        // var_dump($this->session);
        // return;
        $forced = $this->session->get("forced");

        if($forced == "yes") {

            $change_password_data = [
                "username"      => $this->session->get("username"),
                "new_password"  => trim($_POST["new-password"]),
                "session"       => $this->session->get("session"),
                "forced"        => $this->session->get("forced"),
            ];

            // Check the current password
            $auth_result = $this->_cognito->login($change_password_data["username"],$_POST["old-password"], $this->session->get("userPoolId"));

            if (!isset($auth_result["result"]["Session"])) {

                $message = "You entered a wrong current password! Please login again and retry.";
                $message_type = "fail-message";

                if($this->_access_type == ACCESS_TYPE_ADMIN) {
                    return redirect()->to("admin/login")->with("fail-message", $message);
                }

                return redirect()->to("/login")->with("fail-message", $message);
            }

            $change_password_data["session"] = $auth_result["result"]["Session"]; // New session since new login

            // verify that the new password is confirmed by the user entry.
            if(trim($_POST["new-password"]) !== trim($_POST["confirm-new-password"])) {

                $message = "The two entered new passwords are different! Please try again.";
                $data = [
                    "message"       => $message,
                    "message_type"  => "danger",
                ];

                $this->session->set([
                    "session" => $change_password_data["session"],
                ]);

                return view("auth/change_password", $data);
            }

            // Change the password.
            // The AWS Cognito "confirmation status" will be changed from "Force change password" to "confirmed".
            $result = $this->_cognito->change_password($change_password_data, true);

            if($result["successful"]) {
                $message = "Password is changed successfully!<br />Please login again.";
                $message_type = "success";

                $data = [
                    "message"       => $message,
                    "message_type"  => $message_type,
                    "access_type"       => $this->_access_type,
                ];

                $this->session->destroy();
                return view("auth/login", $data);
            }

            if($result["error_code"] === "InvalidPasswordException") {
                $message = "Invalid New Password! Passwords must conform to the rules below.";
                $data = [
                    "message"       => $message,
                    "message_type"  => "danger",
                ];

                return view("auth/change_password", $data);
            }

            if($result["error_code"] === "NotAuthorizedException") {
                $data = [
                    "message"       => $result["error_message"],
                    "message_type"  => "danger",
                ];

                $this->session->destroy();
                return view("auth/login", $data);
            }

            $data = [
                "message"       => $result["error_message"],
                "message_type"  => "danger",
            ];

            return view("auth/change_password", $data);
        }
    }

    public function mfa_setup() {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Register MAF Authenticator
            $username = $this->session->get("username");
            $session = $this->session->get("session");
            $totp = $_POST["totp"];
            $secret = $this->session->get("mfa-setup-secret");
            // $user_pool_id = $this->session->get("userPoolId");
            $mfa_verification_result = $this->_cognito->verify_maf_setup_secret($session, $totp);

            if($mfa_verification_result["successful"]) {
                $attributes =   [
                                    [   "Name"  => "custom:MFA_ENABLED",
                                        "Value" => "yes",
                                    ]
                                ];

                $attribute_update_result = $this->_cognito->set_user_attributes($this->_user_pool_id, $username, $attributes);
                
                $message = "You successfully configured your Authenticator App. Please login again!";
                $message_status = "success-message";

                if($attribute_update_result["successful"] === false) {
                    $message = $message . " The MAF_ENABLED attribute could not be updated! ERROR: " . $attribute_update_result["error_message"];
                    $message_status = "fail-message";
                }
                
                return redirect()->to("/login")->with("success-message", $message);
            } else {
                $message = $mfa_verification_result["error_message"];

                if($mfa_verification_result["error_code"] === "NotAuthorizedException") {
                    return redirect()->to("/login")->with("fail-message", $message);
                }

                return redirect()->to("/mfa-setup")->withCookies()->with("fail-message", $message);
            }
        }

        // GET method
        $message = "";
        $message_type = "";

        if (session()->getFlashdata('fail-message')) { // ex. after session expiry
            $message = session()->getFlashdata('fail-message');
            $message_type = "danger";
        } else if (session()->getFlashdata('success-message')) { // ex. after logout
            $message = session()->getFlashdata('success-message');
            $message_type = "success";
        } else if (session()->getFlashdata('warning-message')) { // ex. after logout
            $message = session()->getFlashdata('warning-message');
            $message_type = "warning";
        }

        $data = [
            "message"           => $message,
            "message_type"      => $message_type,
            "username"          => $this->session->get("username"),
            "secret"            => $this->session->get("mfa-setup-secret"),
        ];

        return view("auth/mfa_setup", $data);
    }

    public function mfa_code_entry () {

        $username = $this->session->get("username");
        $session = $this->session->get("session");
        $user_pool_id = $this->session->get("userPoolId");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $totp = $_POST["totp"];

            $mfa_code_verification_result = $this->_cognito->verify_mfa_code($totp, $username, $session);
            // var_dump($mfa_code_verification_result);
            // die();

            if($mfa_code_verification_result["successful"]) {
                $accessToken = $mfa_code_verification_result["result"]["AuthenticationResult"]["AccessToken"];
                $idToken = $mfa_code_verification_result["result"]["AuthenticationResult"]["IdToken"];
                $refreshToken = $mfa_code_verification_result["result"]["AuthenticationResult"]["RefreshToken"];

                // $user= $this->_cognito->get_user_info($this->session->get("userPoolId"), $username);
                $user= $this->_user->get($user_pool_id, $username);
                // $arr_user_attributes = $user->get('UserAttributes');
                // $arr_access_codes = json_decode($this->_cognito->get_user_attribute_value($arr_user_attributes, "custom:ACCESS_CODES"));
                // var_dump($user);
                // die();

                $this->session->remove('isValidUser');

                $this->session->set([
                    "isLoggedIn"        => true,
                    'accessType'        => ACCESS_TYPE_ADMIN,
                    ACCESS_TOKEN_NAME   => $accessToken,
                    ID_TOKEN_NAME       => $idToken,
                    REFRESH_TOKEN_NAME  => $refreshToken,
                    "user"              => $user,
                ]);

                return redirect()->to("/admin/dashboard");
            } else {
                $message = $mfa_code_verification_result["error_message"];

                if($mfa_code_verification_result["error_code"] === "NotAuthorizedException") {
                    if($this->session->get("accessType") === ACCESS_TYPE_ADMIN) {
                        return redirect()->to("admin/login")->with("fail-message", $message);
                    }
                    return redirect()->to("/login")->with("fail-message", $message);
                }
        
                if($this->session->get("accessType") === ACCESS_TYPE_ADMIN) {
                    return redirect()->to("/admin/mfa-code-entry")->withCookies()->with("fail-message", $message);
                }

                return redirect()->to("/mfa-code-entry")->withCookies()->with("fail-message", $message);
            }
        }

        //GET

        $message = "";
        $message_type = "";

        if (session()->getFlashdata('fail-message')) { // ex. after session expiry
            $message = session()->getFlashdata('fail-message');
            $message_type = "danger";
        } else if (session()->getFlashdata('success-message')) { // ex. after logout
            $message = session()->getFlashdata('success-message');
            $message_type = "success";
        } else if (session()->getFlashdata('warning-message')) { // ex. after logout
            $message = session()->getFlashdata('warning-message');
            $message_type = "warning";
        }

        $data = [
            "message"           => $message,
            "message_type"      => $message_type,
        ];

        return view("auth/mfa_code_entry", $data);
    }

    // private function _get_user_pool_id () {
    //     $uri = $this->request->getUri();
    //     $segment1 = $uri->getSegment(1);
        
    //     if( $segment1 == "admin" ||
    //         $segment1 == "login" ||
    //         $segment1 == "logout" ) {
    //         return $_ENV['COGNITO_ADMIN_USER_POOL_ID'];
    //     }

    //     if($this->session->get("accessType") && $this->session->get("accessType") == ACCESS_TYPE_ADMIN) {
    //         return $_ENV['COGNITO_ADMIN_USER_POOL_ID'];
    //     }
        
    //     return $_ENV['COGNITO_USER_POOL_ID'];
    // }

    private function _get_user_access_type_from_session () {
        // First check the session data.
        if($this->session->get("accessType") && $this->session->get("accessType") == ACCESS_TYPE_ADMIN) {
            return ACCESS_TYPE_ADMIN;
        }

        // $uri = $this->request->getUri();
        // $segment1 = $uri->getSegment(1);
        
        // if($segment1 == "admin") {
        //     return ACCESS_TYPE_ADMIN;
        // }

        return ACCESS_TYPE_USER;
    }
}