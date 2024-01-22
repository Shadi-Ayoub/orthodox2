<?php
// see: https://github.com/awsdocs/aws-doc-sdk-examples/tree/main/php/example_code/cognito

namespace Libraries\Services\Cognito;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Exception\AwsException;

class Cognito {

    const USER_ACCOUNT_STATUS_CONFIRMED = 0;
    const USER_ACCOUNT_STATUS_NEW_PASSWORD_REQUIRED = "NEW_PASSWORD_REQUIRED";
    const USER_ACCOUNT_STATUS_UNKNOWN = 2;
    const USER_LOGIN_FAIL = "NotAuthorizedException";
    const USER_ACCOUNT_STATUS_MFA_SETUP_REQUIRED = "MFA_SETUP";
    const USER_ACCOUNT_STATUS_MFA_CODE_REQUIRED = "SOFTWARE_TOKEN_MFA";
    
    private $_cognito;
    private $_region;
    private $_version;
    private $_access_key;
    private $_secret_access_key;
    private $_client_id;

    public function __construct() {
        $this->_initialize();
        $settings = service("settings")->get();
    }

    public function __destruct() {
        unset($this->_cognito);
    }

    /**
     * Initialize the Cognito Identity Provider Client
     */
    private function _initialize() {
        $this->_region = $_ENV['COGNITO_REGION'];
        $this->_version = $_ENV['COGNITO_VERSION'];
        $this->_access_key = $_ENV['APP_USER_ACCESS_KEY_ID'];
        $this->_secret_access_key = $_ENV['APP_USER_SECRET_ACCESS_KEY'];
        $this->_client_id = $_ENV['COGNITO_APP_CLIENT_ID'];

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
     * Function that makes the authentication call to the Cognito User Pool and gets back the result.  It then sets it
     * as a private class variable.
     * 
     * The Auth Flow considered is ADMIN_USER_PASSWORD_AUTH.
     *
     * @param $username
     * @param $password
     * @param $user_pool_id
     */
    private function _authenticate($username, $password, $user_pool_id) {
        $result = [
            "successful"    => false,
            "message"       => "",
            "error_code"    => "",
            "error_message" => "",
            "auth_result"   => null,
        ];

        if (isset($this->_cognito)) {
            try {
                $auth_result = $this->_cognito->AdminInitiateAuth([
                    'AuthFlow'          => 'ADMIN_USER_PASSWORD_AUTH',
                    'ClientId'          => $this->_client_id,
                    'UserPoolId'        => $user_pool_id,
                    'AuthParameters'    => [
                        'USERNAME' => $username,
                        'PASSWORD' => $password,
                    ]
                ]);

                $result["successful"] = true;
                $result["message"] = "User is authenticated successfully!";
                $result["result"] = $auth_result;

                return $result;
            } catch (CognitoIdentityProviderException $exception) {
                $result["successful"] = false;
                $result["message"] = "Something went wrong!";
                $result["error_message"] = $exception->getAwsErrorMessage();
                $result["error_code"] = $exception->getAwsErrorCode();

                return $result;
            } catch (AwsException $exception) {
                $result["successful"] = false;
                $result["message"] = "Something went wrong!";
                $result["error_message"] = $exception->getAwsErrorMessage();
                $result["error_code"] = $exception->getAwsErrorCode();

                return $result;
            } catch (Exception $exception) {
                $result["successful"] = false;
                $result["message"] = "Something went wrong!";
                $result["error_message"] = $exception->getMessage();
                $result["error_code"] = "400"; // Bad request
                
                return $result;
            }
        }
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
    public function login($username, $password, $user_pool_id) {
        $result = [
                    "status"    => self::USER_ACCOUNT_STATUS_UNKNOWN,
                    "user"      => [],
                    "result"    => "",
                    "error"     => [ "message" => "", "code" => "",],
        ];

        $auth = $this->_authenticate($username, $password, $user_pool_id);

        if($auth["successful"] === false) {

            // No "result" object since an exception happened
            $result["status"] = self::USER_LOGIN_FAIL;
            $result["error"]["message"] = $auth["message"];
            $result["error"]["code"] = $auth["error_code"];

            return $result;

        }
        else if($auth["result"]->get("ChallengeName")) {
            $result["status"] = $auth["result"]->get("ChallengeName");
            $result["user"] = $this->get_user_info($user_pool_id, $username);
            $result["result"] = $auth["result"];
        }
        else if ($auth["result"]->get('AuthenticationResult')) {

            $r = $auth["result"]->get('AuthenticationResult');

            if (is_array($r)) {
                $result["access_token"] = $r["AccessToken"]; // Will be NULL if something went weong (e.g. wrong password, etc.)
            }

            $result["status"] = self::USER_ACCOUNT_STATUS_CONFIRMED;
            $result["user"] = $this->get_user_info($user_pool_id, $username);
            $result["result"] = $auth["result"];
        }

        return $result;
    }

    /**
     * Function that logout an Admin.
     *
     * @param $username
     */
    public function logout($username, $user_pool_id) {
        $result = [
            "successful"    => false,
            "message"       => "",
            "error_code"    => "",
            "error_message" => "",
            "auth_result"   => null,
        ];

        if (isset($this->_cognito)) {
            try {
                $auth_result = $this->_cognito->AdminUserGlobalSignOut([
                    'Username'          => $username,
                    'UserPoolId'        => $user_pool_id,
                ]);

                $result["successful"] = true;
                $result["message"] = "User is logged-out successfully!";
                $result["result"] = $auth_result;

                return $result;
            } catch (CognitoIdentityProviderException $exception) {
                $result["successful"] = false;
                $result["message"] = "Something went wrong!";
                $result["error_message"] = $exception->getAwsErrorMessage();
                $result["error_code"] = $exception->getAwsErrorCode();

                return $result;
            } catch (AwsException $exception) {
                $result["successful"] = false;
                $result["message"] = "Something went wrong!";
                $result["error_message"] = $exception->getAwsErrorMessage();
                $result["error_code"] = $exception->getAwsErrorCode();

                return $result;
            } catch (Exception $exception) {
                $result["successful"] = false;
                $result["message"] = "Something went wrong!";
                $result["error_message"] = $exception->getMessage();
                $result["error_code"] = "400"; // Bad request
                
                return $result;
            }
        }
    }

    public function change_password($para, $forced=false){
        try {
            if($forced) {
                $result_pwd_change = $this->_cognito->respondToAuthChallenge([
                    'ChallengeName' => 'NEW_PASSWORD_REQUIRED',
                    'ClientId' => $this->_client_id,
                    'ChallengeResponses' => [
                        'USERNAME' => $para["username"],
                        'NEW_PASSWORD' => $para["new_password"],
                    ],
                    'Session' => $para["session"],
                ]);

                $result["successful"] = true;
                $result["message"] = "The password is changed successfully!";
                $result["result"] = $result_pwd_change;

                return $result;
            }
        } catch (CognitoIdentityProviderException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (AwsException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (Exception $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getMessage();
            $result["error_code"] = "400"; // Bad request
            
            return $result;
        }
    }

    public function User_mfa_setting_list($user_pool_id, $username) {
        $result = $this->_cognito->UserMFASettingList([
            'UserPoolId' => $user_pool_id,
            'Username' => $username,
        ]);

        return $result;
    }

    public function get_user_info($user_pool_id, $username) {
        $result = $this->_cognito->AdminGetUser([
            'UserPoolId' => $user_pool_id,
            'Username' => $username,
        ]);

        return $result;
    }

    public function get_user_attribute_value($attributes_array, $name) {
        foreach($attributes_array as $key => $value) {
            if(!is_array($value)) {
                return null;
            }
            
            if ($value["Name"] === $name) {
                return $value["Value"];
            }
        }

        return null;
    }

    /**
     * This Function is used to update a used attributes. The attributes are passed 
     * in an array where each array entry is an array of the Name and Value of the attribute.
     * 
     * @param $user_pool_id
     * @param $username
     * @param $attributes[]
     * @return array ["SecretCode" => "string", "Session" => "string"]
     */
    public function set_user_attributes($user_pool_id, $username, $attributes) {
        $result = [
            "successful"    => false,
            "message"       => "",
            "error_code"    => "",
            "error_message" => "",
        ];

        try {
            $attributes_update_result = $this->_cognito->AdminUpdateUserAttributes([
                "UserAttributes" => $attributes,
                "UserPoolId" => $user_pool_id,
                "Username" => $username,
            ]);

            $result["successful"] = true;
            $result["message"] = "User attribute is updated successfully!";

            return $result;
        }catch (CognitoIdentityProviderException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (AwsException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (Exception $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getMessage();
            $result["error_code"] = "400"; // Bad request
            
            return $result;
        }
    }

    /**
     * This Function is used during MFA configuration after login in order to receive 
     * the secret code used by the Authenticator App on the user device.
     * 
     * @param $session
     * @return array ["SecretCode" => "string", "Session" => "string"]
     */
    public function get_maf_setup_secret($session) {
        $result = [
            "successful"    => false,
            "message"       => "",
            "error_code"    => "",
            "error_message" => "",
            "result"        => null,
        ];

        try {
            $maf_setup_secret_result = $this->_cognito->AssociateSoftwareToken([
                "Session" => $session,
            ]);

            $result["successful"] = true;
            $result["message"] = "MAF Secret Code is generated successfully!";
            $result["result"] = $maf_setup_secret_result;

            return $result;
        } catch (CognitoIdentityProviderException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (AwsException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (Exception $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getMessage();
            $result["error_code"] = "400"; // Bad request
            
            return $result;
        }
    }

    public function verify_maf_setup_secret($session, $totp) {
        $result = [
            "successful"    => false,
            "message"       => "",
            "error_code"    => "",
            "error_message" => "",
            "result"        => null,
        ];

        try {
            $maf_setup_secret_verify_result =  $this->_cognito->VerifySoftwareToken([
                "Session"   => $session,
                "UserCode"  => $totp,
            ]);

            $result["successful"] = true;
            $result["message"] = "MAF Secret setup is verified successfully!";
            $result["result"] = $maf_setup_secret_verify_result;

            return $result;
        } catch (CognitoIdentityProviderException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (AwsException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (Exception $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getMessage();
            $result["error_code"] = "400"; // Bad request
            
            return $result;
        }
    }

    public function verify_mfa_code($totp, $username, $session){
        try {
            $result_verify_mfa_code = $this->_cognito->respondToAuthChallenge([
                "ChallengeName" => "SOFTWARE_TOKEN_MFA",
                "ClientId"     => $this->_client_id,
                "ChallengeResponses" => [
                    "USERNAME" => $username,
                    "SOFTWARE_TOKEN_MFA_CODE" => $totp,
                ],
                "Session" => $session,
            ]);

            $result["successful"] = true;
            $result["message"] = "The MFA code was verified successfully!";
            $result["result"] = $result_verify_mfa_code;

            return $result;
        } catch (CognitoIdentityProviderException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (AwsException $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getAwsErrorMessage();
            $result["error_code"] = $exception->getAwsErrorCode();

            return $result;
        } catch (Exception $exception) {
            $result["successful"] = false;
            $result["message"] = "Something went wrong!";
            $result["error_message"] = $exception->getMessage();
            $result["error_code"] = "400"; // Bad request
            
            return $result;
        }
    }

    public function create_user() {
        $params = [
            'UserPoolId' => 'your-user-pool-id',
            'Username' => 'user@example.com',
            'TemporaryPassword' => 'temporary-password',
            'MessageAction' => 'SUPPRESS',
            'DesiredDeliveryMediums' => ['EMAIL'],
            'ForceAliasCreation' => false,
            'UserAttributes' => [
                [
                    'Name' => 'email',
                    'Value' => 'user@example.com',
                ],
                [
                    'Name' => 'phone_number',
                    'Value' => '+1234567890',
                ],
                [
                    'Name' => 'custom:issuer',
                    'Value' => 'your-aws-account-id',
                ],
            ],
        ];
        
        $result = $cognitoClient->adminCreateUser($params);
    }

    public function get_user_preferences($user_pool_id, $username) {
        $user = $this->get_user_info($user_pool_id, $username);
        $preferences = unserialize($this->get_user_attribute_value($user["UserAttributes"], "custom:preferences"));
        return $preferences;
    }

    public function update_user_preferences($user_pool_id, $username, $preferences) {
        return $this->set_user_attributes($user_pool_id, $username, serialize($preferences));
    }
}