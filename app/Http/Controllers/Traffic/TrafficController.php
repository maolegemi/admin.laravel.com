<?php

namespace App\Http\Controllers\Traffic;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Common\BasicController;

class TrafficController extends BasicController
{
    //
    public function getTrend(){


    	return View('traffic.traffic.trend');
    }
}
