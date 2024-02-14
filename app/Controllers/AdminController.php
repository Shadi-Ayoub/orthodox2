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

    public $breadcrumbs;

    public function __construct() {
       // $this->breadcrumb = new Breadcrumbs();
       $this->breadcrumbs = service('breadcrumbs');
       $this->db = \Config\Database::connect();
       $this->lang = service('request')->getLocale();
    }

    public function index() {
        $uri_string = uri_string();
        $utility = service('utility');
        $lang = service('request')->getLocale(); 

        // if($uri_string == 'admin') {

        $this->breadcrumbs->add(lang('app.home'), site_url(''));
        $this->breadcrumbs->add(lang('app.dashboard'));

        $data['breadcrumbs'] = $this->breadcrumbs->render();
        $data['content_title'] = "";


        // }
        return view("admin/dashboard", $data);
    }

    private function get_congregations() {}

    private function _get_login_user_info() {
        $username = $this->session->get('username');
        $poolId = $this->session->get('userPoolId');
        return $this->_cognito->get_user_info($poolId, $username);
    }

    public function settings() {
        $this->breadcrumbs->add(lang('app.home'), '/');
       	$this->breadcrumbs->add(lang('app.dashboard'), site_url('admin'));
		$this->breadcrumbs->add(lang('app.settings'));

		$data['breadcrumbs'] = $this->breadcrumbs->render();

		$data['content_title'] = lang('app.settings');

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

        $settings_array = [];
        if (session()->getFlashdata('settings')) { // ex. after setings reset
            $settings_array = session()->getFlashdata('settings');
        } else {
            $settings_array = $this->_settings->get_all();
        }

        $default_settings_array = $this->_settings->default();

        $data["message"] = $message;
        $data["message_type"] = $message_type;
        $data["settings_array"] = $settings_array;
        $data["default_settings_array"] = $default_settings_array;

        return view("admin/settings", $data);
    }

    public function settings_reset() {
        $settings = $this->_settings->reset();

        $message = "Settings were reset to default values successfully...";
        return redirect()->to("/settings")->withCookies()->with("success-message", $message)->with("settings", $settings);
    }

    public function settings_save() {
        $settings = $this->_settings->save();

        $message = "New settings were saved successfully...";
        return redirect()->to("/settings")->withCookies()->with("success-message", $message)->with("settings", $settings);
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