<?php

namespace App\Http\Models\Common;

use App\Http\Models\Common\Curl;
use Cache;

class Cgi extends Curl
{
    /**
     * Get Cgi Data
     *
     * @param  [type] $url   [description]
     * @param  array  $param [description]
     * @return [type]        [description]
     **/
    public static function getCgi($url, array $param)
    {
        $rs = self::_response($url . '?' . http_build_query($param));
        return json_decode($rs, true);
    }

    /**
     * Post Cgi Data
     *
     * @param  [type] $url   [description]
     * @param  array  $param [description]
     * @return [type]        [description]
     **/
    public static function postCgi($url, array $param)
    {
        $data = array_map(["App\Http\Models\Common\Cgi", "formatPostData"], $param);
        $data = json_encode($data);
        $rs   = self::_response($url, true, $data);
        return json_decode($rs, true);
    }

    /**
     * Get Cgi Url
     *
     * @param  [type] $str [description]
     * @return [type]      [description]
     **/
    public static function getCgiUrl($str)
    {
        $host = env('CGI_PATH', 'http://cgi.gstzy.cn/cgi-bin');
        $rs   = config('cgi.' . $str);
        if (!$rs) {
            throw new \Exception("Undefined Url : {$str}");
        }

        return $host . $rs;
    }

    /**
     * Formatting Cgi Post Data
     *
     * @param  [type] $data [description]
     * @return [type]       [description]
     **/
    final public static function formatPostData($data)
    {
        return is_array($data) ? array_map(["App\Http\Models\Common\Cgi", "formatPostData"], $data) : (string) $data;
    }

    /**
     * Get cities data from Cgi
     *
     * @param  [int]   $do              [description]
     * @param  [int]   $province_no     [description]
     * @return [array] $retArr          [description]
     **/
    public function getCityFromCgi($do = 0, $province_no = 0)
    {
        $retArr = [];
        $retArr = Cache::get("CityFromCgi{$do}{$province_no}");
        if (empty($retArr)) {
            $url = self::getCgiUrl('user.querycity');
            $map = [
                'province_no' => $province_no ? $province_no : '',
                'query_type'  => '0',
            ];
            $cgiData = self::getCgi($url, $map);
            if ($do) {
                array_map(function ($v) use (&$retArr) {
                    $retArr[$v['city_no']] = $v['city_name'];
                }, $cgiData['city_list']);
            } else {
                array_map(function ($v) use (&$retArr) {
                    $retArr[$v['city_no']] = $v;
                }, $cgiData['city_list']);
            }
            Cache::put("CityFromCgi{$do}{$province_no}", $retArr, 1000);
        }
        return $retArr;
    }
    /**
     * Get shops data from Cgi
     *
     * @param [int] $do               [description]
     * @param [int] $city_no          [description]
     * @param [int] $shop_no          [description]
     * @return [array] $retArr        [description]
     **/
    public function getShopFromCgi($do = 0, $city_no = 0, $shop_no = 0)
    {
        $retArr = [];
        // $retArr = Cache::get("ShopFromCgi{$do}{$city_no}{$shop_no}");
        // if (empty($retArr)) {
        $url = self::getCgiUrl('user.queryshop');
        $map = [
            'city_no'    => $city_no ? $city_no : '',
            'shop_no'    => $shop_no ? $shop_no : '',
            'is_detail'  => '0',
            'prog_opt'   => '8',
            'push_type'  => '6',
            'query_type' => '0',
        ];
        $cgiData = self::getCgi($url, $map);
        if ($do) {
            array_map(function ($v) use (&$retArr) {
                $retArr[$v['shop_no']] = $v['shop_nick_name'];
            }, $cgiData['shop_list']);
        } else {
            array_map(function ($v) use (&$retArr) {
                $retArr[$v['shop_no']] = $v;
            }, $cgiData['shop_list']);
        }
        //     Cache::put("ShopFromCgi{$do}{$city_no}{$shop_no}", $retArr, 1000);
        // }
        return $retArr;
    }
    /**
     * Get cities and shops data from Cgi
     *
     * @param [int] $city_no          [description]
     * @return [array] $retArr        [description]
     **/
    public function getCityAndShopFromCgi($city_no = 0)
    {
        $retArr = [];
        $retArr = Cache::get("CityAndShop{$city_no}");
        if (empty($retArr)) {
            //获取门店、城市信息
            $shop = $this->getShopFromCgi();
            $city = $this->getCityFromCgi(1);
            array_map(function ($v) use (&$retArr, &$city) {
                $retArr[$v['city_no']]['city_no']              = $v['city_no'];
                $retArr[$v['city_no']]['city_name']            = isset($city["{$v['city_no']}"]) ? $city["{$v['city_no']}"] : $v['city_no'];
                $retArr[$v['city_no']]['shops'][$v['shop_no']] = $v;
            }, $shop);
            Cache::put("CityAndShop{$city_no}", $retArr, 1000);
        }
        return $retArr;
    }
}
