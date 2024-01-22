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
            case "dashboard":
            case "logout":
                if (!$session->get('isLoggedIn')) {
                    return redirect()->to('/admin/login');
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
