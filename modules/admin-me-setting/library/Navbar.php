<?php
/**
 * Navbar
 * @package admin-me-setting
 * @version 0.0.1
 */

namespace AdminMeSetting\Library;


class Navbar
    implements 
        \AdminUi\Iface\NavbarMenu
{
    static function getNavbarMenu(object $menu, array $params): array{
        return [];
    }

    static function getSubNavbarMenu(object $menu, object $parent, array $params): array{
        if(!\Mim::$app->user->isLogin())
            return [];

        $result = [
            (object)[
                'label'     => 'Setting',
                'icon'      => '<i class="fas fa-cog"></i>',
                'link'      => \Mim::$app->router->to('adminMeSetting'),
                'priority'  => 50
            ]
        ];

        return $result;
    }
}