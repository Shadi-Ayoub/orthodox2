<?php

namespace Libraries\Services\Shield;

// use Config\Services;
// use Config\App as AppConfig;


/**
 * 
 */
class Shield {

    /**
     * Class constructor
     */
    public function __construct() {
    }

    public function get_roles_by_id($user_id){

    }

    /**
     * Get current user roles from session 
     */
    public function get_roles(){

    }

    public function system_super_admin_role() {
        $roles = [
            "role_name" => "admin",
            "permissions" => [
                "create_user",
                "delete_user",
                "edit_user",
                "view_user",
                "manage_settings"
            ],
            "access_control" => [
                "modules": [
                    "Users" => [
                        "access_type": ACCESS_TYPE_RW,
                    ],
                    "settings" => [
                        "access_type" => ACCESS_TYPE_R,
                    ],
                ],
                "congregations" => [
                    [
                        "id" => "CongregationA",
                        "access_type" => ACCESS_TYPE_R,
                        "branches" => [
                            [
                                "id" => "BranchA",
                                "access_type" => ACCESS_TYPE_R,
                            ],
                            [
                                "id" => "BranchB",
                                "access_type" => ACCESS_TYPE_RW,
                            ],
                        ]
                    ],
                    [
                        "id" => "CongregationB",
                        "access_type" => ACCESS_TYPE_RW,
                        "branches" => [
                            [
                                "id" => "BranchC",
                                "access_type" => ACCESS_TYPE_R,
                            ],
                            [
                                "id" => "BranchD",
                                "access_type" => ACCESS_TYPE_RW,
                            ],
                        ]
                    ],
                ],
            ],
        ];
    }
}