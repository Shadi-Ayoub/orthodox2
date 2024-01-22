<?php

namespace Libraries\Services\Cookie;

// use CodeIgniter\Cookie\Cookie;
// use Config\Services;

/**
 * All cookies names used by the user should not include the configured Prefix.
 * The class will add/remove the Prefix automatically.
 * A Prefix must be configured in CI configurateion.
 */
class Cookie {

    private $_prefix;

    /**
     * Class constructor
     */
    public function __construct() {
        $configCookie = new \Config\Cookie();
        $this->_prefix = $configCookie->prefix;
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
    }

    public function create($name, $value, $secured=true, $expire_seconds=1800) {

        $cookie = new \CodeIgniter\Cookie\Cookie(
            $name, // CI adds the Prefix automatically
            $value,
            [
                'max-age'  => $expire_seconds, // Expires in 30 minutes by default
                "path"     => "/",
                "domain"   => "",
                "secure"   => true,
                "httponly" => true,
                "raw"      => false,
                "samesite" => \CodeIgniter\Cookie\Cookie::SAMESITE_LAX,
            ]
        );

        \Config\Services::response()->setCookie($cookie);

    }

    // If no parameter, all cookies will be returned
    public function get($name=null) {

        $cookie_name = array();

        if ($name === null) {
            $i = 0;
            $len = strlen($this->_prefix);
            
            foreach ($_COOKIE as $key=>$val) {
                if (substr($key, 0, $len) === $this->_prefix) {
                    $cookie_name[$i] = $key;
                    $i++;
                }
            }
        } else {
            $cookie_name[0] = $name;
        }

        $cookies = \Config\Services::request()->getCookie($cookie_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $cookies_stripped = array();

        foreach ($cookies as $key=>$val) {
            $cookies_stripped[$this->_strip_prefix($key)] = $val;
        }

        return $cookies_stripped;

    }

    /**
     * Add the Prefix to the name prior to reading the cookie.
     */
    public function is($name) {
        $cookie = \Config\Services::request()->getCookie($this->_prefix . $name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($cookie)) {
            return true;
        }

        return false;
    }

    private function _strip_prefix($name) {
        $len = strlen($this->_prefix);
        return substr($name, $len);
    }

    public function delete($name) {
        \Config\Services::response()->deleteCookie($name);
    }
}