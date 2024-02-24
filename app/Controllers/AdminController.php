<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AdminController extends BaseController {

    // private $_appsync;
    protected $_graphql;
    protected $_cognito;
    protected $_settings;
    protected $_user;
    protected $_cookie_ux_value; //Array
    protected $_breadcrumbs;

    public function __construct() {
        // $this->breadcrumb = new Breadcrumbs();
        // $this->db = \Config\Database::connect();
        $config['expires'] = time() + (COOKIE_UX_EXPIRE * 24 * 60 * 60); // expires after 1 year
        $config['path'] = COOKIE_UX_PATH;
        $config['domain'] = COOKIE_UX_DOMAIN;
        $config['secure'] = true;
        $config['httponly'] = false;
        $config['samesite'] = 'Lax';

        $cookie = service("cookie", $config);

        if(!$cookie->exists(COOKIE_UX_NAME)){
            $default_cookie_value_string = $cookie->default_ux_value();
            $this->_cookie_ux_value = $cookie->set(COOKIE_UX_NAME, $default_cookie_value_string, $config);
        } else {
            // Get the UX cookie as an Array
            $this->_cookie_ux_value = $cookie->get(COOKIE_UX_NAME);
        }

        $this->lang = service('request')->getLocale();
    }

    public function index() {
        
        $this->_breadcrumbs->add(lang('app.home'), site_url(''));
        $this->_breadcrumbs->add(lang('app.dashboard'));

        $data['breadcrumbs'] = $this->_breadcrumbs->render();
        $data['content_title'] = "";

        // var_dump($this->session->get("user")["UserAttributes"]);
        // $username = $this->session->get("username");
        // $user_pool_id = $this->session->get("userPoolId");
        // var_dump($this->_user->get($user_pool_id, $username));
        // die();

        return view("admin/dashboard", $data);
    }

    // private function get_congregations() {}

    // private function _get_login_user_info() {
    //     $username = $this->session->get('username');
    //     $poolId = $this->session->get('userPoolId');
    //     return $this->_cognito->get_user_info($poolId, $username);
    // }

    // public function settings() {
    //     $this->breadcrumbs->add(lang('app.home'), '/');
    //    	$this->breadcrumbs->add(lang('app.dashboard'), site_url('admin'));
	// 	$this->breadcrumbs->add(lang('app.settings'));

	// 	$data['breadcrumbs'] = $this->breadcrumbs->render();

	// 	$data['content_title'] = lang('app.settings');

    //     $message = "";
    //     $message_type = "";
    //     // $data = $this->_settings->get_settings();
    //     if (session()->getFlashdata('fail-message')) { // ex. after session expiry
    //         $message = session()->getFlashdata('fail-message');
    //         $message_type = "danger";
    //     } else if (session()->getFlashdata('success-message')) { // ex. after logout
    //         $message = session()->getFlashdata('success-message');
    //         $message_type = "success";
    //     } else if (session()->getFlashdata('warning-message')) { // ex. after logout
    //         $message = session()->getFlashdata('warning-message');
    //         $message_type = "warning";
    //     }

    //     $settings_array = [];
    //     if (session()->getFlashdata('settings')) { // ex. after setings reset
    //         $settings_array = session()->getFlashdata('settings');
    //     } else {
    //         $settings_array = $this->_settings->get_all();
    //     }

    //     $default_settings_array = $this->_settings->default();

    //     $data["message"] = $message;
    //     $data["message_type"] = $message_type;
    //     $data["settings_array"] = $settings_array;
    //     $data["default_settings_array"] = $default_settings_array;

    //     // For the Back button/link
    //     if( $this->session->get("_ci_previous_url") !== current_url() ) {
    //         $this->session->set([
    //             "backToUrl"   => previous_url(),
    //         ]);
    //     }

    //     return view("admin/settings", $data);
    // }

    

    // private function _get_settings() {
    //     // Define the variable values
    //     // $query_get_settings_variables = [
    //     //     'code' => $this->session("congregation_code"),
    //     // ];
    //     try {
    //         //$settings = $this->_appsync->query($query_get_settings);
    //         // var_dump("hiiii".$settings);
    //         return [];
    //     } catch (Exception $exception) {
    //         // var_dump($exception);
    //         return [];
    //     }
    //     // $data = [];
    //     // return view("admin/settings", $data);
    // }

     /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // $this->_appsync = service("appsync");
        $this->_breadcrumbs = service('breadcrumbs');
        $this->_user = service("user");
        $this->_cognito = service("cognito");
        $this->_settings = service("settings");
        // $this->_graphql = service("graphql", $_ENV['APPSYNC_API_ENDPOINT'], $_ENV['APPSYNC_API_KEY'], $this->session->get(ID_TOKEN_NAME));
        $this->_graphql = service("graphql", $_ENV['APPSYNC_API_ENDPOINT'], $this->session->get(ID_TOKEN_NAME));

        // $this->_admin_user_info = $this->_get_login_user_info();
    }
}