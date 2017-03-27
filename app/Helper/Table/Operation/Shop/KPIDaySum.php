<?php

namespace App\Helper\Table\Operation\Shop;

use League\Fractal\TransformerAbstract;

class KPIDaySum extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Sum_Date'             => $data['Sum_Date'],
            'City_Name'            => $this->cityName($data['City_Id']),
            'Shop_Name'            => $this->shopName($data['Shop_Id']),
            'Total_Counts'         => $data['Total_Counts'],
            'OutPatientNum'        => $data['OutPatientNum'],
            'FirstVisitNum'        => $data['FirstVisitNum'],
            'OrderOnlineNum'       => $data['OrderOnlineNum'],
            'FirstVisitOnline'     => $data['FirstVisitOnline'],
            'OrderOnlineRate'      => $data['OrderOnlineRate'] ? $data['OrderOnlineRate'] . '%' : '-',
            'FirstVisitOnlineRate' => $data['FirstVisitOnlineRate'] ? $data['FirstVisitOnlineRate'] . '%' : '-',
        ];
    }
}
