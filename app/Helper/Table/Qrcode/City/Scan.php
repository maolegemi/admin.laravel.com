<?php

namespace App\Helper\Table\Qrcode\City;

use League\Fractal\TransformerAbstract;

class Scan extends TransformerAbstract
{
    // Load Common Function
    //use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Date'       => $data['Date'],
            'City_Id'    => $data['City_Id'],
            'City_Name'  => $data['City_Name'],
            'New_Scan'   => $data['New_Scan'],
            'New_Scan_v' => $data['New_Scan_v'],
            'Scan'       => $data['Scan'],
            'Scan_v'     => $data['Scan_v'],
            'Follow'     => $data['Follow'],
            'Follow_v'   => $data['Follow_v'],
        ];
    }
}
