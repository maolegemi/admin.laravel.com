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
        $obj->leftJoin('qrcode as b', function ($join) {
            $join->on('a.act_id', '=', 'b.act_id')->on('a.act_val', '=', 'b.doctor_id');
        })->where('b.deleted_at', 0);
        // 格式化
        if (isset($_data['action']) && in_array($_data['action'], ['print', 'excel'])) {
            $obj->setTransformer("App\Helper\Export\Qrcode\Doctor\Scan");
        } else {
            $obj->setTransformer("App\Helper\Table\Qrcode\Doctor\Scan");
        }
        //构造查询条件
        if (isset($date) && $date) {
            if ($this->type == 'monthly') {
                $obj->where('a.date', strtotime("{$date}-01"));
            } else {
                $obj->where('a.date', strtotime($date));
            }
        }
        if (isset($doctor_name) && $doctor_name) {
            $obj->where('b.doctor_name', 'like', "%{$doctor_name}%");
        }
        $obj->where('a.act_id', 1);
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
        $sql   = "a.date,a.act_id,a.act_val,a.new_scan,a.new_scan_v,a.scan,a.scan_v,a.follow,a.follow_v,a.updated_at, b.doctor_name as val_name";
        $model = $basic->resetConnection('mysql')->resetTable("qrcode_sum_{$this->type} as a")->select(DB::raw($sql));
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
