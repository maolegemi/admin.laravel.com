<?php

namespace App\DataTables\Financial\Shop;

use App\Http\Models\Common\Basic;
use Yajra\Datatables\Services\DataTable;

class Operate extends DataTable
{
    use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        //获取统计类型
        $obj = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $obj->setTransformer("App\Helper\Export\Financial\Shop\Operate");
        } else {
            $obj->setTransformer("App\Helper\Table\Financial\Shop\Operate");
        }
        //月查询
        if (isset($Sum_Month) && $Sum_Month) {
            $yMonth = explode('-',$Sum_Month);
            $obj->where('Years', $yMonth[0])->where('Months',$yMonth[1]);
        }
        if (isset($City_Id) && $City_Id) {
            $obj->where('City_Id', $City_Id);
        }
        if (isset($Shop_Id) && $Shop_Id) {
            $obj->where('Shop_Id', $Shop_Id);
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
        $model = $basic->resetConnection('dbcenter')->resetTable("F_JixiaoFinancial_Shop")->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //
    private function getColumns()
    {
        $retArr = [
            'City_Id',
            'City_Name',
            'Shop_Id',
            'Shop_Name',
            'Reg_Num',
            'Patient_Num',
            'PaoDan_Num',
            'Qrcode_Num',
            'Qrcode_Per',
            'Return_Num',
            'Return_Per',
            'XieDingFang_Num',
            'YinPian_Num',
            'WeiXin_Num',
            'WeiXin_Per',
            'Wait_DrugsTime',
            'Wait_FeeTime',
            'Wait_PayTime',
            'ShuangYue_Num',
            'ShuangYue_Per',
            'DaiJian_Num',
            'DaiJian_Per',
            'Years',
            'Months',
        ];
        return $retArr;
    }
    //
    protected function filename()
    {
     return '财务[月]报表-门店提成运营报表' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config("export.financial.shop.operate");
        $this->buildExcel($headers_map);
    }
}
