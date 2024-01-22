<?php

/**
 * Include a link to Google Javascript file:
 * <script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('Google.reCaptchaV3.sitekey') ?>"></script>
 */

namespace Libraries\Services\Recaptcha;

class Recaptcha {

    /**
     * Class constructor
     */
    public function __construct() {
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
    }

    public function verify_recaptcha_v3($secret_key, $g_recaptcha_response){

        $recaptcha = new \ReCaptcha\ReCaptcha($secret_key);

        $res = $recaptcha	->setExpectedHostname($_SERVER['SERVER_NAME'])
							// ->setExpectedAction('homepage')
							->setScoreThreshold(0.5)
							->verify($g_recaptcha_response, $_SERVER['REMOTE_ADDR']);
        
        return $res;
    }
}