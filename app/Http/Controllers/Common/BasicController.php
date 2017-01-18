<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use DB;
use View;

class BasicController extends Controller
{
    //
    public function __construct()
    {
        $menu = $this->getMenuList();
        View::share('menu', $menu);
    }

    //
    private function getMenuList()
    {
        $retArr = [];
        //菜单路由
        $permissions = DB::connection('gstadmin')->table('gst_data_permissions');
        $rstArr      = $permissions->where('status', 1)->where('isshow',1)->orderBy('pid', 'asc')->orderBy('sort', 'asc')->get();
        //dump($rstArr);
        //dump($permissionData);
        //角色
        // $role = DB::connection('gstadmin')->table('gst_data_permission_role');
        // $roleData = $role->where('status',1)->get();
        //构造菜单数据
        foreach ($rstArr as $k => $v) {
            if ($v['name'] == '#' && $v['pid'] == 0) {
                $retArr[$v['id']]['id']       = $v['id'];
                $retArr[$v['id']]['name']     = $v['label'];
                $retArr[$v['id']]['url']      = $v['name'];
                $retArr[$v['id']]['css']      = $v['css'];
                $retArr[$v['id']]['children'] = [];
            } else {
                if($v['name'] != 'welcome'){
                $retArr[$v['pid']]['children'][$v['id']]['id']   = $v['id'];
                $retArr[$v['pid']]['children'][$v['id']]['name'] = $v['label'];
                //$retArr[$v['pid']]['children'][$v['id']]['url']  = $v['name'];
                $retArr[$v['pid']]['children'][$v['id']]['url']  = ($v['name'] == 'operation.booking.detail') || ($v['name'] == 'traffic.traffic.trend') || ($v['name'] == 'qingchat.doctor.kpi')?$v['name']:'admin.admin.index';
                }

            }

        }
        //$model->belongsToMany(Role::class, 'gst_data_permission_role')->where('gst_data_permission_role.status', 1);
        return $retArr;
    }
}
