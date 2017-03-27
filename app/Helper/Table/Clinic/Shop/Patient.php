<?php

namespace App\Helper\Table\Clinic\Shop;

use League\Fractal\TransformerAbstract;

class Patient extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'ResDate'        => $data['ResDate'],
            'CityId'         => $data['CityId'],
            'CityName'       => $data['CityName'],
            'ShopId'         => $data['ShopId'],
            'ShopName'       => $this->cutStr($data['ShopName'],8),
            'SourceId'       => $data['SourceId'],
            'SourceName'     => $this->sourceName($data['SourceId']),
            'Res_Sum'        => $data['Res_Sum'],
            'FirstVisit_Sum' => $data['FirstVisit_Sum'],
        ];
    }
}
