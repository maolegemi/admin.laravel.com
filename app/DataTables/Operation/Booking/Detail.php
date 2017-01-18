<?php

namespace App\DataTables\Operation\Booking;
use Yajra\Datatables\Services\DataTable;
use App\Http\Models\Common\Basic;

class Detail extends DataTable
{
    //use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        $_data   = $this->request()->all();
        $obj     = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($_data['action']) && in_array($_data['action'], ['print', 'excel'])) {
            $obj->setTransformer('App\Helper\Export\Operation\Booking\Detail');
        } else {
            $obj->setTransformer('App\Helper\Table\Operation\Booking\Detail');
        }
        //构造查询条件
        // if($_data['order_start_id']){
        //     $obj->where('OrderId','>=',$_data['order_start_id']);
        // }
        // if($_data['order_end_id']){
        //     $obj->where('OrderId','<=',$_data['order_end_id']);
        // }

        if(isset($_data['OrderVisitDate']) && $_data['OrderVisitDate']){
            $obj->whereBetween('OrderVisitDate',explode("|",$_data['OrderVisitDate']));

        }
        if(isset($_data['OrderConfirmDate']) && $_data['OrderConfirmDate']){
            $obj->whereBetween('OrderConfirmDate',explode("|",$_data['OrderConfirmDate']));
        }
        // if($_data['SourceId']){
        //     $obj->where('SourceId',$_data['SourceId']);
        // }
        // if($_data['PayType']){
        //     $obj->where('PayType',$_data['PayType']);
        // }
        // if($_data['FirstVisitFlag']){
        //     $obj->where('FirstVisitFlag',$_data['FirstVisitFlag']);
        // }
        // if($_data['OrderStatus']){
        //     $obj->where('OrderStatus',$_data['OrderStatus']);
        // }
        // if (isset($_data['CityId']) && $_data['CityId']) {
        //     $obj->whereIn('CityId', $_data['CityId']);
        // }
        // if(isset($_data['ShopId']) && $_data['ShopId']){
        //     $obj->whereIn('ShopId',$_data['ShopId']);
        // }
        // if ($_data['DoctorName']) {
        //     $obj->where('DoctorName', $_data['DoctorName']);
        // }
        // if ($_data['PatientName']) {
        //     $obj->where('PatientName', $_data['PatientName']);
        // }
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
        $_model = new Basic();
        $model = $_model->resetConnection('dbcenter')->resetTable('Rep_OrderDetailDaily')->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->ajax('')
            ->addAction(['width' => '80px'])
            ->parameters($this->getBuilderParameters());
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
            'OrderType',//
        ];
        return $retArr;
    }
    //
    protected function filename()
    {
        return '日预约明细' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.booking.detail');
        $this->buildExcel($headers_map);
    }
}
