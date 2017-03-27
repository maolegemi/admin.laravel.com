<?php
/**
 * Display ajax response.
 *
 * @return \Illuminate\Http\JsonResponse
 */
namespace App\DataTables\QingChat\City;

use App\Http\Models\Common\Basic;
use Yajra\Datatables\Services\DataTable;

class Scan extends DataTable
{
    use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        $obj     = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $obj->setTransformer('App\Helper\Export\QingChat\City\Scan');
        } else {
            $obj->setTransformer('App\Helper\Table\QingChat\City\Scan');
        }
        //构造查询条件
        if (isset($Insert_Date) && $Insert_Date) {
            $obj->where('Insert_Date', $Insert_Date);
        }
        if (isset($City_Id) && $City_Id) {
            $obj->where('City_Id', $City_Id);
        }
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
        $model  = $_model->resetConnection('dbcenter')->resetTable('Rep_QinChatQrcode_Day')->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //
    private function getColumns()
    {
        $retArr = [
            'City_Id',
            'City_Name',
            'NewFans_Num',
            'LeiJi_FansNum',
            'Today_Qrcode_Num',
            'LeiJi_Qrcode_Num',
            'Today_NewScan_Num',
            'LeiJi_Scan_Num',
            'Month_New_Scan',
            'KT_QingChart_Num',
            'Today_EffectAsk_Num',
            'LeiJi_EffectAsk_Num',
            'Insert_Date',
        ];
        return $retArr;
    }
    //
    protected function filename()
    {
        return '轻问诊-区域二维码汇总' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.qingchat.city.scan');
        $this->buildExcel($headers_map);
    }
}
