<?php
namespace Libraries\Services\GraphQL\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\GraphQL\GraphQL;

class Services extends BaseService
{
    public static function graphql($end_point, $access_token)
    {
        return new GraphQL($end_point, $access_token);
    }
}
