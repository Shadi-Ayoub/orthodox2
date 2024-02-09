<?php
namespace Libraries\Services\GraphQL\Config;

use CodeIgniter\Config\BaseService;
use Libraries\Services\GraphQL\GraphQL;

class Services extends BaseService
{
    public static function graphql($end_point, $api_key, $access_token)
    {
        return new GraphQL($end_point, $api_key, $access_token);
    }
}
