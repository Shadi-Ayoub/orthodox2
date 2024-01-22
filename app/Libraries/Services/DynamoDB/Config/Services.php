<?php
namespace Libraries\Services\DynamoDB\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\DynamoDB\DynamoDB;

class Services extends BaseService
{
    public static function dynamodb()
    {
        return new DynamoDB();
    }
}
