<?php

namespace App\Helper\Table\Qrcode\Doctor;

use League\Fractal\TransformerAbstract;

class Scan extends TransformerAbstract
{
    // Load Common Function
    //use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Date'        => $data['Date'],
            'Doctor_Id'   => $data['Doctor_Id'],
            'Doctor_Name' => $data['Doctor_Name'],
            'City_Name'   => $data['City_Name'],
            'Shop_Name'   => $data['Shop_Name'],
            'New_Scan'    => $data['New_Scan'],
            'New_Scan_v'  => $data['New_Scan_v'],
            'Scan'        => $data['Scan'],
            'Scan_v'      => $data['Scan_v'],
            'Follow'      => $data['Follow'],
            'Follow_v'    => $data['Follow_v'],
        ];
    }
}
