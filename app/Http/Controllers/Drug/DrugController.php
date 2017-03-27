<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Common\BasicController;
use App\DataTables\Drug\Drug\Consume;
use App\DataTables\Drug\Drug\Purchase;

class DrugController extends BasicController
{
    //
    public function getPurchase(Purchase $dd){
    	$data                 = [];
        $data['init']['csd']   = self::getCityShopMap();
        return $dd->render('drug.drug.purchase', compact('data'));
    }
    //
    public function getConsume(Consume $dd){
    	$data                 = [];
        $data['init']['csd']   = self::getCityShopMap();
        return $dd->render('drug.drug.consume', compact('data'));
    }
}
