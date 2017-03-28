<?php

namespace App\DataTables\Qrcode\Shop;

use App\Http\Models\Common\Basic;
use DB;
use Yajra\Datatables\Services\DataTable;

class Scan extends DataTable
{
    use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        //获取统计类型
        $this->type = $type;
        $obj        = $this->datatables->eloquent($this->query());
        // 连表查询，获取门店、医生、区域的名字
        $obj->leftJoin('Dim_Qrcode_Shop as b', function ($join) {
            $join->on('a.Act_Val', '=', 'b.Shop_Id');
        })->where('b.Deleted_at', 0);
        // 格式化
        if (isset($_data['action']) && in_array($_data['action'], ['print', 'excel'])) {
            $obj->setTransformer("App\Helper\Export\Qrcode\Shop\Scan");
        } else {
            $obj->setTransformer("App\Helper\Table\Qrcode\Shop\Scan");
        }
        //构造查询条件
        if (isset($Date) && $Date) {
            if ($this->type == 'monthly') {
                $obj->where('a.Date', "{$Date}-01");
            } else {
                $obj->where('a.Date', $Date);
            }
        }
        if (isset($City_Id) && $City_Id) {
            $obj->where('b.City_Id', $City_Id);
        }
        if (isset($Shop_Id) && $Shop_Id) {
            $obj->where('b.Shop_Id', $Shop_Id);
        }
        $obj->where('a.Act_Id', 2);
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
        $sql   = "a.Date,a.Act_Id,a.Act_Val,a.New_Scan,a.New_Scan_v,a.Scan,a.Scan_v,a.Follow,a.Follow_v,a.Updated_at,b.City_Name,b.Shop_Id,b.Shop_Name";
        switch ($this->type) {
            case 'daily':
                $model = $basic->resetConnection('dbcenter')->resetTable("Dim_Qrcode_Sum_Daily as a")->select(DB::raw($sql));
                break;
            case 'weekly':
                break;
            case 'monthly':
                $model = $basic->resetConnection('dbcenter')->resetTable("Rep_qrcode_sum_monthly as a")->select(DB::raw($sql));
                break;
        }
        return $this->applyScopes($model);
    }
    //
    protected function filename()
    {
        $nameArr = [
            'daily'   => '门店二维码日扫码',
            'weekly'  => '门店二维码周扫码',
            'monthly' => '门店二维码月扫码',
        ];
        $type = $this->request()->input('type');
        return $nameArr[$type];
    }
    // Override parent function
    public function excel()
    {
        $type        = $this->request()->input('type');
        $headers_map = config("export.qrcode.qrcode.shop.{$type}");
        $this->buildExcel($headers_map);
    }
}
