<?php

namespace App\Helper\Table\Drug\Drug;

use League\Fractal\TransformerAbstract;

class Purchase extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Vou_Date'     => $data['Vou_Date'],
            'City_Id'      => $this->cityName($data['City_Id']),
            'Shop_Id'      => $this->shopName($data['Shop_Id']),
            'Dept_Name'    => $data['Dept_Name'],
            'Item_Code'    => $data['Item_Code'],
            'Item_Name'    => $this->cutStr($data['Item_Name'],6),
            'Cls_Name'     => $data['Cls_Name'],
            'QTY'          => $data['QTY'],
            'Ret_Price'    => $data['Ret_Price'],
            'Tra_Price'    => $data['Tra_Price'],
            'Buy_SumMoney' => $data['Buy_SumMoney'],
            'Ret_AllMoney' => $data['Ret_AllMoney'],
            'Big_Unit'     => $data['Big_Unit'],
            'Standard'     => $data['Standard'],
            'Small_Unit'   => $data['Small_Unit'],
            'Vou_Name'     => $data['Vou_Name'],
        ];
    }
}
