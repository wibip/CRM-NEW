n<?php
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
                "module" => "ssid/2"
            ],
            [
                "id" => "guestnet_schedule",
                "name" => "Schedule",
                "module" => "ssid_schedule/1"
            ],
            [
                "id" => "guest_passcode",
                "name" => "Passcode",
                "module" => "guest_passcode/2"

            ]
        ],
        "customer" => [
            [
                "id" => "customer_report",
                "name" => "Connected Guests",
                "module" => "customer_report/1"
            ]
        ],
        "theme" => [
            [
                "id" => "intro_theme",
                "name" => "Introduction",
                "module" => "intro_theme/2-hos"
            ],
            [
                "id" => "createTheme",
                "name" => "Create Splash Page",
                "module" => "create_theme/8-hospitality-wysiwyg-theme",
                "submit" => "create_theme/8-hospitality-wysiwyg-theme-submit"
            ],
            [
                "id" => "manageTheme",
                "name" => "Manage Splash Page",
                "module" => "manage_splash_page/2"
            ],
            [
                /* "id"=>"active_theme",
                "name"=>"Manage",
                "module"=>"active_theme/1" */
                "id" => "manage_SSID_splash",
                "name" => "Service Area",
                "module" => "manage_SSID_splash/1"
            ],
            [
                "id" => "config_splash_page",
                "name" => "Config",
                "module" => "theme_config/1",
                "submit" => "theme_config/1-submit"
            ]
        ],
        "power_schedule" => [
            [
                "id" => "guestnet_schedule",
                "name" => "Guest Schedule",
                "module" => "ssid_schedule/1"
            ],
            [
                "id" => "private_schedule",
                "name" => "Private Schedule",
                "module" => "private_schedule/1"
            ]
        ],
        "venue_support" => [
            [
                "id" => "tier_support",
                "name" => "Tier 1 Support",
                "module" => "tier_support/1-cox"
            ],            [
                "id" => "ap_controler_log",
                "name" => "AP Controller Logs",
                "module" => "ap_controler_log/1"
            ],            [
                "id" => "property_activity_log",
                "name" => "Property Activity Logs",
                "module" => "property_active_log/1"
            ]
        ],
        "service_area" => [
            [
                "id" => "service_area_pr",
                "name" => "Service Area",
                "module" => "service_area_pr/1"
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
                "module" => "dpsk_voucher/1"
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
                "module" => "create_property/2-ap-group",
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
                "module" => "active_sessions/2"
            ],
            [
                "id" => "historical_sessions",
                "name" => "Historical Sessions",
                "module" => "historical_sessions/2"
            ],
            [
                "id" => "blacklist_mac",
                "name" => "Blacklist",
                "module" => "blacklist_mac/2"
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
                "module" => "create_property/2-ap-group",
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
                "module" => "active_sessions/2"
            ],
            [
                "id" => "historical_sessions",
                "name" => "Historical Sessions",
                "module" => "historical_sessions/2"
            ],
            [
                "id" => "blacklist_mac",
                "name" => "Blacklist",
                "module" => "blacklist_mac/2"
            ]
        ]
    ],
    "ADMIN" => [
        "location" => [
            [
                "id" => "active_mno",
                "name" => "Active Operations",
                "module" => "active_mno/1"
            ],
            [
                "id" => "create_mno",
                "name" => "Create Operations Account",
                "module" => "create_mno/1"
            ],
            [
                "id" => "pending_mno",
                "name" => "Pending Account Activation Operations",
                "module" => "pending_mno/1"
            ],
        ]
    ]
];

if (isset($_POST['multi_area'])) {
    $other_multi_area = 1;
}

if ($other_multi_area != 1) {
    $modules['MVNO']['theme'] = [
        [
            "id" => "intro_theme",
            "name" => "Introduction",
            "module" => "intro_theme/1"
        ],
        [
            "id" => "createTheme",
            "name" => "Create Splash Page",
            "module" => "create_theme/8-hospitality-wysiwyg-theme",
            "submit" => "create_theme/8-hospitality-wysiwyg-theme-submit"
        ],
        [
            "id" => "manageTheme",
            "name" => "Manage Splash Page",
            "module" => "active_theme/3-wysiwyg-theme"
        ],
        [
            "id" => "config_splash_page",
            "name" => "Config",
            "module" => "theme_config/1",
            "submit" => "theme_config/1-submit"
        ]
    ];

    $modules['MVNO']['network'][1] = [
        "id" => "guestnet_tab_1",
        "name" => "SSID",
        "module" => "ssid/1"
    ];
    $modules['MVNO']['network'][4] = [
        "id" => "guestnet_bandwith",
        "name" => "Bandwidth",
        "module" => "guest_bandwith/1"
    ];
} else {
    $wysywyg_editor = true;
    $hospitality_feature = true;
}

if (!$voucher_enable) {
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

$vt_enable = $package_functions->getOptions('VTENANT_MODULE', $system_package);
if ($vt_enable == 'Vtenant') {
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
    ];
    $modules['MNO']['location'] = $loc_arr;
    $modules['SUPPORT']['location'] = $loc_arr;


    $network_arr = [
        [
            "id"=>"guestnet_tab_intruduct",
            "name"=>"Introduction",
            "module"=>"ssid_intro/1"
        ],
        [
            "id"=>"guestnet_tab_1",
            "name"=>"SSID",
            "module"=>"ssid/4"
        ],
        [
            "id"=>"guestnet_schedule",
            "name"=>"Schedule",
            "module"=>"ssid_schedule/1"
        ],
        [
            "id"=>"guest_passcode",
            "name"=>"Passcode",
            "module"=>"guest_passcode/2"

        ]
        ];
    $modules['MVNO']['network'] = $network_arr;

}
$automation_on = $package_functions->getSectionType('NETWORK_AUTOMATION', $system_package);
$aaa_type = $package_functions->getOptionsAaa('AAA_TYPE', $system_package);

if ($automation_on == 'Yes' && $aaa_type == 'ALE53') {
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

if (isset($_GET['edit_loc_id'])) {

    $modules['MNO']['location'][2]["name"] = 'Edit';
    $modules['SUPPORT']['location'][2]["name"] = 'Edit';
}

$modules_text = [
    "MVNO" => [
        "customer" => [
            "customerTxt" => "Guest Details",
            "tabName" => "Connected Guests",
            "search_customer_input_label" => "Search Guest Details",
            "search_btn_tooltip" => "Search on the Guest Client Device MAC, First Name, Last Name or Mobile number",
            "download_btn_txt" => "Download",
            "header_hide" => "true"
        ]
    ]
];
