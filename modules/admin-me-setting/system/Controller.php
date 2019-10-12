<?php
/**
 * AccountController
 * @package admin-me-setting
 * @version 0.0.1
 */

namespace AdminMeSetting;

class Controller extends \Admin\Controller
{
    public function resp(string $view, array $params=[], string $layout='default'){
        $bcrumb = [
            ['Home', $this->router->to('adminHome')],
            ['Setting', '#0'],
            [$params['_meta']['title'], '#']
        ];

        $menus = [];
        $handlers = (array)$this->config->adminMeSetting->menus;
        foreach($handlers as $class)
            $menus = array_merge($menus, $class::getMenus());
        $croute = $this->req->route->name;

        foreach($menus as &$menu){
            $menu->active = $croute == $menu->route[0];
            $menu->link = $this->router->to($menu->route[0], $menu->route[1], $menu->route[2]);
        }
        unset($menu);
        usort($menus, function($a,$b){ return $a->index - $b->index; });

        $params['_meta']['subtitle'] = $params['_meta']['title'];
        $params['_meta']['title']    = 'Setting';
        $params['_meta']['bcrumb']   = $bcrumb;
        $params['_meta']['menus']    = $menus;

        parent::resp($view, $params, 'admin-me-setting');
    }
}