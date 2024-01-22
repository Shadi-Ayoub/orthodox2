<?php
namespace Libraries\Services\Component\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\Component\Component;

class Services extends BaseService
{
    public static function component()
    {
        return new Component();
    }
}
