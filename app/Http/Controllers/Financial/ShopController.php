<?php

namespace App\Http\Controllers\Financial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Common\BasicController;

class ShopController extends BasicController
{
    //
    public function getOperate(){
      $data                 = [];
      $data['init']['csd'] = self::getCityShopMap();
      return View('financial.shop.operate',compact('data'));
    }
}
