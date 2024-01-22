<?php
namespace Libraries\Services\AppSync\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\AppSync\AppSync;

class Services extends BaseService
{
    public static function appsync()
    {
        return new AppSync();
    }
}
