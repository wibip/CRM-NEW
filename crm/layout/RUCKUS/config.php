<?php
$module_controls=[];
$modules = [
    "tab_menu"=>[
        "module"=>"tab_menu/1"
    ],
    "MVNO"=>[
        "network"=>[
            [
                "id"=>"guestnet_tab_1",
                "name"=>"SSID",
                "module"=>"ssid/5"
            ],
            [
                "id"=>"guestnet_schedule",
                "name"=>"Schedule",
                "module"=>"ssid_schedule/4"
            ],
            [
                "id"=>"guest_passcode",
                "name"=>"Passcode",
                "module"=>"guest_passcode/4"
            ]

        ],
        "campaign_ad" => [
            [
                "id" => "create_campaign",
                "name" => "Create",
                "module" => "create_campaign/2"
            ],
            [
                "id" => "manage_campaign",
                "name" => "Manage",
                "module" => "manage_campaign/2"
            ]
        ],
        "reports"=>[
            [
                "id" => "customer_report",
                "name" => "Customers",
                "module" => "customer_report/1"
            ],
            [
                "id"=>"campaign_report",
                "name"=>"Campaign",
                "module"=>"reports/2"
            ]
        ],
        "service_area"=>[
            [
                "id"=>"service_area_pr",
                "name"=>"Service Area",
                "module"=>"service_area_pr/2-altice"
            ],
        ],
        "theme"=>[
            [
                "id"=>"createTheme",
                "name"=>"Splash Page Editor",
                "module"=>"create_theme/10-wysiwyg-theme",
                "submit"=>"create_theme/8-hospitality-wysiwyg-theme-submit"
            ],
            [
                "id"=>"manageTheme",
                "name"=>"Manage Splash Page",
                "module"=>"active_theme/5-wysiwyg-theme"
            ],
            [
                "id"=>"manage_SSID_splash",
                "name"=>"Service Area",
                "module"=>"manage_SSID_splash/3"
            ]
        ],
        "add_tenant"=>[
            [
                "id"=>"add_tenant",
                "name"=>"Add Resident",
                "module"=>"add_tenant/2"
            ],
            [
                "id"=>"acc_voucher",
                "name"=>"Account Voucher",
                "module"=>"dpsk_voucher/3"
            ]
        ],
        "manage_tenant"=>[
            [
                "id"=>"tenant_account",
                "name"=>"Manage Residents",
                "module"=>"tenant_manage/3"
            ],
            [
                "id" => "tenant_recovery",
                "name" => "Recover Residents",
                "module" => "tenant_recovery/1"
            ],
            [
                "id"=>"tenant_session",
                "name"=>"Sessions",
                "module"=>"tenant_session/1"
            ]
        ],
        "communicate"=>[
            [
                "id"=>"individual_message",
                "name"=>"Message",
                "module"=>"mdu_individual_message/2"
            ]
        ],
        "venue_support"=>[
            [
                "id"=>"tier_support",
                "name"=>"Tier 1 Support",
                "module"=>"tier_support/5"
            ],
            [
                "id"=>"access_log",
                "name"=>"Access Logs",
                "module"=>"access_log/2"
            ],
            [
                "id"=>"error_logs",
                "name"=>"Error Logs",
                "module"=>"error_log/2"
            ],
            [
                "id"=>"ap_controler_log",
                "name"=>"AP Controller Logs",
                "module"=>"ap_controler_log/2"
            ]
        ],
        "network_mdo"=>[
            [
                "id"=>"mdo_ssid_manage",
                "name"=>"MDO",
                "module"=>"mdo_ssid/1"
            ],
        ],
        "content_filter"=>[
            [
                "id"=>"content_filter",
                "name"=>"Content Filtering",
                "module"=>"content_filter_location/1"
            ]
        ]
    ],
    "MNO"=>[
        "location"=>[
            [
                "id"=>"active_properties",
                "name"=>"Active",
                "module"=>"active_properties/1"
            ],
            [
                "id"=>"edit_parent",
                "name"=>"Edit Business ID Profile",
                "module"=>"edit_parent/4"
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
                "id"=>"blacklist_mac",
                "name"=>"Blacklist",
                "module"=>"blacklist_mac/1"
            ],
            [
                "id"=>"cf_reports",
                "name"=>"Reports",
                "module"=>"CF_Report/1"
            ],
            // [
            //     "id"=>"feature_reports",
            //     "name"=>"Feature Reports",
            //     "module"=>"feature_reports/1"
            // ]
        ]
    ],
    "SUPPORT"=>[
        "location"=>[
            [
                "id"=>"active_properties",
                "name"=>"Active",
                "module"=>"active_properties/1"
            ],
            [
                "id"=>"edit_parent",
                "name"=>"Edit Business ID Profile",
                "module"=>"edit_parent/4"
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
                "id"=>"blacklist_mac",
                "name"=>"Blacklist",
                "module"=>"blacklist_mac/1"
            ],
            [
                "id"=>"cf_reports",
                "name"=>"Reports",
                "module"=>"CF_Report/1"
            ]
        ]
    ],
    "ADMIN"=>[
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
        ]
    ]
];
if ($edit == 1) {
    $modules['MVNO']['content_filter'][1]['name'] = "URL Filtering Edit";
}

if(!$voucher_enable){
    $modules['MVNO']['add_tenant'] =
    [
            [
                "id"=>"add_tenant",
                "name"=>"Add Resident",
                "module"=>"add_tenant/2"
            ]
        ];

}

if(isset($_GET['edit_loc_id'])){

    $modules['MNO']['location'][2]["name"] = 'Edit';
    $modules['SUPPORT']['location'][2]["name"] = 'Edit';
}

if(isset($_POST['multi_area'])){
    $other_multi_area = 1;
}

if($other_multi_area!=1){
    $modules['MVNO']['theme'] = [
        [
            "id"=>"createTheme",
            "name"=>"Splash Page Editor",
            "module"=>"create_theme/10-wysiwyg-theme",
            "submit"=>"create_theme/8-hospitality-wysiwyg-theme-submit"
        ],
        [
            "id"=>"manageTheme",
            "name"=>"Manage Splash Page",
            "module"=>"active_theme/5-wysiwyg-theme"
        ]
    ];

    $modules['MVNO']['venue_support'][0]=[
        "id"=>"tier_support",
        "name"=>"Tier 1 Support",
        "module"=>"tier_support/5"
    ];

    $modules['MVNO']['network'][0]=[
        "id"=>"guestnet_tab_1",
        "name"=>"SSID",
        "module"=>"ssid/5"
    ];

}else{
    $hospitality_feature = true;
}

if ($property_wired == '1') {
    $modules['MVNO']['venue_support'][0]=[
        "id"=>"tier_support",
        "name"=>"Tier 1 Support",
        "module"=>"tier_support/4-wired"
    ];
}
