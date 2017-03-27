<?php

namespace App\Http\Controllers\Operation;

use App\DataTables\Operation\Doctor\Kpi;
use App\Http\Controllers\Common\BasicController;

class DoctorController extends BasicController
{
    //
    public function getKpi(Kpi $dd)
    {
        $data                  = [];
        $data['init']['csd']   = self::getCityShopMap();
        $data['init']['level'] = self::getDoctorLevel();
        $data['init']['last_thursday'] = self::getLastWeekDate(3);
        return $dd->render('operation.doctor.kpi', compact('data'));
    }

}
