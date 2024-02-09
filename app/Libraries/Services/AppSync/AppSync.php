<?php

namespace Libraries\Services\AppSync;

use Aws\AppSync\AppSyncClient;
use Aws\Exception\AwsException;


/**
 * Reference: https://docs.aws.amazon.com/appsync/
 * Reference: https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.AppSync.AppSyncClient.html
 */
class AppSync {

    private $_appsync;
    private $_version;
    private $_region;
    private $_endpoint;
    private $_key;
    private $_secret_access_key;

    /**
     * Class constructor
     */
    public function __construct() {
        $this->_initialize();
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
    }

    /**
     * Initialize the DynamoDB Client
     */
    private function _initialize() {
        $this->_region = $_ENV['APPSYNC_API_REGION'];
        $this->_version = $_ENV['APPSYNC_API_VERSION'];
        $this->_endpoint = $_ENV['APPSYNC_API_ENDPOINT'];
        $this->_key = $_ENV['APPSYNC_API_KEY'];
        $this->_secret_access_key = $_ENV['APP_USER_SECRET_ACCESS_KEY'];

        // Configuration array for the AppSync client
        $config = [
            'version' => 'latest',
            'region' => $this->_region,
            'credentials' => [
                'key' => $this->_key,
                'secret' => $this->_secret_access_key,
            ],
            'endpoint' => $this->_endpoint,
        ];

        // Create AppSync client
        $this->_appsync = new AppSyncClient($config);
    }
}