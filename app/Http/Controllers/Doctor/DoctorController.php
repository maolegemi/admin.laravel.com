<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Common\BasicController;
use App\DataTables\Doctor\Doctor\Kpi;

class DoctorController extends BasicController
{
    //
    public function getKpi(Kpi $dd)
    {
        $data                  = [];
        $data['init']['point'] = [
            'OutpatientNum'      => '门诊量',
            'RegCharges'         => '挂号费',
            'DrugCharges'        => '药品费',
            'AgreeRecipeCharges' => '协定方（膏方）费',
            'ExamCharges'        => '检验检查费',
            'TreatCharges'       => '治疗费',
            'GuixiCharges'       => '无锡贵细 ',

        ];
        $data['init']['csd'] = self::getCityShopMap();
        $data['init']['last_thursday'] = self::getLastWeekDate(3);
        return $dd->render('doctor.doctor.kpi', compact('data'));
    }
    //
    public function getMulti()
    {
        $data['init']['list'] = range(1, 18);
        return View('doctor.doctor.multi', compact('data'));
    }
}
