<?php

define('ACCESS',[
    'admin' => [
        'modules'=>[
            'operations'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'user'=>[],
            'api_profile'=>[],
            'config'=>[],
            'logs'=>[],
        ],
        'home' => 'operations'
    ],
    'super_admin' => [
        'modules'=>[
            'operations'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'user'=>[
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
        'home' => 'operations'
    ],
    'operation' => [
        'modules'=>[
            'crm'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'properties'=>[],
        ],
        'home' => 'properties'
    ],
    
    'sales_mng' => [
        'modules'=>[
            'crm'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'user'=>[],
            'api_profile'=>[],
            'config'=>[],
            'logs'=>[],
        ],
        'home' => 'operations'
    ],
    'client' => [
        'modules'=>[
            'crm'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'properties'=>[],
        ],
        'home' => 'crm'
    ],
]);