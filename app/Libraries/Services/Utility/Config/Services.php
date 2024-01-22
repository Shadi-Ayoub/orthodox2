<?php
namespace Libraries\Services\Utility\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\Utility\Utility;

class Services extends BaseService
{
    public static function utility()
    {
        return new Utility();
    }
}
