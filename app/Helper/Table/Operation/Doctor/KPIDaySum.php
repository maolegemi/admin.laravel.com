<?php

namespace App\Helper\Table\Operation\Doctor;

use League\Fractal\TransformerAbstract;

class KPIDaySum extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Sum_Date'         => $data['Sum_Date'],
            'City_Name'        => $this->cityName($data['City_Id']),
            'Shop_Name'        => $this->shopName($data['Shop_Id']),
            'Doctor_MisId'     => $data['Doctor_MisId'],
            'Doctor_Name'      => $data['Doctor_Name'],
            'Total_Counts'     => $data['Total_Counts'],
            'OutPatientNum'    => $data['OutPatientNum'],
            'FirstVisitNum'    => $data['FirstVisitNum'],
            'OrderOnlineNum'   => $data['OrderOnlineNum'],
            'FirstVisitOnline' => $data['FirstVisitOnline'],
            'mzyy_rate'        => $data['OutPatientNum'] ? bcmul(bcdiv($data['OutPatientNum'], $data['OutPatientNum'], 4), 100, 2).'%' : '-',
            'mzsz_rate'        => $data['OutPatientNum'] ? bcmul(bcdiv($data['FirstVisitOnline'], $data['OutPatientNum'], 4), 100, 2).'%' : '-',
            'Saturation'       => $data['Saturation'],
            'Doctor_Level'     => $data['Doctor_Level'],
        ];
    }
}
