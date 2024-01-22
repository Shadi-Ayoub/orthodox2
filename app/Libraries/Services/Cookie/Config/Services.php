<?php
namespace Libraries\Services\Cookie\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\Cookie\Cookie;

class Services extends BaseService
{
    public static function cookie()
    {
        return new Cookie();
    }
}
