<?php

namespace App\Http\Controllers\Operation;

use App\DataTables\Operation\Booking\Detail;
use App\Http\Controllers\Common\BasicController;
use App\Http\Models\Operation\Booking;
use Illuminate\Http\Request;
use Response;

class BookingController extends BasicController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct();
    }
    //
    public function getOnline()
    {

        if ($this->request->ajax()) {
            $where   = $this->request->all();
            $booking = new Booking();
            $data    = $booking->onlineData($where);
            //假如是医生贡献则直接返回datatable需要的json数据
            return in_array($where['type'], ['doctor', 'shop']) ? Response::json($data) : View("Operation.booking.temp.{$where['type']}", compact('data'));
        } else {
            $data                   = [];
            $data['init']['csd']    = self::getCityShopMap();
            $data['init']['source'] = self::getSourceMap();
            $where                  = $this->request->all();
            extract($where);
            //导出数据
            if (isset($action) && in_array($action, ['print', 'excel'])) {
                $booking = new Booking();
                $booking->onlineData($where);
            }
            return View('operation.booking.online', compact('data'));
        }
    }
    //
    public function getDetail(Detail $dd)
    {
        $data         = [];
        $data['init'] = [
            'source_map'        => self::getSourceMap(),
            'pay_mode_map'      => self::getPayModeMap(),
            'visit_state_map'   => self::getVisitStateMap(),
            'go_shop_state_map' => self::getGoShopStateMap(),
            'csd'               => self::getCityShopMap(),
        ];
        return $dd->render('operation.booking.detail', compact('data'));
    }
}
