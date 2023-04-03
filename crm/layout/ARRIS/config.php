<?php
$module_controls=[];

$modules = [
    "tab_menu"=>[
        "module"=>"tab_menu/1"
    ],
    // "MVNO"=>[
    //     "network"=>[
    //         [
    //             "id"=>"guestnet_tab_intruduct",
    //             "name"=>"Introduction",
    //             "module"=>"ssid_intro/1"
    //         ],
    //         [
    //             "id"=>"guestnet_tab_1",
    //             "name"=>"SSID",
    //             "module"=>"ssid/2"
    //         ],
    //         [
    //             "id"=>"guestnet_schedule",
    //             "name"=>"Schedule",
    //             "module"=>"ssid_schedule/1"
    //         ]
    //     ],
    //     "reports"=>[
    //         [
    //             "id"=>"customer_report",
    //             "name"=>"Customers",
    //             "module"=>"customer_report/1"
    //         ],
            
    //         [
    //             "id"=>"campaign_report",
    //             "name"=>"Campaign",
    //             "module"=>"reports/1"
    //         ]
    //     ],
    //     "add_tenant"=>[
    //         [
    //             "id"=>"add_tenant",
    //             "name"=>"Add Resident",
    //             "module"=>"add_tenant/1"
    //         ],
    //         [
    //             "id"=>"tenant_session",
    //             "name"=>"Sessions",
    //             "module"=>"tenant_session/1"
    //         ]
    //     ],
    //     "manage_tenant"=>[
    //         [
    //             "id"=>"tenant_account",
    //             "name"=>"Manage Residents",
    //             "module"=>"tenant_manage/2"
    //         ],
    //         [
    //             "id"=>"tenant_session",
    //             "name"=>"Sessions",
    //             "module"=>"tenant_session/1"
    //         ]
    //     ],
    //     "communicate"=>[
    //         [
    //             "id"=>"individual_message",
    //             "name"=>"Individual Message",
    //             "module"=>"mdu_individual_message/1"
    //         ],
    //         [
    //             "id"=>"group_message",
    //             "name"=>"Group Message",
    //             "module"=>"mdu_group_message/1"
    //         ]
    //     ],
    //     "theme"=>[
    //         [
    //             "id"=>"intro_theme",
    //             "name"=>"Introduction",
    //             "module"=>"intro_theme/1"
    //         ],
    //         [
    //             "id"=>"createTheme",
    //             "name"=>"Create Theme",
    //             "module"=>"create_theme/8-hospitality-wysiwyg-theme",
    //             "submit"=>"create_theme/8-hospitality-wysiwyg-theme-submit"
    //         ],
    //         [
    //             "id"=>"manageTheme",
    //             "name"=>"Manage Splash Page",
    //             "module"=>"active_theme/3-wysiwyg-theme"
    //         ]
    //     ],
    //     "venue_support"=>[
    //         [
    //             "id"=>"tier_support",
    //             "name"=>"Tier 1 Support",
    //             "module"=>"tier_support/1"
    //         ],
    //         [
    //             "id"=>"access_log",
    //             "name"=>"Access Logs",
    //             "module"=>"access_log/1"
    //         ],
    //         [
    //             "id"=>"error_logs",
    //             "name"=>"Error Logs",
    //             "module"=>"error_log/1"
    //         ],
    //         [
    //             "id"=>"ap_controler_log",
    //             "name"=>"AP Controller Logs",
    //             "module"=>"ap_controler_log/1"
    //         ]
    //     ]
    // ],
    "operation"=>[
        "crm" => [
            // [
            //     "id"=>"crm_manage",
            //     "name"=>"Manage",
            //     "module"=>"crm_manage/1"
            // ],
            [
                "id" => "crm_create",
                "name" => "Create",
                "module" => "crm/1"
            ]
        ],
        "location"=>[
            [
                "id"=>"active_properties",
                "name"=>"Active",
                "module"=>"active_properties/1"
            ],
            [
                "id"=>"edit_parent",
                "name"=>"Edit Business ID Profile",
                "module"=>"edit_parent/1"
            ],
            [
                "id"=>"create_property",
                "name"=>"Create",
                "module"=>"create_property/5",
                "submit"=>"create_property/submit-property"
            ],
            [
                "id"=>"assign_location_admin",
                "name"=>"Assign Property Admin",
                "module"=>"assign_location_admin/1"
            ],
            [
                "id"=>"pending_property",
                "name"=>"Pending Account Activation",
                "module"=>"pending_property/1"
            ]
        ],
        "session"=>[
            [
                "id"=>"active_sessions",
                "name"=>"Active Sessions",
                "module"=>"active_sessions/1"
            ],
            [
                "id"=>"historical_sessions",
                "name"=>"Historical Sessions",
                "module"=>"historical_sessions/1"
            ],
            [
                "id"=>"blacklist_mac",
                "name"=>"Blacklist",
                "module"=>"blacklist_mac/1"
            ]
        ]
    ],
    // "SUPPORT"=>[
    //     "location"=>[
    //         [
    //             "id"=>"active_properties",
    //             "name"=>"Active",
    //             "module"=>"active_properties/1"
    //         ],
    //         [
    //             "id"=>"edit_parent",
    //             "name"=>"Edit Business ID Profile",
    //             "module"=>"edit_parent/1"
    //         ],
    //         [
    //             "id"=>"create_property",
    //             "name"=>"Create",
    //             "module"=>"create_property/5",
    //             "submit"=>"create_property/submit-property"
    //         ],
    //         [
    //             "id"=>"assign_location_admin",
    //             "name"=>"Assign Property Admin",
    //             "module"=>"assign_location_admin/1"
    //         ],
    //         [
    //             "id"=>"pending_property",
    //             "name"=>"Pending Account Activation",
    //             "module"=>"pending_property/1"
    //         ]
    //     ],
    //     "session"=>[
    //         [
    //             "id"=>"active_sessions",
    //             "name"=>"Active Sessions",
    //             "module"=>"active_sessions/1"
    //         ],
    //         [
    //             "id"=>"historical_sessions",
    //             "name"=>"Historical Sessions",
    //             "module"=>"historical_sessions/1"
    //         ],
    //         [
    //             "id"=>"blacklist_mac",
    //             "name"=>"Blacklist",
    //             "module"=>"blacklist_mac/1"
    //         ]
    //     ]
    // ],
	"admin"=>[
        "location"=>[
            [
                "id"=>"active_mno",
                "name"=>"Active Operations",
                "module"=>"active_mno/1"
            ],
            [
                "id"=>"create_mno",
                "name"=>"Create Operations Account",
                "module"=>"create_mno/1"
            ],
            [
                "id"=>"pending_mno",
                "name"=>"Pending Account Activation Operations",
                "module"=>"pending_mno/1"
            ],
        ],
        "crm" => [
            // [
            //     "id"=>"crm_manage",
            //     "name"=>"Manage",
            //     "module"=>"crm_manage/1"
            // ],
            [
                "id" => "crm_create",
                "name" => "Create",
                "module" => "crm/1"
            ]
        ]
    ],
    "super_admin"=>[
        "crm" => [
            // [
            //     "id"=>"crm_manage",
            //     "name"=>"Manage",
            //     "module"=>"crm_manage/1"
            // ],
            [
                "id" => "crm_create",
                "name" => "Create",
                "module" => "crm/1"
            ]
        ]
    ],
    "ordering_agent" => [
        "provision" => [
            [
                "id"=>"provision_manage",
                "name"=>"Manage",
                "module"=>"provision_manage/1"
            ],
            [
                "id" => "provision_create",
                "name" => "Create",
                "module" => "provision/1",
                "submit"=>"create_property/submit-property-prov"
            ],
        ],
        "crm" => [
            // [
            //     "id"=>"crm_manage",
            //     "name"=>"Manage",
            //     "module"=>"crm_manage/1"
            // ],
            [
                "id" => "crm_create",
                "name" => "Create",
                "module" => "crm/1"
            ]
        ]
    ]
];
