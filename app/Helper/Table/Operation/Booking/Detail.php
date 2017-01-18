<?php

namespace App\Helper\Table\Operation\Booking;

use League\Fractal\TransformerAbstract;

class Detail extends TransformerAbstract
{
    // Load Common Function
    //use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'OrderId'          => $data['OrderId'],
            'PatientName'      => $data['PatientName'],
            'MobilePhone'      => $data['MobilePhone'],
            'OrderVisitDate'   => $data['OrderVisitDate'],
            'OrderStatus'      => $data['OrderStatus'],
            'CityId'           => $data['CityId'],
            'ShopId'           => $data['ShopId'],
            'DoctorName'       => mb_strlen($data['DoctorName'])>8?mb_substr($data['DoctorName'],0,6,'utf-8').'...':$data['DoctorName'],
            'OrderType'        => $data['OrderType'],
            'SourceId'         => $data['SourceId'],
            'PayStatus'        => $data['PayStatus'],
            'PayType'          => $data['PayType'],
            'FirstVisitFlag'   => $data['FirstVisitFlag']==1?'首诊':($data['FirstVisitFlag']==2?'复诊':'不详'),
            'OrderConfirmDate' => $data['OrderConfirmDate'],
        ];
    }
}
