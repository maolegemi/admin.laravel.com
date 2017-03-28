<?php

namespace App\Http\Controllers\Financial;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\BasicController;
use App\DataTables\Financial\Shop\Operate;

class ShopController extends BasicController
{
    //
    public function getOperate(Operate $dd){
      $data                 = [];
      $data['init']['csd'] = self::getCityShopMap();
      return $dd->render('financial.shop.operate',compact('data'));
    }
}
