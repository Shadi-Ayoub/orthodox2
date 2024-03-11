<?php
namespace Libraries\Services\Component;

// use CodeIgniter\Config\Services;


class Component {

    public function __construct() {
    }

    public function alert($category, $text, $dismissible=true, $icon=true) {
        require 'html/alert.php';
    }

    public function text ($control_name, $value="", $dir="ltr", $required=false, $as="text", $placeholder="", $mode="any", $autocomplete="off", $disabled=false, $class="", $max_length="524288", $size="20", $js="") {
        require 'html/text.php';
    }

    public function password($control_name, $placeholder) {
        require 'html/password.php';
    }

    public function number($control_name, $value, $label="", $required=false, $props=[]) {
        require 'html/number.php';
    }

    public function mfa_code($control_name, $value="", $class="") {
        require 'html/mfa_code.php';
    }

    public function spinner() {
        require 'html/spinner.php';
    }

    public function modal($type, $text="") {

        switch($type) {
            case "error":
                require "html/modal_error.php";
                break;
            case "about-technical":
                require "html/modals/about-technical-modal.php";
                break;
            default:
                require "html/modal_error.php";
        }
    }

    public function recaptcha() {
        require 'html/recaptcha.php';
    }

    public function recaptcha_javascript() {
        require 'js/recaptcha_js.php';
    }

    public function recaptcha_statement() {
        require 'html/recaptcha_statement.php';
    }

    public function idel_timeout_javascript($idle_timeout, $logout_url) {
        require 'js/idle_timeout_js.php';
    }
}