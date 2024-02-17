<?php
namespace Libraries\Services\User\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\User\User;

class Services extends BaseService
{
    public static function user()
    {
        return new User();
    }
}
