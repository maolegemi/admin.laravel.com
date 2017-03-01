<?php

namespace App\Http\Controllers\Operation;

use App\DataTables\Operation\Booking\Detail;
use App\Http\Controllers\Common\BasicController;

class BookingController extends BasicController
{
    //
    public function getDetail(Detail $dd)
    {
        $data         = [];
        $data['init'] = [
            'source_map'      => self::getSourceMap(),
            'pay_mode_map'    => self::getPayModeMap(),
            'visit_state_map' => self::getVisitStateMap(),
            'city_shop_map'   => self::getCityShopMap(),
        ];
        return $dd->render('operation.booking.detail', compact('data'));
    }
}
