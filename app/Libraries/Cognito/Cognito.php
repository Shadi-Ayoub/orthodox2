<?php
// see: https://github.com/awsdocs/aws-doc-sdk-examples/tree/main/php/example_code/cognito

namespace Libraries\Cognito;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Exception\AwsException;

class Cognito {
    
    private $_cognito;
    private $_auth_result;
    private $_region;
    private $_version;
    private $_access_key;
    private $_secret_access_key;
    private $_client_id;
    private $_user_pool_id;

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
        unset($this->_cognito);
        unset($this->_auth_result);
    }

    /**
     * Initialize the Cognito Identity Provider Client
     */
    private function _initialize() {
        $this->_region = $_ENV['COGNITO_REGION'];
        $this->_version = $_ENV['COGNITO_VERSION'];
        $this->_access_key = $_ENV['COGNITO_USER_ACCESS_KEY_ID'];
        $this->_secret_access_key = $_ENV['COGNITO_USER_SECRET_ACCESS_KEY'];
        $this->_client_id = $_ENV['COGNITO_APP_CLIENT_ID'];
        $this->_user_pool_id = $_ENV['COGNITO_USER_POOL_ID'];

        $this->_cognito = new CognitoIdentityProviderClient([
            'region' => $this->_region,
            'version' => $this->_version,
            'credentials' => array(
                'key' => $this->_access_key,
                'secret'  => $this->_secret_access_key,
            ),
            "PreventUserExistenceErrors" => true,
        ]);
    }

    /**
     * Calls the _authenticate() method to set the $_auth_result array. Will return an array where first element
     * will be the account status: CONFIRMED or NEW_PASSWORD_REQUIRED. The second element will be the AccessToken 
     * value if found or otherwise "".
     *
     * @param $username
     * @param $password
     * @return array
     */
    public function login($username, $password) {
        $result = [
                    "status"        => COGNITO_USER_ACCOUNT_STATUS_UNKNOWN,
                    "access_token"  => "",
                    "user"          => [],
                    "data"          => [],
                    "message"       => "",
                    "error_code"    => "",
        ];

        $auth = $this->_authenticate($username, $password);

        // var_dump($auth_result);

        if($auth["successful"] === false) {

            $result["status"] = COGNITO_USER_LOGIN_FAIL;
            $result["message"] = $auth["message"];
            $result["error_code"] = $auth["error_code"];
            return $result;

        }
        else if($auth["auth_result"]->get("ChallengeName") && $auth["auth_result"]->get("ChallengeName") == "NEW_PASSWORD_REQUIRED") {
            
            $result["status"] = COGNITO_USER_ACCOUNT_STATUS_NEW_PASSWORD_REQUIRED;
            $result["user"]["username"] = $auth["auth_result"]->get("ChallengeParameters")["USER_ID_FOR_SRP"];
            $result["data"]["session"] = $auth["auth_result"]->get("Session");

        }
        else if ($auth["auth_result"]->get('AuthenticationResult')) {

            $this->_auth_result = $auth["auth_result"]->get('AuthenticationResult');

            if (is_array($this->_auth_result)) {
                $result["access_token"] = $this->_auth_result["AccessToken"]; // Will be NULL if something went weong (e.g. wrong password, etc.)
            }

            $result["status"] = COGNITO_USER_ACCOUNT_STATUS_CONFIRMED;

        }

        // return "NULL";

        // $result["status"] = $status; // CONFIRMED | NEW_PASSWORD_REQUIRED | NULL

        // $result = $this->_cognito->listUsers([
        //     'UserPoolId' => $_ENV['COGNITO_USER_POOL_ID'], 
        // ]);

        

        // $user = array();
        // $data = array();

        // if($status == "NEW_PASSWORD_REQUIRED") {
            //$data["session"] = $this->_auth_result["Session"];
            // $user["username"] = $this->_auth_result["ChallengeParameters"]["USER_ID_FOR_SRP"];
        // }

        // $result["user"] = $user;

        // $result["data"] = $data;

        return $result;
    }

    public function change_password($para, $forced=false){
        if($forced) {
            $result = $this->_cognito->respondToAuthChallenge([
                'ChallengeName' => 'NEW_PASSWORD_REQUIRED',
                'ClientId' => $this->client_id,
                'ChallengeResponses' => [
                    'USERNAME' => $para["username"],
                    'NEW_PASSWORD' => $para["password"],
                ],
                'Session' => $para["session"],
            ]);
        }
    }
    
    /**
     * Function that makes the authentication call to the Cognito User Pool and gets back the result.  It then sets it
     * as a private class variable.
     *
     * @param $username
     * @param $password
     */
    private function _authenticate($username, $password) {
        $result = [
            "successful"    => false,
            "message"       => "",
            "error_code"    => "",
            "auth_result"   => null,
        ];

        if (isset($this->_cognito)) {
            try {
                $auth_result = $this->_cognito->adminInitiateAuth([
                    'AuthFlow'          => 'ADMIN_USER_PASSWORD_AUTH',
                    'ClientId'          => $this->_client_id,
                    'UserPoolId'        => $this->_user_pool_id,
                    'AuthParameters'    => [
                        'USERNAME' => $username,
                        'PASSWORD' => $password,
                    ]
                ]);

                $result = [
                    "successful"    => true,
                    "message"       => "User is authenticated successfully!",
                    "error_code"    => "",
                    "auth_result"   => $auth_result,
                ];

                return $result;
            } catch (CognitoIdentityProviderException $exception) {
                var_dump($exception);
                $response = [
                    'error' => $exception->getAwsErrorMessage(),
                    'code' => $exception->getAwsErrorCode()
                ];
                exit();
                // throw $exception;
                //echo $exception->getMessage();
            }
            catch (AwsException $e) {
                // Handle Cognito exceptions
                // echo "Cognito Exception: " . $e->getAwsErrorCode() . " - " . $e->getAwsErrorMessage() . "\n";
                $result = [
                    "successful"    => false,
                    "message"       => $e->getAwsErrorMessage(),
                    "error_code"    => $e->getAwsErrorCode(),
                    "auth_result"   => null,
                ];
                return $result;
            } catch (Exception $e) {
                // Handle other exceptions
                // echo "Other Exception: " . $e->getMessage() . "\n";
                $result = [
                    "successful"    => false,
                    "message"       => $e->getMessage(),
                    "error_code"    => "",
                    "auth_result"   => null,
                ];
                return $result;
            }
        }
    }
}