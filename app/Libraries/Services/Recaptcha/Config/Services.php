<?php
namespace Libraries\Services\Recaptcha\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\Recaptcha\Recaptcha;

class Services extends BaseService
{
    public static function recaptcha()
    {
        return new Recaptcha();
    }
}
