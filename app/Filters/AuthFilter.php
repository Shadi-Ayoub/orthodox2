<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Session\Session;
use App\Controllers\AuthController;

class AuthFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {

        $session = \Config\Services::session();
        $segment1 = "";
        
        if($arguments !== null) {
            $segment1 = $arguments[0];
            $segment2 = $arguments[1];
        } else {
            return redirect()->to('/');
        }

        switch($segment1) {
            case "admin":
                switch($segment2) {
                    case "error":
                    case "dashboard":
                    case "settings":
                    case "congregations":
                        if (!$session->get('isLoggedIn')) {
                            $message = "Invalid Access!";

                            return redirect()->to('admin/login')->withCookies()->with("warning-message", $message);

                            // if($session->get('accessType') === ACCESS_TYPE_ADMIN) {
                            //     return redirect()->to('/login/admin')->withCookies()->with("warning-message", $message);
                            // }

                            // if($segment2 === "admin") {
                            //     return redirect()->to('/login/admin')->withCookies()->with("warning-message", $message);
                            // }

                            // return redirect()->to('/login')->withCookies()->with("warning-message", $message);
                        }

                        $cognito = service('cognito');

                        if ($cognito->is_access_token_expired()) {
                            $message = "Your Session has expired!";

                            return redirect()->to("admin/login")->withCookies()->with("warning-message", $message);
                            
                            // if($session->get('accessType') == ACCESS_TYPE_ADMIN) {
                            //     return redirect()->to("/login/admin")->withCookies()->with("warning-message", $message);
                            // }

                            // return redirect()->to("/login")->withCookies()->with("warning-message", $message);
                        }

                        $result = $cognito->refreshTokensIfRequired();

                        if($result) {
                            $session->set([
                                ACCESS_TOKEN_NAME   => $result[ACCESS_TOKEN_NAME],
                                ID_TOKEN_NAME       => $result[ID_TOKEN_NAME],
                            ]);

                            if($result["refreshTokenUpdated"]) {
                                $session->set([
                                    REFRESH_TOKEN_NAME => $result[REFRESH_TOKEN_NAME],
                                ]);
                            }
                        }
                        break;
                    case "change_password":
                    case "mfa_code_entry":
                    case "mfa_setup":
                        if (!$session->get('isValidUser')) { // User provided correct username and password.
                            $message = "Invalid Access!";

                            if($session->get('accessType') === ACCESS_TYPE_ADMIN) {
                                return redirect()->to('admin/login')->withCookies()->with("warning-message", $message);
                            }
                            return redirect()->to('/login')->withCookies()->with("warning-message", $message);
                        }
                        break;
                    default:
                        die($segment1 . "/" . $segment2);
                        if($session->get('accessType') === ACCESS_TYPE_ADMIN) {
                            return redirect()->to('admin/login');
                        }
                        return redirect()->to('/login');
                }
                break;
            default:
                return redirect()->to('/');
        }

        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here if needed after the request
    }
}

