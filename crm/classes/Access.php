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
            'user'=>[
                'create' =>[
                    'actions'=>['create']
                ],
                'manage'=>[
                    'actions'=>['edit','delete']
                ],
            ],
            'operations'=>[
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
        'home' => 'users'
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
    
    'sales_manager' => [
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