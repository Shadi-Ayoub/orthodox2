<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AdminController extends BaseController {

    // private $_appsync;
    private $_graphql;
    private $_cognito;
    private $_settings;
    private $_admin_user_info;

    public function __construct() {
       
    }

    public function index() {
        return view("admin/dashboard");
    }

    private function get_congregations() {}

    private function _get_login_user_info() {
        $username = $this->session->get('username');
        $poolId = $this->session->get('userPoolId');
        return $this->_cognito->get_user_info($poolId, $username);
    }

    public function settings() {
        $message = "";
        $message_type = "";
        // $data = $this->_settings->get_settings();
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

        $settings_array = $this->_settings->get_all();
        
        // $settings = $this->_settings->reset();
        // $json = json_encode($settings["response"]->data->updateSettings);
        // $settings_array = json_decode($json, true);
        // foreach ($settings_array as $key => $value) {
        //     $settings_array[$key] = json_decode($value, true);
        // }

        $data = [
            "message"           => $message,
            "message_type"      => $message_type,
            "settings"          => $settings_array,
        ];

        // var_dump($this->session->get());
        // $settings = $this->_settings->reset();
        // var_dump($settings);

        return view("admin/settings", $data);
    }

    public function settings_reset() {
        $settings = $this->_settings->reset();
        // $default_settings = $settings_service->default();
       
        // $jsonSettingsString = json_encode($default_settings);

        // $variables = ["id" => "login", "settings" => $jsonSettingsString];

        // $query_name = 'mutation_update_settings_by_id';
        // $access_token = $this->session->get("accessToken");

        // $query_result = $this->_graphql->query($query_name, $variables,  $access_token);
        
        // var_dump($settings);
        // die();

        $message = "Settings were reset to default values successfully...";
        return redirect()->to("/settings")->withCookies()->with("success-message", $message);
        // return view("admin/settings_reset");
    }

    private function _get_settings() {
        // Define the variable values
        // $query_get_settings_variables = [
        //     'code' => $this->session("congregation_code"),
        // ];
        try {
            //$settings = $this->_appsync->query($query_get_settings);
            // var_dump("hiiii".$settings);
            return [];
        } catch (Exception $exception) {
            // var_dump($exception);
            return [];
        }
        // $data = [];
        // return view("admin/settings", $data);
    }

     /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // $this->_appsync = service("appsync");
        $this->_cognito = service("cognito");
        $this->_settings = service("settings");
        // $this->_graphql = service("graphql", $_ENV['APPSYNC_API_ENDPOINT'], $_ENV['APPSYNC_API_KEY'], $this->session->get(ID_TOKEN_NAME));
        $this->_graphql = service("graphql", $_ENV['APPSYNC_API_ENDPOINT'], $this->session->get(ID_TOKEN_NAME));

        $this->_admin_user_info = $this->_get_login_user_info();
    }
}