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
        // $default_settings = [
        //     [
        //         "id" => "login",
        //         "settings" => [
        //             "force_password_change" => "yes",
        //             "force_mfa"             => "yes",
        //         ]
        //     ],
        //     [
        //         "id" => "test",
        //         "settings" => [
        //             "setting 1" => "yes",
        //             "setting 2" => "yes",
        //         ]
        //     ]
            
        // ];

        $default_settings = [
            'login' => [
                'force_password_change' => 'no',
                'force_mfa_admin'       => 'yes',
                'force_mfa_user'        => 'no',
            ],
            'test' => [
                'setting 1' => 'no',
                'setting 2' => 'no',
            ],
        ];

        return $default_settings;
    }

    public function get_all() {
        $query_result = $this->_graphql->query(GRAPHQL_QUERY_NAME_GET_ALL_SETTINGS,[]);

        if($query_result["successful"] === false) {
            $session = service("session");
            $response = service("response");

            $session->setFlashdata("fail-message", "The query was not successful for some reason!");
            $response->redirect(site_url('admin/error/graphql'))->send();
            exit;
        } else {
            $json = json_encode($query_result["response"]->data->getAllSettings);
            $settings_array = json_decode($json, true);

            $settings_array_transformed = [];
            $k = "";
            foreach ($settings_array as $one_setting) {
                foreach ($one_setting as $key => $value) {
                    if($key === "id") {
                        $k = $value;
                    }
                    else if($key === "settings") {
                        $settings_array_transformed[$k] = json_decode($value, true);
                    }
                };
            }

            return $settings_array_transformed;
        }




        return $query_result;
    }

    public function update($settings_array) {
        // First transform the settings array to an array of items of type Setting
        $transformed = [];
        foreach ($settings_array as $key => $value) {
            $arr = ['id' => $key, 'settings' => json_encode($value)];
            $transformed[] = json_encode($arr);
        }

        $variables = ['settings' => $transformed];

        $query_result = $this->_graphql->query(GRAPHQL_QUERY_NAME_UPDATE_SETTINGS, $variables);

        if($query_result["successful"] === false) {
            $session = service("session");
            $response = service("response");

            $session->setFlashdata("fail-message", "The \"Update Settings\" query was not successful for some reason!");
            $response->redirect(site_url('admin/error/graphql'))->send();
            exit;
        } else {
            $json = json_encode($query_result["response"]->data->updateSettings);
            $settings_array = json_decode($json, true);
            
            $settings_array_transformed = [];
            $k = "";
            foreach ($settings_array as $one_setting) {
                foreach ($one_setting as $key => $value) {
                    if($key === "id") {
                        $k = $value;
                    }
                    else if($key === "settings") {
                        $settings_array_transformed[$k] = json_decode($value, true);
                    }
                };
            }

            return $settings_array_transformed;
        }
    }

    public function reset() {
        $default_settings = $this->default();

        return $this->update($default_settings);
    }

    public function save() {
        $new_settings_string = $_POST["save-settings-json-string"];
        $new_settings_array = json_decode($new_settings_string, true);
        // echo $new_settings . "<br />";
        // var_dump($settingsArray);
        // echo "<br />";
        // // Check the output
        // echo "<pre>";
        // print_r($settingsArray);
        // echo "</pre>";
        // echo "<br />";
        // echo $settingsArray['login']['force_mfa_admin']; // Outputs: yes
        // die();

        return $this->update($new_settings_array);
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