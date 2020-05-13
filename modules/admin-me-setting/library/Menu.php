<?php
/**
 * Menu
 * @package admin-me-setting
 * @version 0.0.1
 */

namespace AdminMeSetting\Library;


class Menu
    implements 
        \AdminMeSetting\Iface\Menus
{
    static function getMenus(): array{
        return [
            (object)[
                'label' => 'Profile',
                'route' => ['adminMeSetting', [], []],
                'index' => 1000
            ],
            (object)[
                'label' => 'Password',
                'route' => ['adminMePassword', [], []],
                'index' => 2000
            ]
        ];
    }
}