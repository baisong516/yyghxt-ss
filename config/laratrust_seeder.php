<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'hospitals' => 'c,r,u,d',
            'offices' => 'c,r,u,d',
            'diseases' => 'c,r,u,d',
            'doctors' => 'c,r,u,d',
            'departments' => 'c,r,u,d',
            'zx_customers' => 'c,r,u,d',
            'mz_customers' => 'r,u',
            'gh_customers' => 'r,u,d',
            'customer_types' => 'c,r,u,d',
            'web_types' => 'c,r,u,d',
            'customer_conditions' => 'c,r,u,d',
            'medias' => 'c,r,u,d',
            'huifangs' => 'c,r,u,d',
            'arrangements' => 'c,r,u,d',
            'profiles' => 'r,u',
            'zx_excels'=>'c'
        ],
        'administrator' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'profile' => 'c,r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
