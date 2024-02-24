<?php

namespace App\Controllers;


class SettingsController extends AdminController {
    public function __construct() {
        parent::__construct();

    }

    public function index() {
        $access = $this->_user->access_role();

        
        $this->_breadcrumbs->add(lang('app.home'), '/');

        if($access["type"] === ACCESS_TYPE_ADMIN) {
            $this->_breadcrumbs->add(lang('app.dashboard'), site_url('admin/dashboard'));
        } else {
            $this->_breadcrumbs->add(lang('app.dashboard'), site_url('dashboard'));
        }

		$this->_breadcrumbs->add(lang('app.settings'));

		$data['breadcrumbs'] = $this->_breadcrumbs->render();

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

        $config = config('Cookie');
        $cookie_ux_name = $config->prefix . COOKIE_UX_NAME;

        $data["message"] = $message;
        $data["message_type"] = $message_type;
        // var_dump($this->_cookie_ux_value["settings"]["active_tab"]);
        // die();
        $data['active_tab'] = $this->_cookie_ux_value["settings"]["active_tab"] ?? "general";
        $data['cookie_ux_name'] = $cookie_ux_name;
        $data["settings_array"] = $settings_array;
        $data["default_settings_array"] = $default_settings_array;
        
        // For the Back button/link
        if( $this->session->get("_ci_previous_url") !== current_url() ) {
            $this->session->set([
                "backToUrl"   => previous_url(),
            ]);
            // die(previous_url());
        }

        return view("admin/settings", $data);
    }

    public function reset() {
        $settings = $this->_settings->reset();

        $message = "Settings were reset to default values successfully...";
        return redirect()->to("/admin/settings")->withCookies()->with("success-message", $message)->with("settings", $settings);
    }

    public function save() {
        $settings = $this->_settings->save();

        $message = "New settings were saved successfully...";
        return redirect()->to("/admin/settings")->withCookies()->with("success-message", $message)->with("settings", $settings);
    }
}