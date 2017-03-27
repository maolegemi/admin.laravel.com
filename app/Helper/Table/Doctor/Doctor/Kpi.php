<?php

namespace App\Helper\Table\Doctor\Doctor;

use League\Fractal\TransformerAbstract;

class Kpi extends TransformerAbstract
{
    // Load Common Function
    use \App\Helper\Helper;
    // 格式化明细数据
    public function transform(array $data)
    {
        return [
            'Insert_Date'        => $data['Insert_Date'],
            'OutpatientNum'      => $data['OutpatientNum'],
            'RegCharges'         => $data['RegCharges'],
            'DrugCharges'        => $data['DrugCharges'],
            'AgreeRecipeCharges' => $data['AgreeRecipeCharges'],
            'ExamCharges'        => $data['ExamCharges'],
            'TreatCharges'       => $data['TreatCharges'],
            'GuixiCharges'       => $data['GuixiCharges'],
        ];
    }
}
