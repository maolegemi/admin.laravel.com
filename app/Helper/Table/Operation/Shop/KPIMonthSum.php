<?php

namespace App\Helper\Table\Operation\Shop;

use League\Fractal\TransformerAbstract;

class KPIMonthSum extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Sum_Date'               => $data['Sum_Month'],
            'City_Name'              => $this->cityName($data['City_Id']),
            'Shop_Name'              => $this->shopName($data['Shop_Id']),
            'Total_Counts'           => $data['Total_Counts'],
            'OutPatientNum'          => $data['OutPatientNum'],
            'FirstVisitNum'          => $data['FirstVisitNum'],
            'OrderOnlineNum'         => $data['OrderOnlineNum'],
            'FirstVisitOnline'       => $data['FirstVisitOnline'],
            'OrderOnlineRate'        => $data['OrderOnlineRate'] ? $data['OrderOnlineRate'] . '%' : '-',
            'FirstVisitOnlineRate'   => $data['FirstVisitOnlineRate'] ? $data['FirstVisitOnlineRate'] . '%' : '-',
            'OrderOnlineRate_a'      => $data['OrderOnlineRate_a'] ? $data['OrderOnlineRate_a'] . '%' : '-',
            'OrderOnlineRate_b'      => $data['OrderOnlineRate_b'] ? $data['OrderOnlineRate_b'] . '%' : '-',
            'OrderOnlineRate_c'      => $data['OrderOnlineRate_c'] ? $data['OrderOnlineRate_c'] . '%' : '-',
            'FirstVisitOnlineRate_a' => $data['FirstVisitOnlineRate_a'] ? $data['FirstVisitOnlineRate_a'] . '%' : '-',
            'FirstVisitOnlineRate_b' => $data['FirstVisitOnlineRate_b'] ? $data['FirstVisitOnlineRate_b'] . '%' : '-',
            'FirstVisitOnlineRate_c' => $data['FirstVisitOnlineRate_c'] ? $data['FirstVisitOnlineRate_c'] . '%' : '-',
        ];
    }
}
