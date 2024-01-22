<?php
namespace Libraries\Services\Cognito\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\Cognito\Cognito;

class Services extends BaseService
{
    public static function cognito()
    {
        return new Cognito();
    }
}
