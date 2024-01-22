<?php

namespace App\Controllers;

class AdminController extends BaseController {

    private $_appsync;

    public function __construct() {
        $this->_appsync = service("appsync");
    }

    public function index() {
        var_dump($this->session->get());
        return view("admin/dashboard");
    }

    private function get_congregations() {}

    public function get_settings() {
        // Define the variable values
        $query_get_settings_variables = [
            'code' => $this->session("congregation_code"),
        ];

        $settings = $this->_appsync->query($query_get_settings);
        $data = [];
        return view("admin/settings", $data);
    }
}