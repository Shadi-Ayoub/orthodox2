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

    public function default_system() {

        $default_system_settings = [
            'login' => [
                'force_password_change' => 'no',
                'force_mfa_admin'       => 'yes',
                'force_mfa_user'        => 'no',
            ],
            'session' => [
                'idle_timeout' => '3600',
            ],
        ];

        return $default_system_settings;
    }

    /**
     * {"login": {"force_password_change": "no","force_mfa_admin": "yes","force_mfa_user": "no"},"session":{"idle_timeout":"3600"},"test": {"setting 1": "no","setting 2": "no"}}
     */
    public function default() {

        $default_settings = [
            'login' => [
                'force_password_change' => 'no',
                'force_mfa_admin'       => 'yes',
                'force_mfa_user'        => 'no',
            ],
            'test' => [
                'setting 1' => 'xxxxx',
            ],
        ];

        return $default_settings;
    }

    /**
     * Returns an array of two arrays. One represents the entity (Congregation) settings and the second
     * represents the system settings that may override entity settings. Both arrays are saved in the session.
     */
    public function get($id) {
        $query_result = $this->_graphql->query(GRAPHQL_QUERY_NAME_GET_SETTINGS_BY_ID, "getSettingsById", ["id" => $id]);

        if($query_result["successful"] === false) {
            $session = service("session");
            $response = service("response");

            $session->setFlashdata("fail-message", "The query was not successful for some reason!");
            $response->redirect(site_url('admin/error/graphql'))->send();
            exit;
        } else {
            // var_dump($query_result);
            // die();
            $json = json_encode($query_result["response"]->data->getSettingsById);
            $settings_array = json_decode($json, true);

            // $settings_array = $query_result["response"]->data->getSettingsById;

            $settings_entity_array[$settings_array[0]["id"]] = json_decode($settings_array[0]["settings"], true);
            $settings_system_array[$settings_array[1]["id"]] = json_decode($settings_array[1]["settings"], true);

            $settings_array_transformed = [$settings_entity_array, $settings_system_array];
            // $k = "";
            // foreach ($settings_array as $one_setting) {
            //     foreach ($one_setting as $key => $value) {
            //         if($key === "id") {
            //             $k = $value;
            //         }
            //         else if($key === "settings") {
            //             $settings_array_transformed[$k] = json_decode($value, true);
            //         }
            //     };
            // }

            return $settings_array_transformed;
        }


        return $query_result;
    }

    public function update($entity_id, $settings_array) {
        // First transform the settings array to an array of items of type Setting
        // var_dump($settings_array);
        // die();
        // $transformed = [];
        // foreach ($settings_array as $key => $value) {
        //     $arr = ['id' => $key, 'settings' => json_encode($value)];
        //     $transformed[] = json_encode($arr);
        // }

        $variables = ['id' => $entity_id, 'settings' => json_encode($settings_array)];

        $query_result = $this->_graphql->query(GRAPHQL_QUERY_NAME_UPDATE_SETTINGS_BY_ID, "UpdateSettingsById", $variables);

        if($query_result["successful"] === false) {
            $session = service("session");
            $response = service("response");

            $session->setFlashdata("fail-message", "The \"Update Settings\" query was not successful for some reason!");
            $response->redirect(site_url('admin/error/graphql'))->send();
            exit;
        } else {
            $json = json_encode($query_result["response"]->data->updateSettingsById);
            $result_settings_array = json_decode($json, true);
            
            // $settings_array_transformed = [];
            // $k = "";
            // foreach ($settings_array as $one_setting) {
            //     foreach ($one_setting as $key => $value) {
            //         if($key === "id") {
            //             $k = $value;
            //         }
            //         else if($key === "settings") {
            //             $settings_array_transformed[$k] = json_decode($value, true);
            //         }
            //     };
            // }

            // var_dump($result_settings_array["settings"]);
            // die();

            // return $result_settings_array["settings"];
            
            // Get the updated settings
            return $this->get($entity_id);
        }
    }

    public function reset($entity_id) {
        $default_settings = $this->default();

        return $this->update($entity_id, $default_settings);
    }

    public function save($entity_id, $new_settings_string) {
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

        return $this->update($entity_id, $new_settings_array);
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