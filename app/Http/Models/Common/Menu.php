<?php

namespace App\Http\Models\Common;

use App\Http\Models\Common\Basic;

class Menu extends Basic
{
    //
    public function __construct()
    {
        $this->file = [
            'operation.booking.detail',
            'traffic.traffic.trend',
            'qingchat.doctor.kpi',
        ];
    }
    //
    public function getMenuList()
    {
        $retArr      = [];
        $model       = new Basic();
        $permissions = $model->resetConnection('gstadmin')->resetTable('gst_data_permissions');
        $rstArr      = $permissions->where('status', 1)->where('isshow', 1)->orderBy('pid', 'asc')->orderBy('sort', 'asc')->get();
        foreach ($rstArr as $k => $v) {
            if ($v['name'] == '#' && $v['pid'] == 0) {
                $retArr[$v['id']]['id']       = $v['id'];
                $retArr[$v['id']]['name']     = $v['label'];
                $retArr[$v['id']]['url']      = $v['name'];
                $retArr[$v['id']]['css']      = $v['css'];
                $retArr[$v['id']]['children'] = [];
            } else {
                if ($v['name'] != 'welcome') {
                    $retArr[$v['pid']]['children'][$v['id']]['id']   = $v['id'];
                    $retArr[$v['pid']]['children'][$v['id']]['name'] = $v['label'];
                    //$retArr[$v['pid']]['children'][$v['id']]['url']  = $v['name'];
                    $retArr[$v['pid']]['children'][$v['id']]['url'] = (in_array($v['name'], $this->file)) ? $v['name'] : 'admin.admin.index';
                }
            }
        }
        return $retArr;
    }
}
