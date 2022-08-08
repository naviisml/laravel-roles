<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Role
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

    'default' => [
        '@default'
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

    'roles' => [
        [
            'name' => 'User',
            'tag' => '@default',
            'permissions' => [
                'interact' => true,
                'user.user-logs' => true,
                'user.edit-profile' => true,
                'user.edit-password' => true
            ],
            'default' => true
        ],
        [
            'name' => 'Admin',
            'tag' => '@admin',
            'permissions' => [
                'admin' => true,
                'admin.users' => true,
                'admin.user.get' => true,
                'admin.user.edit' => true,
                'admin.user.roles' => true,
                'admin.user.roles.assign' => true,
                'admin.user.roles.delete' => true,
                'admin.user.logs' => true,
                'admin.roles' => true,
                'admin.role.edit' => true,
            ]
        ],
        [
            'name' => 'Banned',
            'tag' => '@banned',
            'permissions' => [
                'interact' => false
            ]
        ]
    ]
];
