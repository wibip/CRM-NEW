<?php
$module_controls = [];

$modules = [
    "tab_menu" => [
        "module" => "tab_menu/1"
    ],
    "MVNO" => [
        "network" => [
            [
                "id" => "guestnet_tab_intruduct",
                "name" => "Introduction",
                "module" => "ssid_intro/1"
            ],
            [
                "id" => "guestnet_tab_1",
                "name" => "SSID",
                "module" => "ssid/4"
            ],
            [
                "id" => "guestnet_schedule",
                "name" => "Schedule",
                "module" => "ssid_schedule/1"
            ],
            [
                "id" => "guest_passcode",
                "name" => "Passcode",
                "module" => "guest_passcode/3-optimum"
            ]
        ],
        "reports" => [
            [
                "id" => "customer_report",
                "name" => "Customers",
                "module" => "customer_report/1"
            ],

            [
                "id" => "campaign_report",
                "name" => "Campaign",
                "module" => "reports/1"
            ]
        ],
        /* "theme"=>[
            [
                "id"=>"intro_theme",
                "name"=>"Introduction",
                "module"=>"intro_theme/1"
            ],
            [
                "id"=>"create_theme",
                "name"=>"Create",
                "module"=>"create_theme/9-wysiwyg-theme",
                "submit"=>"create_theme/9-wysiwyg-theme-submit"
            ],
            [
                "id"=>"active_theme",
                "name"=>"Manage",
                "module"=>"active_theme/1"
            ],
            [
                "id"=>"preview_theme",
                "name"=>"Preview",
                "module"=>"preview_theme/1"
            ]
            ], */
        "theme" => [
            [
                "id" => "createTheme",
                "name" => "Create Theme",
                "module" => "create_theme/9-wysiwyg-theme",
                "submit" => "create_theme/8-hospitality-wysiwyg-theme-submit"
            ],
            [
                "id" => "manageTheme",
                "name" => "Manage Splash Page",
                "module" => "active_theme/3-wysiwyg-theme"
            ],
            [
                "id" => "manage_SSID_splash",
                "name" => "Service Area",
                "module" => "manage_SSID_splash/2-hosted"
            ]
        ],
        "service_area" => [
            [
                "id" => "service_area_pr",
                "name" => "Service Area",
                "module" => "service_area_pr/2-altice"
            ],
        ],
        "add_tenant" => [
            [
                "id" => "add_tenant",
                "name" => "Add Resident",
                "module" => "add_tenant/1"
            ],
            [
                "id" => "acc_voucher",
                "name" => "Account Voucher",
                "module" => "dpsk_voucher/2"
            ],
            [
                "id" => "add_tenant_csv",
                "name" => "Mass Account Creation",
                "module" => "tenant_csv/2-altice"
            ]
        ],
        "manage_tenant" => [
            [
                "id" => "tenant_account",
                "name" => "Manage Residents",
                "module" => "tenant_manage/2"
            ],
            [
                "id" => "tenant_session",
                "name" => "Sessions",
                "module" => "tenant_session/1"
            ]
        ],
        "communicate" => [
            [
                "id" => "individual_message",
                "name" => "Individual Message",
                "module" => "mdu_individual_message/1"
            ],
            [
                "id" => "group_message",
                "name" => "Group Message",
                "module" => "mdu_group_message/1"
            ]
        ],
        "venue_support" => [
            [
                "id" => "tier_support",
                "name" => "Tier 1 Support",
                "module" => "tier_support/1-hosted-new"
            ],
            [
                "id" => "access_log",
                "name" => "Access Logs",
                "module" => "access_log/1"
            ],
            [
                "id" => "error_logs",
                "name" => "Error Logs",
                "module" => "error_log/1"
            ],
            [
                "id" => "ap_controler_log",
                "name" => "AP Controller Logs",
                "module" => "ap_controler_log/1"
            ]
        ]
    ],
    "MNO" => [
        "location" => [
            [
                "id" => "active_properties",
                "name" => "Active",
                "module" => "active_properties/1"
            ],
            [
                "id" => "edit_parent",
                "name" => "Edit Business ID Profile",
                "module" => "edit_parent/1"
            ],
            [
                "id" => "create_property",
                "name" => "Create",
                "module" => "create_property/3",
                "submit" => "create_property/submit-property"
            ],
            [
                "id" => "assign_location_admin",
                "name" => "Assign Property Admin",
                "module" => "assign_location_admin/1"
            ],
            [
                "id" => "pending_property",
                "name" => "Pending Account Activation",
                "module" => "pending_property/1"
            ]
        ],
        "session" => [
            [
                "id" => "active_sessions",
                "name" => "Active Sessions",
                "module" => "active_sessions/1"
            ],
            [
                "id" => "historical_sessions",
                "name" => "Historical Sessions",
                "module" => "historical_sessions/1"
            ],
            [
                "id" => "blacklist_mac",
                "name" => "Blacklist",
                "module" => "blacklist_mac/1"
            ]
        ]
    ],
    "SUPPORT" => [
        "location" => [
            [
                "id" => "active_properties",
                "name" => "Active",
                "module" => "active_properties/1"
            ],
            [
                "id" => "edit_parent",
                "name" => "Edit Business ID Profile",
                "module" => "edit_parent/1"
            ],
            [
                "id" => "create_property",
                "name" => "Create",
                "module" => "create_property/3",
                "submit" => "create_property/submit-property"
            ],
            [
                "id" => "assign_location_admin",
                "name" => "Assign Property Admin",
                "module" => "assign_location_admin/1"
            ],
            [
                "id" => "pending_property",
                "name" => "Pending Account Activation",
                "module" => "pending_property/1"
            ]
        ],
        "session" => [
            [
                "id" => "active_sessions",
                "name" => "Active Sessions",
                "module" => "active_sessions/1"
            ],
            [
                "id" => "historical_sessions",
                "name" => "Historical Sessions",
                "module" => "historical_sessions/1"
            ],
            [
                "id" => "blacklist_mac",
                "name" => "Blacklist",
                "module" => "blacklist_mac/1"
            ]
        ]
    ],
    "PROVISIONING" => [
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
            [
                "id"=>"crm_manage",
                "name"=>"Manage",
                "module"=>"crm_manage/1"
            ],
            [
                "id" => "crm_create",
                "name" => "Create",
                "module" => "crm/simple"
            ]
        ]
    ]
];

$automation_on = $package_functions->getSectionType('NETWORK_AUTOMATION', $system_package);
$aaa_type = $package_functions->getOptionsAaa('AAA_TYPE', $system_package);
$pre_paid_enable = false;
if ($user_type == 'MNO') {
    $features_sql = "SELECT `features` AS f FROM exp_mno  WHERE `mno_id`='$user_distributor'";
    $features_json = $db_class1->getValueAsf($features_sql);
    $features = json_decode($features_json, true);
    if (in_array("PREPAID_MODULE_N", $features)) {
        $pre_paid_enable = true;
    }
}
if (($automation_on == 'Yes' && $aaa_type == 'ALE53') || $pre_paid_enable) {
    $loc_arr = [
        [
            "id" => "active_properties",
            "name" => "Active",
            "module" => "active_properties/1"
        ],
        [
            "id" => "edit_parent",
            "name" => "Edit Business ID Profile",
            "module" => "edit_parent/1"
        ],
        [
            "id" => "create_property",
            "name" => "Create",
            "module" => "create_property/5",
            "submit" => "create_property/submit-property"
        ],
        [
            "id" => "assign_location_admin",
            "name" => "Assign Property Admin",
            "module" => "assign_location_admin/1"
        ],
        [
            "id" => "pending_property",
            "name" => "Pending Account Activation",
            "module" => "pending_property/1"
        ]
    ];
    $modules['MNO']['location'] = $loc_arr;
    $modules['SUPPORT']['location'] = $loc_arr;
}

if ($voucher_enable != 'true') {
    $modules['MVNO']['add_tenant'] =
        [
            [
                "id" => "add_tenant",
                "name" => "Add Resident",
                "module" => "add_tenant/1"
            ],
            [
                "id" => "add_tenant_csv",
                "name" => "Mass Account Creation",
                "module" => "tenant_csv/2-altice"
            ]
        ];
}

if (isset($_GET['edit_loc_id'])) {

    $modules['MNO']['location'][2]["name"] = 'Edit';
    $modules['SUPPORT']['location'][2]["name"] = 'Edit';
}

if (isset($_GET['edit']) && strlen($_SESSION['msg5'])>0) {

    $modules['PROVISIONING']['provision'][1]["name"] = 'Edit';
}

if (isset($_POST['multi_area'])) {
    $other_multi_area = 1;
}

if ($package_functions->getPageFeature("campaign", $system_package) == '0') {

    $modules['MVNO']['reports'] = [
        [
            "id" => "customer_report",
            "name" => "Customers",
            "module" => "customer_report/1"
        ]
    ];
}

if (in_array("PREPAID_MODULE_N", $mno_feature)) {
    $modules['MNO']['session'][3] = [
        "id" => "prepaid_plan",
        "name" => "Prepaid",
        "module" => "prepaid_plan/1"
    ];
}

if ($other_multi_area != 1) {
    $modules['MVNO']['theme'] = [
        [
            "id" => "createTheme",
            "name" => "Create Theme",
            "module" => "create_theme/9-wysiwyg-theme",
            "submit" => "create_theme/8-hospitality-wysiwyg-theme-submit"
        ],
        [
            "id" => "manageTheme",
            "name" => "Manage Splash Page",
            "module" => "active_theme/3-wysiwyg-theme"
        ]
    ];
    //echo '*****';
    //    $modules['MVNO']['network'][1]=[
    //        "id"=>"guestnet_tab_1",
    //        "name"=>"SSID",
    //        "module"=>"ssid/1"
    //    ];
    //    $modules['MVNO']['network'][4]=[
    //        "id"=>"guestnet_bandwith",
    //        "name"=>"Bandwidth",
    //        "module"=>"guest_bandwith/1"
    //    ];
    $modules['MVNO']['venue_support'][0] = [
        "id" => "tier_support",
        "name" => "Tier 1 Support",
        "module" => "tier_support/1-new"
    ];

    $modules['MVNO']['network'][1] = [
        "id" => "guestnet_tab_1",
        "name" => "SSID",
        "module" => "ssid/1"
    ];
    $modules['MVNO']['network'][3] = [
        "id" => "guest_passcode",
        "name" => "Passcode",
        "module" => "guest_passcode/1"
    ];
} else {
    $hospitality_feature = true;
}
