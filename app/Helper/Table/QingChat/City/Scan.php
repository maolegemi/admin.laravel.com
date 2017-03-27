<?php

namespace App\Helper\Table\QingChat\City;

use League\Fractal\TransformerAbstract;

class Scan extends TransformerAbstract
{
    // Load Common Function
    //use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Insert_Date'         => $data['Insert_Date'],
            'City_Id'             => $data['City_Id'],
            'City_Name'           => $data['City_Name'],
            'NewFans_Num'         => $data['NewFans_Num'],
            'LeiJi_FansNum'       => $data['LeiJi_FansNum'],
            'Today_Qrcode_Num'    => $data['Today_Qrcode_Num'],
            'LeiJi_Qrcode_Num'    => $data['LeiJi_Qrcode_Num'],
            'Today_NewScan_Num'   => $data['Today_NewScan_Num'],
            'LeiJi_Scan_Num'      => $data['LeiJi_Scan_Num'],
            'Month_New_Scan'      => $data['Month_New_Scan'],
            'KT_QingChart_Num'    => $data['KT_QingChart_Num'],
            'Today_EffectAsk_Num' => $data['Today_EffectAsk_Num'],
            'LeiJi_EffectAsk_Num' => $data['LeiJi_EffectAsk_Num'],
        ];
    }
}
