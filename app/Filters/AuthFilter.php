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
        } else {
            return redirect()->to('/login');
        }

        switch($segment1) {
            case "admin":
            // case "dashboard":
            case "logout":
            case "settings":
                if (!$session->get('isLoggedIn')) {
                    return redirect()->to('/login/admin');
                }

                $cognito = service('cognito');

                if ($cognito->is_access_token_expired()) {
                    $message = "Your Session has expired!";

                    if($session->get('accessType') == ACCESS_TYPE_ADMIN) {
                        return redirect()->to("/login/admin")->withCookies()->with("warning-message", $message);
                    }

                    return redirect()->to("/login")->withCookies()->with("warning-message", $message);
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
                    return redirect()->to('/login');
                }
                break;
            default:
                return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here if needed after the request
    }
}

