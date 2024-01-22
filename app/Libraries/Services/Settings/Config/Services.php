<?php
namespace Libraries\Services\Settings\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\Settings\Settings;

class Services extends BaseService
{
    public static function settings()
    {
        return new Settings();
    }
}
