<?php
namespace Libraries\Cognito\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Cognito\Cognito;

class Services extends BaseService
{
    public static function cognito()
    {
        return new Cognito();
    }
}
