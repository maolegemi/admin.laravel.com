<?php

namespace App\Helper\Table\Drug\Drug;

use League\Fractal\TransformerAbstract;

class Consume extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Rec_Date'    => $data['Rec_Date'],
            'City_Id'     => $this->cityName($data['City_Id']),
            'Shop_Id'     => $this->shopName($data['Shop_Id']),
            'Item_Code'   => $data['Item_Code'],
            'Cls_Name'    => $data['Cls_Name'],
            'Item_Name'   => $this->cutStr($data['Item_Name'],10),
            'Big_Unit'    => $data['Big_Unit'],
            'Standard'    => $data['Standard'],
            'QTY'         => $data['QTY'],
            'Ret_Price'   => $data['Ret_Price'],
            'Sales_Money' => $data['Sales_Money'],
            'Tra_Price'   => $data['Tra_Price'],
            'Tra_Money'   => $data['Tra_Money'],
        ];
    }
}
