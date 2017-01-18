<?php

namespace App\Http\Controllers\QingChat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Common\BasicController;

class DoctorController extends BasicController
{
    //
    public function getKpi(){


    	return View('qingchat.doctor.kpi');
    }
}
