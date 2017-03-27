<?php
namespace App\DataTables\Doctor\Doctor;

use App\Http\Models\Common\Basic;
use Yajra\Datatables\Services\DataTable;
use DB;

class Kpi extends DataTable
{
    //use ExportFile;
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        $this->type = $type;
        $obj        = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $obj->setTransformer('App\Helper\Export\Doctor\Doctor\Kpi');
        } else {
            $obj->setTransformer('App\Helper\Table\Doctor\Doctor\Kpi');
        }
        //构造查询条件
        //日
        if(isset($RegDate) && $RegDate){
            $date = explode('~',$RegDate);
            $obj->whereBetween('RegDate',[date('Y.m.d',strtotime(trim($date[0]))),date('Y.m.d',strtotime(trim($date[1])))]);
        }
        //周
        if(isset($SummaryWeek) && $SummaryWeek){
            $date = explode('~',$SummaryWeek);
            $obj->whereBetween('SummaryWeek',[trim($date[0]),trim($date[1])]);
        }
        //月
        if(isset($SummaryMonth) && $SummaryMonth){
            $date = explode('~',$SummaryMonth);
            $obj->whereBetween('SummaryMonth',[date('Y-m',strtotime(trim($date[0]))),date('Y-m',strtotime(trim($date[1])))]);
        }
        if(isset($CityId) && $CityId){
            $obj->where('CityId',$CityId);
        }
        if(isset($ShopId) && $ShopId){
            $obj->where('ShopId',$ShopId);
        }
        if(isset($DoctorName)&&$DoctorName){
            $obj->where('DoctorName',$DoctorName);
        }

        // Export
        if ($export === true && $time === false) {
            return $obj->count();
        } elseif ($export === true) {
            $skip = $time * $take;
            return $obj->skip($skip)->take($take)->make(true);
        }
        $retJson = $obj->groupBy('Insert_Date')->orderBy('Insert_Date','DESC')->make(true);
        return $retJson;
    }

    public function query()
    {
        $basic = new Basic();
        $sql   = "SUM(OutpatientNum) as OutpatientNum,SUM(RegCharges) as RegCharges,SUM(DrugCharges) as DrugCharges,SUM(AgreeRecipeCharges) as AgreeRecipeCharges,SUM(ExamCharges) as ExamCharges,SUM(TreatCharges) as TreatCharges,SUM(GuixiCharges) as GuixiCharges";
        switch ($this->type) {
            case 'daily':
                $sql   = "RegDate as Insert_Date," . $sql;
                $model = $basic->resetConnection('dbcenter')->resetTable('Rep_OperationDataDaySum')->addSelect(DB::raw($sql));
                break;
            case 'weekly':
                $sql   = "SummaryWeek as Insert_Date," . $sql;
                $model = $basic->resetConnection('dbcenter')->resetTable('Rep_OperationDataWeekSum')->addSelect(DB::raw($sql));
                break;
            case 'monthly':
                $sql   = "SummaryMonth as Insert_Date," . $sql;
                $model = $basic->resetConnection('dbcenter')->resetTable('Rep_OperationDataMonthSum')->addSelect(DB::raw($sql));
                break;
        }
        return $this->applyScopes($model);
    }
    //
    protected function filename()
    {
        return '医生业绩数据' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.drug.purchase');
        $this->buildExcel($headers_map);
    }
}
