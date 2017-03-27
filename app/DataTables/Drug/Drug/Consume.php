<?php
namespace App\DataTables\Drug\Drug;

use App\Http\Models\Common\Basic;
use Yajra\Datatables\Services\DataTable;
use DB;

class Consume extends DataTable
{
    //use \App\DataTables\ExportFile;

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
                $obj->setTransformer('App\Helper\Export\Drug\Drug\Consume');
            } else {
                $obj->setTransformer('App\Helper\Table\Drug\Drug\Consume');
            }
        }
        //构造查询条件
        if (isset($Rec_Date) && $Rec_Date) {
            $date = explode('~', $Rec_Date);
            $obj->whereBetween('Rec_Date', [trim($date[0]), trim($date[1])]);
        }
        if (isset($City_Id) && $City_Id) {
            $obj->where('City_Id', $City_Id);
        }
        if (isset($Shop_Id) && $Shop_Id) {
            $obj->where('Shop_Id', $Shop_Id);
        }
        $obj->whereBetween('Rec_Date',['2017-02-14','2017-03-14']);
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
        $obj->orderBy('Rec_Date', 'DESC');
        $retJson = $obj->make(true);
        return $retJson;
    }

    public function query()
    {
        $basic = new Basic();
        $model = $basic->resetConnection('dbcenter')->resetTable('Rep_DrugsXiaoHao_Day')->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //bar
    public function queryBar($order)
    {
        $basic = new Basic();
        $sql   = "Item_Name,ROUND(SUM({$order})) as 'sumAll',Big_Unit";
        $model = $basic->resetConnection('dbcenter')->resetTable('Rep_DrugsXiaoHao_Day')->addSelect(DB::raw("{$sql}"));
        return $this->applyScopes($model);
    }
    private function getColumns()
    {
        $retArr = [];
        $retArr = [
            'Rec_Date',
            'City_Id',
            'Shop_Id',
            'Item_Code',
            'Cls_Name',
            'Item_Name',
            'Big_Unit',
            'Standard',
            'QTY',
            'Ret_Price',
            'Sales_Money',
            'Tra_Price',
            'Tra_Money',
        ];
        return $retArr;
    }
    protected function filename()
    {
        return '药品消耗统计(HIS)' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.drug.consumeHIS');
        $this->buildExcel($headers_map);
    }
}
