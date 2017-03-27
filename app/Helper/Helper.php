<?php

namespace App\Helper;

use App\Http\Models\Common\Tools;
/**
 * 数据公共类
 */
trait Helper
{

    //
    public function date($dateTime)
    {
        return $dateTime ? date('Y-m-d', $dateTime) : null;
    }
//
    public function orderState($state)
    {
        $tools      = new Tools();
        $stateArr   = $tools->getOrderState();
        return array_key_exists($state, $stateArr) ? $stateArr[$state] : $state;
    }

    //
    public function cityName($city_no){
    	$tools     = new Tools();
    	$cityArr   = $tools->getCity(1);
        return array_key_exists($city_no, $cityArr) ? $cityArr[$city_no] : $city_no;
    }
    //
    public function shopName($shop_no){
    	$tools     = new Tools();
    	$shopArr   = $tools->getShop(1);
        return array_key_exists($shop_no, $shopArr) ? $this->cutStr($shopArr[$shop_no],10) : $shop_no;
    }
    //
    public function orderType($type_id){
    	$tools     = new Tools();
    	$typeArr   = $tools->getOrderType();
        return array_key_exists($type_id, $typeArr) ? $typeArr[$type_id] : $type_id;
    }
    //
    public function sourceName($source_id){
    	$tools    = new Tools();
    	$sourceArr = $tools->getSource();
        return array_key_exists($source_id, $sourceArr) ? $this->cutStr($sourceArr[$source_id],10) : "其它-{$source_id}";
    }
    //
    public function payMode($mode_id){
    	$tools   = new Tools();
    	$modeArr = $tools->getPayMode();
        return array_key_exists($mode_id, $modeArr) ? $modeArr[$mode_id] : $mode_id;	
    }
    //
    public function visitState($state){
    	$tools   = new Tools();
    	$visitArr= $tools->getVisitState();
        return array_key_exists($state, $visitArr) ? $visitArr[$state] : $state;	
    }
    //
    public function cutStr($str,$length){
    	return mb_strlen($str)>$length?mb_substr($str,0,$length-2,'utf-8').'...':$str;
    }

}
