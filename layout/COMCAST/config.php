<?php
$module_controls=[];

$modules = [
    "tab_menu"=>[
        "module"=>"tab_menu/1"
    ],
    "MVNO"=>[
        "network"=>[
            [
                "id"=>"guestnet_tab_intruduct",
                "name"=>"Introduction",
                "module"=>"ssid_intro/1"
            ],
            [
                "id"=>"guestnet_tab_1",
                "name"=>"SSID",
                "module"=>"ssid/1"
            ],
            [
                "id"=>"guestnet_schedule",
                "name"=>"Schedule",
                "module"=>"ssid_schedule/1"
            ],
            [
                "id"=>"guest_passcode",
                "name"=>"Passcode",
                "module"=>"guest_passcode/1"
            ]
        ],
        "reports"=>[
            [
                "id"=>"customer_report",
                "name"=>"Customers",
                "module"=>"customer_report/1"
            ],
            
            [
                "id"=>"campaign_report",
                "name"=>"Campaign",
                "module"=>"reports/1"
            ]
        ],
        "theme"=>[
            [
                "id"=>"intro_theme",
                "name"=>"Introduction",
                "module"=>"intro_theme/1"
            ],
            [
                "id"=>"create_theme",
                "name"=>"Create",
                "module"=>"create_theme/7"
            ],
            [
                "id"=>"active_theme",
                "name"=>"Manage",
                "module"=>"active_theme/1"
            ],
            [
                "id"=>"preview_theme",
                "name"=>"Preview",
                "module"=>"preview_theme/7"
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
                "module"=>"edit_parent/1"
            ],
            [
                "id"=>"create_property",
                "name"=>"Create",
                "module"=>"create_property/1"
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
                "module"=>"edit_parent/1"
            ],
            [
                "id"=>"create_property",
                "name"=>"Create",
                "module"=>"create_property/1"
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
        ]
    ]
];

$automation_on = $package_functions->getSectionType('NETWORK_AUTOMATION', $system_package);
$aaa_type = $package_functions->getOptionsAaa('AAA_TYPE', $system_package);

if ($automation_on == 'Yes' && $aaa_type == 'ALE53'){
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

if($package_functions->getPageFeature("campaign", $system_package)=='0'){

    $modules['MVNO']['reports'] = [
        [
            "id" => "customer_report",
            "name" => "Customers",
            "module" => "customer_report/1"
        ]
    ];
}

if($script=='theme'){
    if(!isset($_GET['t'])){
        $_GET['t']='create_theme';
    }
}