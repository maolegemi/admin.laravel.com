<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Models\Common\Curl;
use App\Http\Models\Common\Menu;
use App\Http\Models\Common\Tools;
use Request;
use Route;
use Session;
use View;

class BasicController extends Controller
{
    //获取左边菜单数据
    public function __construct()
    {
        //获取登录用户信息
        $admin = Session::get('admin');
        View::share('admin', $admin);
        //获取菜单信息
        $model = new Menu();
        $menu  = $model->getMenuList();
        View::share('menu', $menu);
        //检验用户是否拥有权限
        extract(parse_url(Request::url()));
        $route = Route::currentRouteName($path);
        $this->checkAuth($route, $admin['admin_id']);
    }
    //检验用户权限
    private function checkAuth($route, $admin_id)
    {
        $authRoute = ['admin.admin.home', 'admin.admin.auth'];
        if (!in_array($route, $authRoute)) {
            $curl   = new Curl();
            $host   = env('CAS_HOST', 'http://cas.gstzy.cn');
            $method = config('cas.api.auth');

            $param = [
                'app_id'      => env('CAS_APP_ID', 2), //*
                'app_key'     => env('CAS_SECRET', 123456), //*
                'user_id'     => $admin_id, //*
                'request_uri' => $route, //*
                'city_id'     => '',
                'custom'      => '',
                'doctor_id'   => '',
                // 'module'      => '',
                // 'permission'  => '',
                'shop_id'     => '',
            ];
            $url      = $host . $method . '?' . http_build_query($param);
            $cgi_data = $curl->get($url);
            $data     = json_decode($cgi_data, 1);
            if ($data['data']['result'] === false) {
                $redirect_url = route('admin.admin.auth');
                echo "<script>window.location='{$redirect_url}'</script>";
            }
        }
    }
    //通过CGI获取城市数据
    public static function getCityMap($do = 0, $province_no = 0)
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getCity($do, $province_no);
        return $retArr;
    }
    //通过CGI获取门店数据
    public static function getShopMap($do = 0, $city_no = 0, $shop_no = 0)
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getShop($do, $city_no, $shop_no);
        return $retArr;
    }
    //通过CGI获取城市关联门店数据
    public static function getCityShopMap($city_no = 0)
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getCityShop($city_no);
        return $retArr;
    }
    //获取渠道数据
    public static function getSourceMap($type = 0)
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getSource($type);
        return $retArr;
    }
    //获取支付方式数据
    public static function getPayModeMap()
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getPayMode();
        return $retArr;
    }
    //获取首复诊数据
    public static function getVisitStateMap()
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getVisitState();
        return $retArr;
    }
    //获取到店状态数据
    public static function getGoShopStateMap()
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getGoShopState();
        return $retArr;
    }
    //获取订单状态数据
    public static function getOrderStateMap()
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getOrderState();
        return $retArr;
    }
    //获取医生等级
    public static function getDoctorLevel()
    {
        $retArr = [];
        $tools  = new Tools();
        $retArr = $tools->getDoctorLevel();
        return $retArr;
    }
    //获取上一周日期方法
    public static function getLastWeekDate($week = 3)
    {
        $date       = date('Y-m-d'); //当前日期
        $first      = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w          = date('w', strtotime($date)); //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start  = date('Y-m-d', strtotime("{$date} -" . ($w ? $w - $first : 6) . ' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end    = date('Y-m-d', strtotime("{$now_start} +6 days")); //本周结束日期
        $last_start = date('Y-m-d', strtotime("{$now_start} - 7 days")); //上周开始日期
        return strtotime("+{$week} days", strtotime($last_start));
    }
}
