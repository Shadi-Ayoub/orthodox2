<?php
namespace Libraries\Services\Shield\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\Shield\Shield;

class Services extends BaseService
{
    public static function shield()
    {
        return new Shield();
    }
}
