<?php

namespace App\Http\Controllers\Qrcode;

use App\DataTables\Qrcode\City\Scan as CScan;
use App\DataTables\Qrcode\Doctor\Scan as DScan;
use App\DataTables\Qrcode\Shop\Scan as SScan;
use App\Http\Controllers\Common\BasicController;

class QrcodeController extends BasicController
{
    //
    public function getLive()
    {
        $data = [];
        return View('qrcode.qrcode.live', compact('data'));
    }
    //
    public function getDoctor(DScan $dd)
    {
        $data                = [];
        $data['init']['csd'] = self::getCityShopMap();
        return $dd->render('qrcode.qrcode.doctor', compact('data'));
    }
    //
    public function getShop(SScan $dd)
    {
        $data                = [];
        $data['init']['csd'] = self::getCityShopMap();
        return $dd->render('qrcode.qrcode.shop', compact('data'));
    }
    //
    public function getCity(CScan $dd)
    {
        $data                  = [];
        $data['init']['csd']   = self::getCityShopMap();
        $data['init']['point'] = [
            'New_Scan'   => '扫码净增次数',
            'New_Scan_v' => '扫码净增变动值',
            'Scan'       => '累计扫码次数',
            'Scan_v'     => '累计扫码次数变动值',
            'Follow'     => '累计关注数',
            'Follow_v'   => '累计关注数变动值',
        ];
        return $dd->render('qrcode.qrcode.city', compact('data'));
    }
}
