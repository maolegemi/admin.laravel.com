<?php

namespace App\Http\Models\Common;

use App\Http\Models\Common\Basic;
use Session;
use Route;

class Menu extends Basic
{
    public function getMenuList()
    {
        $retArr      = [];
        $admin       = Session::get('admin');
        $permissions = $admin['admin_permission'];
        foreach ($permissions as $k => $v) {
            if ($v['isshow']) {
                if ($v['inherit_id'] == 0) {
                    $retArr[$v['id']]['id']   = $v['id'];
                    $retArr[$v['id']]['name'] = $v['name'];
                    $retArr[$v['id']]['url']  = $v['request_uri'];
                    $retArr[$v['id']]['css']  = $v['css'] ? $v['css'] : 'fa-slack text-red';
                    if (!isset($retArr[$v['id']]['children'])) {
                        $retArr[$v['id']]['children'] = [];
                    }
                } else {
                    $retArr[$v['inherit_id']]['children'][$v['id']]['id']   = $v['id'];
                    $retArr[$v['inherit_id']]['children'][$v['id']]['name'] = $v['name'];
                    $retArr[$v['inherit_id']]['children'][$v['id']]['css']  = $v['css'] ? $v['css'] : 'fa-slack text-red';
                    $retArr[$v['inherit_id']]['children'][$v['id']]['url']  = $v['request_uri'];
                    //$retArr[$v['inherit_id']]['children'][$v['id']]['url']  = 'admin.admin.home';
                }
            }
        }
        return $retArr;
    }
}
