<?php

namespace App\DataTables\Operation\Booking;

use App\Http\Models\Common\Basic;
use Yajra\Datatables\Services\DataTable;

class Detail extends DataTable
{
    use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        $obj = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $obj->setTransformer('App\Helper\Export\Operation\Booking\Detail');
        } else {
            $obj->setTransformer('App\Helper\Table\Operation\Booking\Detail');
        }
        //构造查询条件
        if (isset($OrderVisitDate) && $OrderVisitDate) {
            $date = explode('~', $OrderVisitDate);
            $obj->whereBetween('OrderVisitDate', [trim($date[0]), trim($date[1])]);
        }
        if (isset($OrderConfirmDate) && $OrderConfirmDate) {
            $date = explode('~', $OrderConfirmDate);
            $obj->whereBetween('OrderConfirmDate', [trim($date[0]), trim($date[1])]);
        }
        if (isset($SourceId) && $SourceId) {
            $obj->where('SourceId', $SourceId);
        }
        if (isset($PayType) && $PayType) {
            $obj->where('PayType', $PayType);
        }
        if (isset($FirstVisitFlag) && $FirstVisitFlag) {
            $obj->where('FirstVisitFlag', $FirstVisitFlag);
        }
        if (isset($OrderStatus) && $OrderStatus) {
            $obj->where('OrderStatus', $OrderStatus);
        }
        if (isset($CityId) && $CityId) {
            $obj->where('CityId', $CityId);
        }
        if (isset($ShopId) && $ShopId) {
            $obj->where('ShopId', $ShopId);
        }
        if (isset($DoctorName) && $DoctorName) {
            $obj->where('DoctorName', $DoctorName);
        }
        if (isset($PatientName) && $PatientName) {
            $obj->where('PatientName', $PatientName);
        }
        // Export
        if ($export === true && $time === false) {
            return $obj->count();
        } elseif ($export === true) {
            $skip = $time * $take;
            return $obj->skip($skip)->take($take)->make(true);
        }
        $retJson = $obj->make(true);
        return $retJson;
    }
    //
    public function query()
    {
        $basic = new Basic();
        $model = $basic->resetConnection('dbcenter')->resetTable('Rep_OrderDetailDaily')->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //
    private function getColumns()
    {
        $retArr = [
            'OrderId',
            'CityId',
            'OrderConfirmDate',
            'PatientName',
            'MobilePhone',
            'OrderVisitDate',
            'OrderStatus',
            'ShopId',
            'DoctorMisId',
            'DoctorName',
            'DoctorMisId',
            'SourceId',
            'PayStatus',
            'PayType',
            'FirstVisitFlag',
            'OrderType', //
        ];
        return $retArr;
    }
    //
    protected function filename()
    {
        return '订单预约明细' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.operate.booking.detail');
        $this->buildExcel($headers_map);
    }
}
