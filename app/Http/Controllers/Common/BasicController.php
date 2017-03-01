<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Models\Common\Cgi;
use App\Http\Models\Common\Menu;
use App\Http\Models\Common\Tool;
use View;

class BasicController extends Controller
{
    //获取左边菜单数据
    public function __construct()
    {
        $model = new Menu();
        $menu  = $model->getMenuList();
        View::share('menu', $menu);
    }
    //通过CGI获取城市数据
    public static function getCityMap($do = 0, $province_no = 0)
    {
        $retArr = [];
        $cgi    = new Cgi();
        $retArr = $cgi->getCityFromCgi($do, $province_no);
        return $retArr;
    }
    //通过CGI获取门店数据
    public static function getShopMap($do = 0, $city_no = 0, $shop_no = 0)
    {
        $retArr = [];
        $cgi    = new Cgi();
        $retArr = $cgi->getShopFromCgi($do, $city_no, $shop_no);
        return $retArr;
    }
    //通过CGI获取城市关联门店数据
    public static function getCityShopMap($city_no = 0)
    {
        $retArr = [];
        $cgi    = new Cgi();
        $retArr = $cgi->getCityAndShopFromCgi($city_no);
        return $retArr;
    }
    //获取渠道数据
    public static function getSourceMap($type = 0)
    {
       $retArr = [];
       $tools  = new Tool();
       $retArr = $tools->getSource($type);
       return $retArr;        
    }
    //获取支付方式数据
    public function getPayModeMap(){
       $retArr = [];
       $tools  = new Tool();
       $retArr = $tools->getPayMode();
       return $retArr;   
    }
    //获取首复诊数据
    public function getVisitStateMap(){
       $retArr = [];
       $tools  = new Tool();
       $retArr = $tools->getVisitState();
       return $retArr;   
    }
}
