<?php

define('ACCESS',[
    'super_admin' => [
        'modules'=>[
            'users'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'operators'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'operator_config'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'operator_regions'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'operator_realms'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'operator_ipscope'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'property_addressing'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'crm'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'order_templates'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'properties'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'property_additional'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'api_profile'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'central_db'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'config'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'logs'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
        ],
        'home' => 'users',
        'superior_level' => 1
    ],
    'admin' => [
        'modules'=>[
            'users'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'crm'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'properties'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'property_additional'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'api_profile'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'central_db'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'config'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'logs'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
        ],
        'home' => 'users',
        'superior_level' => 2
    ],
    'operation' => [
        'modules'=>[
            'users'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'crm'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'properties'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'property_additional'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
        ],
        'home' => 'properties',
        'superior_level' => 3
    ],    
    'sales_manager' => [
        'modules'=>[
            'users'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            // 'crm'=>[
            //     'create' =>[
            //         'actions'=>['create']
            //     ],
            //     'manage'=>[
            //         'actions'=>['edit','delete']
            //     ],
            // ],
            'properties'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'property_additional'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
        ],
        'home' => 'properties',
        'superior_level' => 4
    ],
    'ordering_agent' => [
        'modules'=>[
            'crm'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'properties'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ]
        ],
        'home' => 'properties',
        'superior_level' => 5
    ],
]);