<?php

namespace App\Http\Controllers\Operation;

use App\DataTables\Operation\Shop\Kpi;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\BasicController;

class ShopController extends BasicController
{
    //
    public function getKpi(Kpi $dd){
    	$data                 = [];
        $data['init']['csd']   = self::getCityShopMap();
        $data['init']['last_thursday'] = self::getLastWeekDate(3);
        return $dd->render('operation.shop.kpi', compact('data'));
    }
}
