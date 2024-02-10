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
        // $settings = service("settings")->get_all();
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
    public function logout() {
        return $this->_revokeTokens();
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

    /**
     * Checks if a token is expired.
     *
     * @param string $token JWT to check expiration.
     * @return bool Returns true if the token is expired, false otherwise.
     */
    private function _is_token_expired(string $token): bool {
        $tokenParts = explode('.', $token);
        if (count($tokenParts) < 3) {
            // Not a valid JWT
            return true;
        }

        $payload = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', $tokenParts[1]))), true);
        if (!$payload) {
            // Invalid payload
            return true;
        }

        $now = new \DateTimeImmutable();
        if (isset($payload['exp']) && $now->getTimestamp() >= $payload['exp']) {
            // Token is expired
            return true;
        }

        return false;
    }

    /**
     * Retrieves and checks if the stored access or ID token is expired.
     *
     * @param \CodeIgniter\Session\Session $session CodeIgniter session instance.
     * @param string $tokenKey The session key where the token is stored.
     * @return bool Returns true if the stored token is expired or not found, false otherwise.
     */
    private function _is_stored_token_expired(string $tokenKey): bool {
        $session = service('session');
        $token = $session->get($tokenKey);
        if (!$token) {
            // Token not found in session
            return true;
        }

        return $this->_is_token_expired($token);
    }

    public function is_access_token_expired() {
        $session = service('session');
        $token = $session->get(ACCESS_TOKEN_NAME);
        if (!$token) {
            // Token not found in session
            return true;
        }

        return $this->_is_token_expired($token);
    }

    public function refreshTokensIfRequired() {
        $result = false;
        if ($this->_is_stored_token_expired(ACCESS_TOKEN_NAME) || 
            $this->_is_stored_token_expired(ID_TOKEN_NAME)) {
            $result = $this->_refresh_tokens_and_get_new_refresh_token();
        }

        return $result;
    }

    // use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

    // Assuming $client is an instance of CognitoIdentityProviderClient
    // and you have already set up necessary variables and credentials

    // Function to refresh tokens and check for a new refresh token
    private function _refresh_tokens_and_get_new_refresh_token() {
        try {
            $session = service('session');
            $refreshToken = $session->get(REFRESH_TOKEN_NAME);
            $result = $this->_cognito->initiateAuth([
                'AuthFlow' => 'REFRESH_TOKEN_AUTH',
                'AuthParameters' => [
                    'REFRESH_TOKEN' => $refreshToken,
                ],
                'ClientId' => $this->_client_id,
            ]);

            $newAccessToken = $result['AuthenticationResult']['AccessToken'];
            $newIdToken = $result['AuthenticationResult']['IdToken'];

            // Check if a new refresh token is provided in the response
            $newRefreshToken = isset($result['AuthenticationResult']['RefreshToken']) 
                                ? $result['AuthenticationResult']['RefreshToken'] 
                                : null;

            if ($newRefreshToken) {
                // A new refresh token has been issued
                return [
                    ACCESS_TOKEN_NAME => $newAccessToken,
                    ID_TOKEN_NAME => $newIdToken,
                    REFRESH_TOKEN_NAME => $newRefreshToken, // The new refresh token
                    'refreshTokenUpdated' => true,
                ];
            } else {
                // The original refresh token is still valid and no new refresh token was issued
                return [
                    ACCESS_TOKEN_NAME => $newAccessToken,
                    ID_TOKEN_NAME => $newIdToken,
                    REFRESH_TOKEN_NAME => $refreshToken, // Return the original refresh token
                    'refreshTokenUpdated' => false,
                ];
            }
        } catch (\Aws\Exception\AwsException $e) {
            // Handle errors appropriately
            echo $e->getMessage();
        }
    }

    // Function to revoke all tokens
    private function _revokeTokens() {
        $result = [
            "successful"    => false,
            "message"       => "",
            "error_code"    => "",
            "error_message" => "",
        ];

        try {
            $session = service('session');
            $access_token = $session->get(ACCESS_TOKEN_NAME);
            if (!$access_token) {
                // Token not found in session
                $result["successful"] = false;
                $result["message"] = "No Access Token Stored in the Session!";
                $result["error_message"] = "No Access Token Stored in the Session!";
                
                return $result;
            }
            $this->_cognito->globalSignOut([
                'AccessToken' => $access_token,
            ]);

            // Tokens are revoked, force the user to re-authenticate
            $result["successful"] = true;
            $result["message"] = "User is logged-out successfully!";

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