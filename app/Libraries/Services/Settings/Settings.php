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

    // private function _load($code) {
    //     return;
    // }

    public function default() {
        $default_settings = [
            [0] => [
                "id" => "login",
                "settings" => [
                    "force_password_change" => "yes",
                    "force_mfa"             => "yes",
                ]
            ],
            [1] => [
                "id" => "test",
                "settings" => [
                    "setting 1" => "yes",
                    "setting 2" => "yes",
                ]
            ]
            
        ];
          
        return $default_settings;
    }

    public function get_all() {
        $query_result = $this->_graphql->query(GRAPHQL_QUERY_NAME_GET_ALL_SETTINGS,[]);

        if($query_result["successful"] === false) {
            $session = service("session");
            $response = service("response");

            $session->setFlashdata("fail-message", "The query was not successful for some reason!");
            $response->redirect(site_url('/error/graphql'))->send();
            exit;
        } else {
            $json = json_encode($query_result["response"]->data->getAllSettings);
            $settings_array = json_decode($json, true);
            // $settings_array_reshaped = [];
            
            $i = 0;
            foreach ($settings_array as $one_setting) {
                foreach ($one_setting as $key => $value) {
                    if($key === "settings") {
                        $settings_array[$i][$key] = json_decode($value, true);
                    }
                }
                $i++;
            }

            return $settings_array;
        }




        return $query_result;
    }

    public function update() {
        return $this->_settings;
    }

    public function reset() {
        $default_settings = $this->default();
        
        $variables = ["id" => "login", "settings" => json_encode($default_settings)];

        $query_result = $this->_graphql->query(GRAPHQL_QUERY_NAME_UPDATE_SETTINGS_BY_ID, $variables);
        
        // var_dump(GRAPHQL_QUERY_NAME_UPDATE_SETTINGS_BY_ID);
        // die();
        if($query_result["successful"] === false) {
            $session = service("session");
            $response = service("response");

            $session->setFlashdata("fail-message", "The query was not successful for some reason!");
            $response->redirect(site_url('/error/graphql'))->send();
            exit;
        } else {
            $json = json_encode($query_result["response"]->data->updateSettingsById);
            $settings_array = json_decode($json, true);
            foreach ($settings_array as $key => $value) {
                if($key === "settings") {
                    $settings_array[$key] = json_decode($value, true);
                }
            }
            return $settings_array;
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
        // $this->_graphql = service("graphql", $_ENV['APPSYNC_API_ENDPOINT'], $_ENV['APPSYNC_API_KEY'], $session->get(ACCESS_TOKEN_NAME));
        $this->_graphql = service("graphql", $_ENV['APPSYNC_API_ENDPOINT'], $session->get(ID_TOKEN_NAME));
    }
   
}