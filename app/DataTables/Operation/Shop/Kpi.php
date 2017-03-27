<?php

namespace App\DataTables\Operation\Shop;

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
            $obj->setTransformer("App\Helper\Export\Operation\Shop\\" . ucfirst($this->tb));
        } else {
            $obj->setTransformer("App\Helper\Table\Operation\Shop\\" . ucfirst($this->tb));
        }
        //构造查询条件
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
        $key = $this->tb == 'KPIDaySum' ? 'Sum_Date' : ($this->tb == 'KPIWeekSum' ? 'Sum_Week' : ($this->tb == 'KPIMonthSum' ? 'Sum_Month' : 'Sum_Date'));
        $obj->orderBy($key, 'DESC');
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
        $model = $basic->resetConnection('dbcenter')->resetTable("Rep_Shop{$this->tb}")->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //
    private function getColumns()
    {
        $key    = $this->tb == 'KPIDaySum' ? 'Sum_Date' : ($this->tb == 'KPIWeekSum' ? 'Sum_Week' : ($this->tb == 'KPIMonthSum' ? 'Sum_Month' : 'Sum_Date'));
        $retArr = [
            $key,
            'City_Id',
            'Shop_Id',
            'Total_Counts',
            'OutPatientNum',
            'FirstVisitNum',
            'OrderOnlineNum',
            'FirstVisitOnline',
            'OrderOnlineRate',
            'FirstVisitOnlineRate',
        ];
        if ($this->tb == 'KPIWeekSum' || $this->tb == 'KPIMonthSum') {
            $addArr = ['OrderOnlineRate_a', 'OrderOnlineRate_b', 'OrderOnlineRate_c', 'FirstVisitOnlineRate_a', 'FirstVisitOnlineRate_b', 'FirstVisitOnlineRate_c'];
            $retArr = array_merge($retArr, $addArr);
        }
        return $retArr;
    }
    //
    protected function filename()
    {
        $nameArr = [
            'KPIDaySum'   => "门店预约KPI日报表",
            'KPIWeekSum'  => "门店预约KPI周报表",
            'KPIMonthSum' => "门店预约KPI月报表",
        ];
        $tb = $this->request()->input('tb');
        return $nameArr[$tb];
    }
    // Override parent function
    public function excel()
    {
        $tb          = $this->request()->input('tb');
        $headers_map = config("export.operate.shop.{$tb}");
        $this->buildExcel($headers_map);
    }
}
