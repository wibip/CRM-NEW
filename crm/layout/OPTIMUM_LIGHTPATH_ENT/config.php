<?php
$module_controls=[];

$modules = [
    "tab_menu"=>[
        "module"=>"tab_menu/2",
        "user_type"=>[
            "ADMIN"=>"1",
            "MNO"=>"1",
            "SUPPORT"=>"1",
            "MVNO_ADMIN"=>"2",
            "MVNO"=>"2",
        ]
    ],
    "MVNO"=>[
        "network"=>[
            [
                "id"=>"guestnet_tab_1",
                "name"=>"SSID",
                "module"=>"ssid/4"
            ],
            [
                "id"=>"guestnet_schedule",
                "name"=>"Schedule",
                "module"=>"ssid_schedule/2-optimum"
            ],
            [
                "id"=>"guest_passcode",
                "name"=>"Passcode",
                "module"=>"guest_passcode/3-optimum"

            ]
        ],
        "reports"=>[
            [
                "id"=>"campaign_report",
                "name"=>"Campaign",
                "module"=>"reports/2"
            ]
        ],
        "customer"=>[
            [
                "id"=>"customer_report",
                "name"=>"Customer",
                "module"=>"customer_report/1"
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
                "name"=>"Create Theme",
                "module"=>"create_theme/9-ent-wysiwyg-theme",
                "submit"=>"create_theme/8-hospitality-wysiwyg-theme-submit"
            ],
            [
                "id"=>"manageTheme",
                "name"=>"Manage Splash Page",
                "module"=>"active_theme/4-wysiwyg-theme"
            ],
            [
                "id"=>"manage_SSID_splash",
                "name"=>"Service Area",
                "module"=>"manage_SSID_splash/2-altice"
            ]
        ],
        "add_tenant"=>[
            [
                "id"=>"add_tenant",
                "name"=>"Add Resident",
                "module"=>"add_tenant/1"
            ],
            [
                "id"=>"acc_voucher",
                "name"=>"Account Voucher",
                "module"=>"dpsk_voucher/2"
            ],
            [
                "id"=>"add_tenant_csv",
                "name"=>"Mass Account Creation",
                "module"=>"tenant_csv/2-altice"
            ]
        ],
        "manage_tenant"=>[
            [
                "id"=>"tenant_account",
                "name"=>"Manage Residents",
                "module"=>"tenant_manage/1"
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
                "name"=>"Onboarding",
                "module"=>"tier_support/1-hosted"
            ],
            [
                "id"=>"blacklist_mac",
                "name"=>"Blacklist",
                "module"=>"blacklist_mac/3"
            ]
        ],
        "network_mdo"=>[
            [
                "id"=>"mdo_ssid_manage",
                "name"=>"MDO",
                "module"=>"mdo_ssid/1"
            ],
        ],
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
                "module"=>"edit_parent/3"
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
                "module"=>"blacklist_mac/3"
            ],
            [
                "id"=>"cf_reports",
                "name"=>"Reports",
                "module"=>"CF_Report/1"
            ]
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
                "module"=>"edit_parent/3"
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
                "module"=>"blacklist_mac/3"
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
    ],
    "MVNO_ADMIN"=>[
        "session"=>[
            [
                "id"=>"blacklist_mac",
                "name"=>"Blacklist",
                "module"=>"blacklist_mac/3"
            ]
        ]
    ]

];


if(!$voucher_enable){
    $modules['MVNO']['add_tenant'] =
    [
            [
                "id"=>"add_tenant",
                "name"=>"Add Resident",
                "module"=>"add_tenant/1"
            ],
            [
                "id"=>"add_tenant_csv",
                "name"=>"Mass Account Creation",
                "module"=>"tenant_csv/2-altice"
            ] 
        ];

}

if($network_type=='GUEST' || $network_type=='BOTH' || $network_type=='VT-BOTH'){
    $modules['MVNO']['venue_support'] =
    [
        [
            "id"=>"tier_support",
            "name"=>"Onboarding",
            "module"=>"tier_support/1-hosted"
        ],
        [
            "id"=>"blacklist_mac",
            "name"=>"Blacklist",
            "module"=>"blacklist_mac/3"
        ],
        [
            "id"=>"content_filter",
            "name"=>"Features",
            "module"=>"content_filter/1",
            "submit"=>"content_filter/content_filter-submit"
        ]
    ];
}


if(isset($_POST['multi_area'])){
    $other_multi_area = 1;
}


if ($_SESSION['s_token']) {
    
    $modules['MVNO']['venue_support']=[
            [
                "id"=>"tier_support",
                "name"=>"Support",
                "module"=>"tier_support/1-hosted"
            ],
            [
                "id"=>"access_log",
                "name"=>"Access Logs",
                "module"=>"access_log/1"
            ],
            [
                "id"=>"error_logs",
                "name"=>"Error Logs",
                "module"=>"error_log/1"
            ],
            [
                "id"=>"ap_controler_log",
                "name"=>"AP Controller Logs",
                "module"=>"ap_controler_log/1"
            ]
    ];
}

if($other_multi_area!=1){
    $modules['MVNO']['theme'] = [
        [
            "id"=>"createTheme",
            "name"=>"Create Theme",
            "module"=>"create_theme/9-ent-wysiwyg-theme",
            "submit"=>"create_theme/8-hospitality-wysiwyg-theme-submit"
        ],
        [
            "id"=>"manageTheme",
            "name"=>"Manage Splash Page",
            "module"=>"active_theme/4-wysiwyg-theme"
        ]
    ];

    $modules['MVNO']['venue_support'][0]=[
        "id"=>"tier_support",
        "name"=>"Tier 1 Support",
        "module"=>"tier_support/1"
    ];
    
}else{
    $hospitality_feature = true;
}

$modules_text = [
    "MVNO"=>[
        "customer"=>[
                "search_btn_tooltip"=>"Search on the Guest Client Device MAC, First Name, Last Name or Mobile number",
        ]
    ]
];
