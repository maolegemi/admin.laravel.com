<?php

namespace App\DataTables\Qrcode\Doctor;

use App\Http\Models\Common\Basic;
use DB;
use Yajra\Datatables\Services\DataTable;

class Scan extends DataTable
{
    use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        date_default_timezone_set('Asia/Shanghai');
        $retJson = '';
        extract($this->request()->all());
        //获取统计类型
        $this->type = $type;
        $obj        = $this->datatables->eloquent($this->query());
        // 连表查询，获取门店、医生、区域的名字
        $obj->leftJoin('Dim_Qrcode_Doctor as b', function ($join) {
            $join->on('a.Act_Val', '=', 'b.Doctor_Id');
        })->where('b.Deleted_at', 0);
        // 格式化
        if (isset($_data['action']) && in_array($_data['action'], ['print', 'excel'])) {
            $obj->setTransformer("App\Helper\Export\Qrcode\Doctor\Scan");
        } else {
            $obj->setTransformer("App\Helper\Table\Qrcode\Doctor\Scan");
        }
        //构造查询条件
        if (isset($Date) && $Date) {
            if ($this->type == 'monthly') {
                $obj->where('a.date', strtotime("{$date}-01"));
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
        if (isset($Doctor_Name) && $Doctor_Name) {
            $obj->where('b.Doctor_Name', 'like', "%{$Doctor_Name}%");
        }
        $obj->where('a.Act_Id', 1);
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
        $sql   = "a.Date,a.Act_Id,a.Act_Val,a.New_Scan,a.New_Scan_v,a.Scan,a.Scan_v,a.Follow,a.Follow_v,a.Updated_at,b.City_Name,b.Shop_Name, b.Doctor_Id,b.Doctor_Name";
        $model = $basic->resetConnection('dbcenter')->resetTable("Dim_Qrcode_Sum_Daily as a")->select(DB::raw($sql));
        return $this->applyScopes($model);
    }
    //
    protected function filename()
    {
        $nameArr = [
            'daily'   => '医生二维码日扫码',
            'weekly'  => '医生二维码周扫码',
            'monthly' => '医生二维码月扫码',
        ];
        $type = $this->request()->input('type');
        return $nameArr[$type];
    }
    // Override parent function
    public function excel()
    {
        $type        = $this->request()->input('type');
        $headers_map = config("export.qrcode.qrcode.doctor.{$type}");
        $this->buildExcel($headers_map);
    }
}
