<?php

return [
    '__name' => 'admin-me-setting',
    '__version' => '0.0.5',
    '__git' => 'git@github.com:getmim/admin-me-setting.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-me-setting' => ['install','update','remove'],
        'theme/admin/me/setting/profile.phtml' => ['install','update','remove'],
        'theme/admin/me/setting/password.phtml' => ['install','update','remove'],
        'theme/admin/layout/admin-me-setting.phtml' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'AdminMeSetting\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin-me-setting/system/Controller.php',
                'children' => 'modules/admin-me-setting/controller'
            ],
            'AdminMeSetting\\Library' => [
                'type' => 'file',
                'base' => 'modules/admin-me-setting/library'
            ],
            'AdminMeSetting\\Iface' => [
                'type' => 'file',
                'base' => 'modules/admin-me-setting/interface'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'admin' => [
            'adminMeSetting' => [
                'path' => [
                    'value' => '/me/setting'
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminMeSetting\\Controller\\Account::profile'
            ],
            'adminMePassword' => [
                'path' => [
                    'value' => '/me/password'
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminMeSetting\\Controller\\Account::password'
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'admin.me.setting.password' => [
                'old-password' => [
                    'label' => 'Current Password',
                    'nolabel' => true,
                    'type' => 'password',
                    'rules' => [
                        'required' => true
                    ]
                ],
                'new-password' => [
                    'label' => 'New Password',
                    'nolabel' => true,
                    'type' => 'password',
                    'meter' => true,
                    'rules' => [
                        'required' => true,
                        'length' => [
                            'min' => 6
                        ]
                    ]
                ],
                'retype-password' => [
                    'label' => 'Retype Password',
                    'nolabel' => true,
                    'type' => 'password',
                    'rules' => [
                        'required' => true
                    ]
                ]
            ],
            'admin.me.setting.profile' => [
                'name' => [
                    'label' => 'Username',
                    'type' => 'text',
                    'xpos' => 'center',
                    'xindex' => 0,
                    'rules' => [
                        'empty' => FALSE,
                        'text' => 'alnumdash',
                        'unique' => [
                            'model' => 'LibUser\\Library\\Fetcher',
                            'field' => 'name',
                            'self' => [
                                'service' => 'user.id',
                                'field' => 'id'
                            ]
                        ]
                    ]
                ],
                'fullname' => [
                    'label' => 'Fullname',
                    'type' => 'text',
                    'xpos' => 'center',
                    'xindex' => 1,
                    'rules' => [
                        'empty' => FALSE
                    ]
                ],
                'avatar' => [
                    'label' => 'Avatar',
                    'type' => 'image',
                    'xpos' => 'left',
                    'xindex' => 0,
                    'form' => 'std-image',
                    'modules' => ['lib-upload'],
                    'rules' => [
                        'upload' => 'std-image'
                    ]
                ]
            ]
        ]
    ],
    'adminUi' => [
        'navbarMenu' => [
            'handlers' => [
                'me-setting' => [
                    'class' => 'AdminMeSetting\\Library\\Navbar',
                    'parent' => 'me-auth'
                ]
            ]
        ]
    ],
    'adminMeSetting' => [
        'menus' => [
            'admin-me-setting' => 'AdminMeSetting\\Library\\Menu'
        ]
    ]
];
