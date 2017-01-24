<?php

namespace App\Http\Controllers\QingChat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Common\BasicController;
use App\DataTables\QingChat\Doctor\Kpi;


class DoctorController extends BasicController
{
    //
    public function getKpi(Kpi $dd){


    	return $dd->render('qingchat.doctor.kpi');
    }
}
