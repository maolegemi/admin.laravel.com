<?php

namespace App\Http\Controllers\Traffic;

use App\DataTables\Traffic\Traffic\Trend;
use App\DataTables\Traffic\Traffic\Source;
use App\Http\Controllers\Common\BasicController;

class TrafficController extends BasicController
{
    //
    public function getTrend(Trend $dd)
    {

        $data                   = [];
        $data['init']['source'] = [
            0   => 'PC',
            1   => '微信',
            // 2   => '安卓',
            // 3   => 'IOS',
            4   => 'H5',
            5   => '平安',
            7   => 'PC官网',
            255 => '其它',
        ];
        return $dd->render('traffic.traffic.trend', compact('data'));
    }

    //
    public function getSource(Source $dd)
    {
        $data                 = [];
        $data['init']['point'] = [
            'PV_Sum'              => 'PV量',
            'UV_Sum'              => 'UV量',
            'Register_User_Sum'   => '注册用户数',
            //'Login_User_Sum'      => '登录用户数',
            'Reservation_Sum'     => '预约数',
            'Inc_Reservation_Sum' => '新注册用户预约数',
            'Arrive_Sum'          => '到店人数',
            'Consulting_Sum'      => '咨询数',
            'Inc_Consulting_Sum'  => '新增用户咨询数',
        ];
        return $dd->render('traffic.traffic.source', compact('data'));
    }
}
