<?php

namespace App\DataTables\Operation\Doctor;

use App\Http\Models\Common\Basic;
use Yajra\Datatables\Services\DataTable;

class Kpi extends DataTable
{
    use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        //获取统计类型
        $this->tb = $tb;
        $obj      = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $obj->setTransformer("App\Helper\Export\Operation\Doctor\\" . ucfirst($this->tb));
        } else {
            $obj->setTransformer("App\Helper\Table\Operation\Doctor\\" . ucfirst($this->tb));
        }
        //日查询
        if (isset($Sum_Date) && $Sum_Date) {
            $date = explode('~', $Sum_Date);
            $obj->whereBetween('Sum_Date', [trim($date[0]), trim($date[1])]);
        }
        //周查询
        if (isset($Sum_Week) && $Sum_Week) {
            $obj->where('Sum_Week', $Sum_Week);
        }
        //月查询
        if (isset($Sum_Month) && $Sum_Month) {
            $obj->where('Sum_Month', $Sum_Month);
        }
        if (isset($City_Id) && $City_Id) {
            $obj->where('City_Id', $City_Id);
        }
        if (isset($Shop_Id) && $Shop_Id) {
            $obj->where('Shop_Id', $Shop_Id);
        }
        if (isset($Doctor_Name) && $Doctor_Name) {
            $obj->where('Doctor_Name', 'like', "%{$Doctor_Name}%");
        }
        if (isset($Doctor_Level) && $Doctor_Level) {
            $obj->where('Doctor_Level', $Doctor_Level);
        }  
        //假如是看预约数据，需增加时间排序
        if (in_array($this->tb, ['KPIDaySum', 'KPIWeekSum', 'KPIMonthSum'])) {
            $key = $this->tb == 'KPIDaySum' ? 'Sum_Date' : ($this->tb == 'KPIWeekSum' ? 'Sum_Week' : ($this->tb == 'KPIMonthSum' ? 'Sum_Month' : 'Sum_Date'));
            $obj->orderBy($key, 'DESC');
        }
        //假如是排名则需增加时间限制//
        if (in_array($this->tb, ['RankWeekSum', 'RankMonthSum'])) {
            $key = $this->tb == 'RankWeekSum' ? 'Sum_Week' : 'Sum_Month';
            $obj->orderBy('OutPatientNum', 'DESC');
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
        $model = $basic->resetConnection('dbcenter')->resetTable("Rep_Doctor{$this->tb}")->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //
    private function getColumns()
    {
        if (!in_array($this->tb, ['RankWeekSum', 'RankMonthSum'])) {
            $key    = $this->tb == 'KPIDaySum' ? 'Sum_Date' : ($this->tb == 'KPIWeekSum' ? 'Sum_Week' : ($this->tb == 'KPIMonthSum' ? 'Sum_Month' : 'Sum_Date'));
            $retArr = [
                $key,
                'City_Id',
                'Shop_Id',
                'Doctor_Name',
                'Doctor_MisId',
                'Total_Counts',
                'OutPatientNum',
                'FirstVisitNum',
                'OrderOnlineNum',
                'FirstVisitOnline',
                'Saturation',
                'Doctor_Level',
            ];
        } else {
            $key    = $this->tb == 'RankWeekSum' ? 'Sum_Week' : 'Sum_Month';
            $retArr = [
                $key,
                'City_Id',
                'Shop_Id',
                'Doctor_Name',
                'Total_Counts',
                'OutPatientNum',
                'OutPatientNum_Rate',
                'FirstVisitNum',
                'FirstVisitNum_Rate',
                'OrderOnlineNum',
                'OrderOnlineNum_Rate',
                'ShopOrderOnlineNum_Rate',
                'FirstVisitOnline',
                'FirstVisitOnline_Rate',
                'ShopFirstVisitOnline_Rate',
                'Saturation',
                'Doctor_Level',
            ];
        }
        return $retArr;
    }
    //
    protected function filename()
    {
        $nameArr = [
            'KPIDaySum'   => "医生预约KPI日报表",
            'KPIWeekSum'  => "医生预约KPI周报表",
            'KPIMonthSum' => "医生预约KPI月报表",
            'RankWeekSum' => "医生周排行报表",
            'RankMonthSum'=> "医生月排行报表",
        ];
        $tb          = $this->request()->input('tb');
        return $nameArr[$tb];
    }
    // Override parent function
    public function excel()
    {
        $tb          = $this->request()->input('tb');
        $headers_map = config("export.operate.doctor.{$tb}");
        $this->buildExcel($headers_map);
    }
}
