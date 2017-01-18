<?php

namespace App\Http\Controllers\Operation;

use Illuminate\Http\Request;
use App\DataTables\Operation\Booking\Detail;

use App\Http\Requests;
use App\Http\Controllers\Common\BasicController;

class BookingController extends BasicController
{
    //
    public function getDetail(Detail $dd){


    	return $dd->render('operation.booking.detail');
    }
}
