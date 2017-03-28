<?php

namespace App\Helper\Table\Financial\Shop;

use League\Fractal\TransformerAbstract;

class Operate extends TransformerAbstract
{
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            //'City_Id'         => $data['City_Id'],
            'City_Name'       => $data['City_Name'],
            //'Shop_Id'         => $data['Shop_Id'],
            'Shop_Name'       => $data['Shop_Name'],
            'Reg_Num'         => $data['Reg_Num'],
            'Patient_Num'     => $data['Patient_Num'],
            'PaoDan_Num'      => $data['PaoDan_Num'],
            'Qrcode_Num'      => $data['Qrcode_Num'],
            'Qrcode_Per'      => $data['Qrcode_Per'],
            'Return_Num'      => $data['Return_Num'],
            'Return_Per'      => $data['Return_Per'],
            'XieDingFang_Num' => $data['XieDingFang_Num'],
            'YinPian_Num'     => $data['YinPian_Num'],
            'WeiXin_Num'      => $data['WeiXin_Num'],
            'WeiXin_Per'      => $data['WeiXin_Per'],
            'Wait_DrugsTime'  => $data['Wait_DrugsTime'],
            'Wait_FeeTime'    => $data['Wait_FeeTime'],
            'Wait_PayTime'    => $data['Wait_PayTime'],
            'ShuangYue_Num'   => $data['ShuangYue_Num'],
            'ShuangYue_Per'   => $data['ShuangYue_Per'],
            'DaiJian_Num'     => $data['DaiJian_Num'],
            'DaiJian_Per'     => $data['DaiJian_Per'],
            // 'Years'           => $data['Years'],
            // 'Months'          => $data['Months'],
        ];
    }
}
