<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        $logged_in = $this->session->get('isLoggedIn');
        $data = ["logged_in" => $logged_in];
        
        return view('home', $data);
    }
}