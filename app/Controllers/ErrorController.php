<?php

namespace App\Controllers;

class ErrorController extends BaseController {

    public function __construct() {
       
    }

    public function index() {
    }

    public function graphql() {
        $message = session()->getFlashdata('fail-message');

        $data = [
            "message" => $message,
        ];

        return view("errors/error_graphql", $data);
    }
}