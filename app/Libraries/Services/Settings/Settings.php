<?php

namespace Libraries\Services\Settings;

/**
 * This service is intended to manage the application settings. The settings are stored on a DynamoDB NoSQL
 * database on AWS.
 */
class Settings {
    private $_dynamodb;
    private $_settings;
    /**
     * Class constructor
     */
    public function __construct() {
        $this->_dynamodb = service("dynamodb");
        $this->_settings = config('Extended/DynamoDB'); // Load the default settings
        $this->_load($_ENV["APPLICATION_CODE"]);
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
    }

    private function _load($code) {
        return;
    }

    public function get() {
        return $this->_settings;
    }

    public function update() {
        return $this->_settings;
    }
}