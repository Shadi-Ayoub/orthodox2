<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function index(): string
    {
        return view("auth/login");
    }

    public function login(): string
    {
        $data = [
            "message"   => "",
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $cognito = service("cognito");

                $auth_result = $cognito->login($_POST["username"],$_POST["password"]);

                var_dump($auth_result);

                // New accounts may require users to change password upon login for the first time!
                if($auth_result["status"] == COGNITO_USER_ACCOUNT_STATUS_NEW_PASSWORD_REQUIRED) {
                    $message = "You need to change your password before signing in for the first time!";
                    $data = [
                        "message"   => $message,
                        "username"  => $auth_result["user"]["username"],
                        "session"   => $auth_result["data"]["session"],
                        "forced"    => "yes",
                    ];
                    
                    // $this->_set_access_cookie();

                    return view("auth/change_password", $data);
                }

                if($auth_result["status"] == COGNITO_USER_LOGIN_FAIL) {
                    $message = "Wrong Username or Password!";
                    $data = [
                        "message"   => $message,
                        "forced"    => "no",
                    ];
                    return view("auth/login", $data);
                }

                if($auth_result["status"] == "CONFIRMED" && $auth_result["access_token"] !== null) {
                    return view("admin");
                }

                $message = "Something went wrong!";
            }

            catch(Exception $e) {
                $message = "Wrong Username or Password!";
                $data = [
                    "message"   => $e->getMessage(),
                    "forced"    => "no",
                ];
                return view("auth/login", $data);
            }
		}

        // $message = "Something went wrong!";
        // $data = [
        //     "message"   => $message,
        //     "forced"    => "no",
        // ];
        return view("auth/login", $data);
    }

    public function change_password($para): string {
        $cognito = service("cognito");

        if($_POST["forced"] == "yes") {
            $auth_result = $cognito->changePassword([
                "username" => $_POST["access-token"],
                "PreviousPassword" => $_POST["old-password"],
                "ProposedPassword" => $_POST["new-password"],
            ], true);
        }
    }

    private function _set_access_cookie($access_token, $time_limit=10) {
        $cookie = new Cookie(
            "access_token",
            $access_token,
            [
                "expires"  => new DateTime("+2 hours"),
                "prefix"   => "__Secure-",
                "path"     => "/",
                "domain"   => "",
                "secure"   => true,
                "httponly" => true,
                "raw"      => false,
                "samesite" => Cookie::SAMESITE_LAX,
            ]
        );

        return $cookie;
    }
}