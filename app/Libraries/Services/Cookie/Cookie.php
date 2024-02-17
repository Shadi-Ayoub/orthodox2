<?php

namespace Libraries\Services\Cookie;

use Config\Services;
use Config\App as AppConfig;


/**
 * All cookies names used by the user should not include the configured Prefix.
 * The class will add/remove the Prefix automatically.
 * A Prefix must be configured in CI configurateion.
 */
class Cookie {

    // private $_prefix;
    // protected $_response;
    // protected $_request;
    public $config;

    /**
     * Class constructor
     */
    public function __construct($config = []) {
        // $this->_response = Services::response();
        // $this->_request = Services::request();
        $c = config('Cookie');
        $cookie_prefix = $c->prefix;

        $this->config = array_merge([
            'prefix'    => $cookie_prefix,                              // Default prefix
            'expires'   => time() + (COOKIE_UX_EXPIRE * 24 * 60 * 60),  // expires after 1 year
            'path'      => COOKIE_UX_PATH,                              // Default path
            'domain'    => COOKIE_UX_DOMAIN,                            // Default domain
            'secure'    => COOKIE_UX_SECURE,                            // Default secure flag
            'httponly'  => COOKIE_UX_HTTPONLY,                          // Default HttpOnly flag
            'samesite'  => COOKIE_UX_SAMESITE                           // Default SameSite restriction
        ], $config);
    }

    public function set($name, $value, $config = []) {
        $config = array_merge($this->config, $config);
        setcookie($config['prefix'].$name, $value, [
            'expires'   => $config['expires'],
            'path'      => $config['path'],
            'domain'    => $config['domain'],
            'secure'    => $config['secure'],
            'httponly'  => $config['httponly'],
            'samesite'  => $config['samesite'],
            ]
        );
        return json_decode($value, true);
    }

    public function get($name) {
        return json_decode($_COOKIE[$this->config['prefix'].$name], true);
    }

    public function delete($name) {
        // $this->_response->deleteCookie($this->config['prefix'].$name);
        setcookie('User', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'domain' => '', // Specify the domain if it was set, otherwise, leave it empty
            'secure' => false, // or true if you're using HTTPS
            'httponly' => true, // Cookie not accessible via JavaScript, set it according to how the cookie was set
            'samesite' => 'Lax' // None, Lax, or Strict, set it according to how the cookie was set
        ]);
        return $this;
    }

    // Ensure the response with the cookie changes is sent back
    public function send() {
        $this->_response->send();
    }

    public function exists($name) {
        // Check if the cookie exists
        // $cookie = $this->_request->getCookie($this->config['prefix'].$name, $this->config['httponly']);
        // return $cookie !== null;
        return isset($_COOKIE[$this->config['prefix'].$name]);
    }

    public function default_ux_value() {
        $cookie_ux_array = [
            "settings" => [
                "active_tab"    => "general",
            ]
        ];

        $cookie_ux_string = json_encode($cookie_ux_array);

        return $cookie_ux_string;
    }

    /**
     * Class destructor (do cleanup)
     */
    // public function __destruct() {
    // }

    // public function create($name, $value, $secured=true, $expire_seconds=1800) {

    //     $cookie = new \CodeIgniter\Cookie\Cookie(
    //         $name, // CI adds the Prefix automatically
    //         $value,
    //         [
    //             'max-age'  => $expire_seconds, // Expires in 30 minutes by default
    //             "path"     => "/",
    //             "domain"   => "",
    //             "secure"   => true,
    //             "httponly" => true,
    //             "raw"      => false,
    //             "samesite" => \CodeIgniter\Cookie\Cookie::SAMESITE_LAX,
    //         ]
    //     );

    //     \Config\Services::response()->setCookie($cookie);

    // }

    // // If no parameter, all cookies will be returned
    // public function get($name=null) {

    //     $cookie_name = array();

    //     if ($name === null) {
    //         $i = 0;
    //         $len = strlen($this->_prefix);
            
    //         foreach ($_COOKIE as $key=>$val) {
    //             if (substr($key, 0, $len) === $this->_prefix) {
    //                 $cookie_name[$i] = $key;
    //                 $i++;
    //             }
    //         }
    //     } else {
    //         $cookie_name[0] = $name;
    //     }

    //     $cookies = \Config\Services::request()->getCookie($cookie_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //     $cookies_stripped = array();

    //     foreach ($cookies as $key=>$val) {
    //         $cookies_stripped[$this->_strip_prefix($key)] = $val;
    //     }

    //     return $cookies_stripped;

    // }

    // /**
    //  * Add the Prefix to the name prior to reading the cookie.
    //  */
    // public function is($name) {
    //     $cookie = \Config\Services::request()->getCookie($this->_prefix . $name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //     if(isset($cookie)) {
    //         return true;
    //     }

    //     return false;
    // }

    // private function _strip_prefix($name) {
    //     $len = strlen($this->_prefix);
    //     return substr($name, $len);
    // }

    // public function delete($name) {
    //     \Config\Services::response()->deleteCookie($name);
    // }
}