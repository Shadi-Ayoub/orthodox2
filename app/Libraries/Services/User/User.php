<?php
namespace Libraries\Services\User;

class User {

    private $_cognito;
    public $access_type;
    public $user_pool_id;

    public function __construct($id = "") {
        $this->_cognito = service("cognito");

        $access = $this->access_role();

        $this->access_type = $access["type"];
        $this->user_pool_id = $access["pool_id"];
    }

    public function login($username, $password, $user_pool_id) {
        $result = [
                    "status"    => $this->_cognito::USER_ACCOUNT_STATUS_UNKNOWN,
                    "user"      => [],
                    "result"    => "",
                    "error"     => [ "message" => "", "code" => "",],
        ];

        $auth = $this->_cognito->authenticate($username, $password, $user_pool_id);

        if($auth["successful"] === false) {

            // No "result" object since an exception happened
            $result["status"] = $this->_cognito::USER_LOGIN_FAIL;
            $result["error"]["message"] = $auth["message"];
            $result["error"]["code"] = $auth["error_code"];

            return $result;

        }
        else if($auth["result"]->get("ChallengeName")) {
            $result["status"] = $auth["result"]->get("ChallengeName");
            // $result["user"] = $this->_cognito->get_user_info($user_pool_id, $username);
            $result["user"] = $this->get($user_pool_id, $username);
            $result["result"] = $auth["result"];
        }
        else if ($auth["result"]->get('AuthenticationResult')) {

            $r = $auth["result"]->get('AuthenticationResult');

            if (is_array($r)) {
                $result["access_token"] = $r["AccessToken"]; // Will be NULL if something went weong (e.g. wrong password, etc.)
            }

            $result["status"] = $this->_cognito::USER_ACCOUNT_STATUS_CONFIRMED;
            // $result["user"] = $this->_cognito->get_user_info($user_pool_id, $username);
            $result["user"] = $this->get($user_pool_id, $username);
            $result["result"] = $auth["result"];
        }

        return $result;
    }

    public function logout() {
        $result = [
            "successful"    => false,
            "message"       => "",
            "error_message" => "",
            "error_code"    => "",
        ];

        try {
            $session = service('session');
            $access_token = $session->get(ACCESS_TOKEN_NAME);

            if (!$access_token) {
                // Token not found in session
                $result["successful"] = false;
                $result["message"] = "No Access Token Stored in the Session!";
                $result["error_message"] = "No Access Token Stored in the Session!";
                
                return $result;
            }

            $this->_cognito->revokeTokens($access_token);

            $session->destroy();

            // Tokens are revoked, force the user to re-authenticate
            $result["successful"] = true;
            $result["message"] = "User is logged-out successfully!";

            return $result;
        } catch (\Exception $error) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $error->getMessage();
            $result["error_code"] = $error->getCode();

            return $result;
        }
    }

    public function access_role() {
        $request = service("request");
        $session = service("session");

        $access = [
            "type"      => ACCESS_TYPE_USER,
            "pool_id"   => $_ENV['COGNITO_USER_POOL_ID'],
        ];

        $uri = $request->getUri();
        $segments_no = $uri->getTotalSegments();

        if($session->get("accessType") && $session->get("accessType") === ACCESS_TYPE_ADMIN) {
            $access["type"] = ACCESS_TYPE_ADMIN;
            $access["pool_id"] = $_ENV['COGNITO_ADMIN_USER_POOL_ID'];
            return $access;
        }
        elseif($segments_no === 0) {
            return $access;
        }
        elseif($segments_no === 2) {
            $segment1 = $uri->getSegment(1);
            $segment2 = $uri->getSegment(2);

            if($segment1 === "admin" && $segment2 === "login") {
                $access["type"] = ACCESS_TYPE_ADMIN;
                $access["pool_id"] = $_ENV['COGNITO_ADMIN_USER_POOL_ID'];
            }
            return $access;
        }
        else {
            return $access;
        }
    }

    public function default_account_profile(){
        $account = [
            "language"  => "en",
            "login"     => [
                "mfa_enabled"               => false,
                "initial_password_changed"  => false,
            ]
        ];

        return $account;
    }

    /**
     * Gets the login User profile from the session
     */
    public function account_profile() {
        $user_account_attributes_array = session()->get("user")["UserAttributes"];
        $user_profile_string = $user_account_attributes_array["custom:profile"] ?? "";
        $user_profile_array = [];

        if(trim($user_profile_string) === "") {
            $user_profile_array = $this->default_account_profile();
        } else {
            $user_profile_array = json_decode($user_profile_string, true);
        }

        return $user_profile_array;
    }

    public function save_profile($username, $profile_array) {
        // $profile_json_string = $profile_array;
        $attributes =   [
            [   "Name"  => "custom:profile",
                "Value" => json_encode($profile_array),
            ]
        ];

        $result = $this->_cognito->set_user_attributes($this->user_pool_id, $username, $attributes);

        $result["profile"] = $profile_array;

        return $result;
    }

    public function get($user_pool_id, $username) {
        $user = $this->_cognito->get_user_info($user_pool_id, $username);

        // $username = $this->session->get('username');
        // $user_pool_id = $this->session->get('userPoolId');
        // $user = $this->_user->get_user($user_pool_id, $username);

        // Change the "UserAttributes" Array structure: Array of Arrays to Associative Array!
        $user_attributes = [];
        foreach($user["UserAttributes"] as $value) {
            $attribute_value = $value["Value"];
            if($value["Name"] === "custom:profile") {
                $attribute_value = json_decode($value["Value"], true); // user profile data is always saved as a JSON string.
            }
            $user_attributes[$value["Name"]] = $attribute_value;
        }

        $user["UserAttributes"] = $user_attributes;
        return $user;
    }

    // public authenticate($username, $password, $user_pool_id) {
    //     $result = [
    //         "status"    => $this->_cognito->USER_ACCOUNT_STATUS_UNKNOWN,
    //         "user"      => [],
    //         "result"    => "",
    //         "error"     => [ "message" => "", "code" => "",],
    //     ];

    //     $auth = $this->_cognito->authenticate($username, $password, $user_pool_id);

    //     if($auth["successful"] === false) {

    //         // No "result" object since an exception happened
    //         $result["status"] = $this->_cognito->USER_LOGIN_FAIL;
    //         $result["error"]["message"] = $auth["message"];
    //         $result["error"]["code"] = $auth["error_code"];

    //         return $result;

    //     }
    //     else if($auth["result"]->get("ChallengeName")) {
    //         $result["status"] = $auth["result"]->get("ChallengeName");
    //         $result["user"] = $this->get_user_info($user_pool_id, $username);
    //         $result["result"] = $auth["result"];
    //     }
    //     else if ($auth["result"]->get('AuthenticationResult')) {

    //         $r = $auth["result"]->get('AuthenticationResult');

    //         if (is_array($r)) {
    //             $result["access_token"] = $r["AccessToken"]; // Will be NULL if something went weong (e.g. wrong password, etc.)
    //         }

    //         $result["status"] = $this->_cognito->USER_ACCOUNT_STATUS_CONFIRMED;
    //         $result["user"] = $this->get_user_info($user_pool_id, $username);
    //         $result["result"] = $auth["result"];
    //     }

    //     return $result;
    // }

    // public function info($user_pool_id, $username) {
    //     $result = $this->_cognito->AdminGetUser([
    //         'UserPoolId' => $user_pool_id,
    //         'Username' => $username,
    //     ]);

    //     return $result;
    // }
}