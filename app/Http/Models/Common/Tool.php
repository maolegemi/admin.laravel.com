<?php

namespace App\Http\Models\Common;

use App\Http\Models\Common\Basic;

class Tool extends Basic
{
    /**
     *
     * @param  [int]    $type   [description]
     * @return  array   $retArr [description]
     */
    public function getSource($type = 0)
    {
        $retArr = [];
        $source = [1 => 'HIS', '手机APP', '微信', 'MIS电话预约', 'PC官网', '1m1m.com', '39健康', '挂号网', '广东12580', '健康之路', '深圳就医160', '医生自带患者', '百度竞价', '家庭医生在线', '翼健康', '新浪微博', '运营后台', 'H5', '挂号网加号', '91160加号', '阿里健康', '叮当中医', '微信取消改约', '官网取消改约', 'V大夫', 'iphone', 'android', '平安金管家'];
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

    /**
     *
     * @return  array   $retArr [description]
     */
    public function getPayMode()
    {
      $retArr = [];
      $retArr = [1=>'线下支付',"支付宝支付","微信支付","第三方支付"];
      return $retArr;
    }
    /**
     *
     * @return  array   $retArr [description]
     */
    public function getVisitState()
    {
      $retArr = [];
      $retArr = [1=>'首诊',"复诊"];
      return $retArr;
    }
}
