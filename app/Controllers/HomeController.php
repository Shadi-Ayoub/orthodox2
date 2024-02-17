<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string {
        $user = service("user");
        $access = $user->access_role();

        $data = [
            "logged_in" => $this->session->get('isLoggedIn'),
            "access_type" => $access["type"],
        ];
        
        return view('home', $data);
    }
}