<?php

namespace Libraries\Services\DynamoDB;

use Aws\DynamoDb\DynamoDbClient;


/**
 * Reference: https://docs.aws.amazon.com/amazondynamodb/latest/APIReference/Welcome.html
 * Reference: https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/Using.API.html
 * 
 */
class DynamoDB {

    private $_dynamodb;
    private $_region;
    private $_version;
    private $_access_key;
    private $_secret_access_key;

    /**
     * Class constructor
     */
    public function __construct() {
        $this->_initialize();
    }

    /**
     * Initialize the DynamoDB Client
     */
    private function _initialize() {
        $this->_region = $_ENV['COGNITO_REGION'];
        $this->_version = $_ENV['COGNITO_VERSION'];
        $this->_access_key = $_ENV['APP_USER_ACCESS_KEY_ID'];
        $this->_secret_access_key = $_ENV['APP_USER_SECRET_ACCESS_KEY'];

        // Configuration array for the DynamoDB client
        $config = [
            'region'   => $this->_region,
            'version'  => $this->_version,
            'credentials' => [
                'key'    => $this->_access_key,
                'secret' => $this->_secret_access_key,
            ],
        ];

        // Create DynamoDB client
        $this->_dynamodb = new DynamoDbClient($config);
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
    }
}