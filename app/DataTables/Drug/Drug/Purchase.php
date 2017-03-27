<?php
namespace App\DataTables\Drug\Drug;

use App\Http\Models\Common\Basic;
use DB;
use Yajra\Datatables\Services\DataTable;

class Purchase extends DataTable
{
    //use ExportFile;
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        //bar
        if (isset($action) && $action == 'bar') {
            $order = isset($barOrder) ? $barOrder : 'QTY';
            $obj   = $this->datatables->eloquent($this->queryBar($order));
        } else {
            $obj = $this->datatables->eloquent($this->query());
            // 格式化
            if (isset($action) && in_array($action, ['print', 'excel'])) {
                $obj->setTransformer('App\Helper\Export\Drug\Drug\Purchase');
            } else {
                $obj->setTransformer('App\Helper\Table\Drug\Drug\Purchase');
            }
        }
        //构造查询条件
        if (isset($Vou_Date) && $Vou_Date) {
            $date = explode('~', $Vou_Date);
            $obj->whereBetween('Vou_Date', [trim($date[0]), trim($date[1])]);
        }
        if (isset($City_Id) && $City_Id) {
            $obj->where('City_Id', $City_Id);
        }
        if (isset($Shop_Id) && $Shop_Id) {
            $obj->where('Shop_Id', $Shop_Id);
        }
        //bar
        if (isset($action) && $action == 'bar') {
            $obj->groupBy('Item_Code')->orderBy('sumAll', 'DESC')->limit(20);
            $retJson = $obj->make(true);
            return $retJson;
        }
        if (isset($Item_Name) && $Item_Name) {
            $obj->where('Item_Name', $Item_Name);
        }
        if (isset($Item_Code) && $Item_Code) {
            $obj->where('Item_Code', $Item_Code);
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

    public function query()
    {
        $basic = new Basic();
        $model = $basic->resetConnection('dbcenter')->resetTable('Rep_DrugsLingYong_Month')->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //bar
    public function queryBar($order)
    {
        $basic = new Basic();
        $sql   = "Item_Name,ROUND(SUM({$order})) as 'sumAll',Ly_Unit";
        $model = $basic->resetConnection('dbcenter')->resetTable('Rep_DrugsLingYong_Month')->addSelect(DB::raw("{$sql}"));
        return $this->applyScopes($model);
    }
    private function getColumns()
    {
        $retArr = [
            'Vou_Date',
            'City_Id',
            'Shop_Id',
            'Dept_Name',
            'Item_Code',
            'Item_Name',
            'Cls_Name',
            'QTY',
            'Ret_Price',
            'Tra_Price',
            'Buy_SumMoney',
            'Ret_AllMoney',
            'Big_Unit',
            'Standard',
            'Small_Unit',
            'Vou_Name',
        ];
        return $retArr;
    }
    protected function filename()
    {
        return '药品采购领取' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.drug.purchase');
        $this->buildExcel($headers_map);
    }
}
