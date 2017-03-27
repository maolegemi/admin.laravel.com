<?php
namespace App\DataTables\Traffic\Traffic;

use App\Http\Models\Common\Basic;
use Yajra\Datatables\Services\DataTable;
use DB;

class Trend extends DataTable
{
    //use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        $where   = $this->request()->all();
        $obj     = $this->datatables->eloquent($this->query());
        extract($where);
        // 格式化
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $obj->setTransformer('App\Helper\Export\Traffic\Traffic\Trend');
        } else {
            $obj->setTransformer('App\Helper\Table\Traffic\Traffic\Trend');
        }
        //构造查询条件
        if (isset($Insert_Date) && $Insert_Date) {
            $date = explode('~', $Insert_Date);
            $obj->whereBetween('Insert_Date', [trim($date[0]), trim($date[1])]);
        }
        if(isset($Source_Id) && $Source_Id){
          $obj->where('Source_Id',$Source_Id);  
        }
        if ($export === true && $time === false) {
            return $obj->count();
        } elseif ($export === true) {
            $skip = $time * $take;
            return $obj->skip($skip)->take($take)->make(true);
        }
        $obj = $obj->groupBy('Insert_Date');
        $retJson = $obj->orderBy("Insert_Date","DESC")->make(true);
        return $retJson;
    }
    //
    public function query()
    {
        $basic  = new Basic();
        $query  = "Insert_Date,SUM(PV) as PV_Sum,SUM(UV) as UV_Sum,SUM(Register_UserNum) as Register_User_Sum,SUM(Login_UserNum) as Login_User_Sum,SUM(Reservation_Num) as Reservation_Sum,SUM(Arrive_Num) as Arrive_Sum,SUM(Inc_ReservationNum) as Inc_Reservation_Sum,SUM(Consulting_Num) as Consulting_Sum,SUM(Inc_Consulting_Num) as Inc_Consulting_Sum";
        $model  = $basic ->resetConnection('dbcenter')->resetTable('Rep_NetworkTraffic')->select(DB::raw($query));
        return $this->applyScopes($model);
    }
    //
    // private function getColumns()
    // {
    //     $retArr = [
    //         "Insert_Date",
    //         "SUM(PV) as PV_Sum",
    //         "SUM(UV) as UV_Sum",
    //     ];
    //     return $retArr;
    // }
    //
    protected function filename()
    {
        
    }
    // Override parent function
    public function excel()
    {
        
    }
}
