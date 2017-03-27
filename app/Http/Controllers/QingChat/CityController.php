<?php

namespace App\Http\Controllers\QingChat;

use App\DataTables\QingChat\City\Scan;
use App\Http\Controllers\Common\BasicController;

class CityController extends BasicController
{
    //
    public function getScan(Scan $dd)
    {
        $data                  = [];
        $data['init']['point'] = [
            'NewFans_Num'         => '当日新增粉丝数',
            'LeiJi_FansNum'       => '当月粉丝数',
            'Today_Qrcode_Num'    => '当日开通',
            'LeiJi_Qrcode_Num'    => '累计开通',
            'Today_NewScan_Num'   => '当日净增',
            'LeiJi_Scan_Num'      => '累计扫码',
            'Month_New_Scan'      => '当月净增',
            'KT_QingChart_Num'    => '开通轻问诊人数',
            'Today_EffectAsk_Num' => '当日有效问题净增',
            'LeiJi_EffectAsk_Num' => '有效问题累计量',
        ];
        $data['init']['csd']    = self::getCityShopMap();
        return $dd->render('qingchat.city.scan', compact('data'));
    }
}
