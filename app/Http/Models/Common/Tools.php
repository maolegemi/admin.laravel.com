<?php

namespace App\Http\Models\Common;

use App\Http\Models\Common\Basic;
use App\Http\Models\Common\Cgi;

class Tools extends Basic
{
    //获取渠道数据
    public function getSource($type = 0)
    {
        $retArr = [];
        $source = [1 => 'HIS', '手机APP', '微信', 'MIS电话预约', 'PC官网', '1m1m.com', '39健康', '挂号网', '广东12580', '健康之路', '深圳就医160', '医生自带患者', '百度竞价', '家庭医生在线', '翼健康', '新浪微博', '运营后台(线下)', 'H5', '挂号网加号', '91160加号', '阿里健康', '叮当中医', '微信取消改约', '官网取消改约', 'V大夫', 26 => 'IPHONE APP 患者端', 'ANDROID APP 患者端', '平安金管家', '医程通', '海鹚', '名医汇'];
        switch ($type) {
            case 1:
                //自有平台
                $owner = [1, 2, 3, 4, 5, 14, 17, 18];
                foreach ($source as $k => $v) {
                    if (in_array($k, $owner)) {
                        $retArr[$k] = $v;
                    }
                }
                break;
            case 2:
                //第三方平台
                $owner = [1, 2, 3, 4, 5, 14, 17, 18];
                foreach ($source as $k => $v) {
                    if (!in_array($k, $owner)) {
                        $retArr[$k] = $v;
                    }
                }
                break;
            default:
                $retArr = $source;
                break;
        }
        return $retArr;
    }
    //获取城市信息
    public function getCity($do = 0, $province_no = 0)
    {
        $retArr = [];
        $cgi    = new Cgi();
        $retArr = $cgi->getCityFromCgi($do, $province_no);
        return $retArr;
    }
    //获取门店信息
    public function getShop($do = 0, $city_no = 0, $shop_no = 0)
    {
        $retArr = [];
        $cgi    = new Cgi();
        $retArr = $cgi->getShopFromCgi($do, $city_no, $shop_no);
        return $retArr;
    }
    //获取城市门店数据
    public function getCityShop($city_no = 0)
    {
        $retArr = [];
        $cgi    = new Cgi();
        $retArr = $cgi->getCityAndShopFromCgi($city_no);
        return $retArr;
    }
    //获取支付方式
    public function getPayMode()
    {
        $retArr = [];
        $retArr = [1 => '线下支付', "支付宝支付", "微信支付", "第三方支付"];
        return $retArr;
    }
    //获取首复诊状态
    public function getVisitState()
    {
        $retArr = [];
        $retArr = [1 => '首诊', "复诊"];
        return $retArr;
    }
    //获取订单状态
    public function getOrderState()
    {
        $retArr = [1 => '待录入', '已录入', '医生已确认', '患者已确认', '已支付', '配药完成', '打包完成', '已发货', '已签收', '已自提', '交易结束', '退款中', '交易取消', '已到店', '已爽约', '待支付', '预约成功', '已取消', '退款完成'];
        return $retArr;
    }
    //获取到店状态
    public function getGoShopState()
    {
        $retArr = [
            '14'          => '已到店',
            '15'          => '已爽约',
            '16'          => '待支付',
            '17,5'        => '预约成功',
            '18,12,13,19' => '已取消',
        ];
        return $retArr;
    }
    //获取订单类型
    public function getOrderType()
    {
        return [3 => '挂号单', 4 => '预约单'];
    }
    //获取医生等级
    public function getDoctorLevel()
    {
        $retArr = [
            "A" => "A",
            "B" => "B",
            "C" => "C",
        ];
        return $retArr;
    }
}
