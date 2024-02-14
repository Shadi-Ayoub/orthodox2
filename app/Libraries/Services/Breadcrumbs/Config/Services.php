<?php
namespace Libraries\Services\Breadcrumbs\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\Breadcrumbs\Breadcrumbs;

class Services extends BaseService
{
    public static function breadcrumbs()
    {
        return new Breadcrumbs();
    }
}
