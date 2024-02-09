<?php

namespace Libraries\Services\Settings;

/**
 * This service is intended to manage the application settings. The settings are stored on a DynamoDB NoSQL
 * database on AWS.
 */
class Settings {
    private $_graphql;
    private $_settings;
    /**
     * Class constructor
     */
    public function __construct() {
        $this->_initialize();
        // $this->_dynamodb = service("dynamodb");
        // $this->_settings = config('Extended/DynamoDB'); // Load the default settings
        // $this->_load($_ENV["APPLICATION_CODE"]);
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
    }

    private function _load($code) {
        return;
    }

    public function default() {
        $default_settings = [
            "login" => [
                "force_password_change" => "yes",
                "force_mfa"             => "yes",
            ]
        ];

        return $default_settings;
    }

    public function get() {
        return $this->_settings;
    }

    public function update() {
        return $this->_settings;
    }

    public function reset() {
        $default_settings = $this->default();
        
        $variables = ["id" => "general", "settings" => json_encode($default_settings)];

        $query_result = $this->_graphql->query(GRAPHQL_QUERY_NAME_UPDATE_SETTINGS, $variables);
        
        var_dump($query_result);
        if($query_result["successful"] === false) {
            //throw new \Exception('Some message goes here');
        } else {
            return $query_result;
        }
        

        // $message = "Settings were reset to default values successfully...";
        // return redirect()->to("/settings")->withCookies()->with("success-message", $message);
        // return view("admin/settings_reset");
    }

    /**
     * @return void
     */
    public function _initialize() {
        $session = service("session");
        $this->_graphql = service("graphql", $_ENV['APPSYNC_API_ENDPOINT'], $_ENV['APPSYNC_API_KEY'], $session->get(ACCESS_TOKEN_NAME));
    }
   
}