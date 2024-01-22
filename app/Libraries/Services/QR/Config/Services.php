<?php
namespace Libraries\Services\QR\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\QR\QR;

class Services extends BaseService
{
    public static function qr()
    {
        return new QR();
    }
}
