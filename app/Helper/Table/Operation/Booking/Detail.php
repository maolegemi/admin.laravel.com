<?php

namespace App\Helper\Table\Operation\Booking;

use League\Fractal\TransformerAbstract;

class Detail extends TransformerAbstract
{
    use \App\Helper\Helper;
    // Load Common Function
    //use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'OrderId'          => $data['OrderId'],
            'OrderConfirmDate' => $data['OrderConfirmDate'],
            'OrderVisitDate'   => $data['OrderVisitDate'],
            'CityName'         => $this->cityName($data['CityId']),
            'ShopName'         => $this->shopName($data['ShopId']),
            'DoctorName'       => $this->cutStr($data['DoctorName'], 5),
            'PatientName'      => $data['PatientName'],
            'MobilePhone'      => $data['MobilePhone'],
            'OrderStatus'      => $this->orderState($data['OrderStatus']),
            'OrderType'        => $this->orderType($data['OrderType']),
            'SourceId'         => $this->sourceName($data['SourceId']),
            'PayStatus'        => $data['PayStatus'] ? '已支付' : '未支付',
            'PayType'          => $this->payMode($data['PayType']),
            'FirstVisitFlag'   => $this->visitState($data['FirstVisitFlag']),
        ];
    }
}
