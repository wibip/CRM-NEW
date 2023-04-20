<?php
$module_controls=[];

$modules = [
    "tab_menu"=>[
        "module"=>"tab_menu/1"
    ],
    "operation"=>[
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
                "module" => "crm/simple"
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
                "module" => "crm/simple"
            ]
        ]
    ],
    "sales_manager" => [
        "crm" => [
            // [
            //     "id"=>"crm_manage",
            //     "name"=>"Manage",
            //     "module"=>"crm_manage/1"
            // ],
            [
                "id" => "crm_create",
                "name" => "Create",
                "module" => "crm/simple"
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
