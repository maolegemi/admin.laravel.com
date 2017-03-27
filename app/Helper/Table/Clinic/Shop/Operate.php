<?php

namespace App\Helper\Table\Clinic\Shop;

use League\Fractal\TransformerAbstract;

class Operate extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'RegDate'               => $data['RegDate'],
            'CityId'                => $data['CityId'],
            'CityName'              => $data['CityName'],
            'ShopId'                => $data['ShopId'],
            'ShopName'             => $data['ShopName'],
            'OutpatientSum'         => $data['OutpatientSum'],
            'TotalChargesSum'       => $data['TotalChargesSum'],
            'TreatChargesSum'       => $data['TreatChargesSum'],
            'ExamChargesSum'        => $data['ExamChargesSum'],
            'AgreeRecipeChargesSum' => $data['AgreeRecipeChargesSum'],
            'GuixiChargesSum'       => $data['GuixiChargesSum'],
            'FirstVisitSum'         => $data['FirstVisitSum'],
            'FirstVisitRate'        => $data['FirstVisitRate'],
            'FurtherVisitRate'      => $data['FurtherVisitRate'],
            'EscapeChargeRate'      => $data['EscapeChargeRate'],
            'PeakGetMedAverage'     => $data['PeakGetMedAverage'],
            'PeakVisitTimesAverage' => $data['PeakVisitTimesAverage'],
        ];
    }
}
