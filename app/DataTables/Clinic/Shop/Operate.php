<?php
namespace App\DataTables\Clinic\Shop;

use App\Http\Models\Common\Basic;
use DB;
use Yajra\Datatables\Services\DataTable;

class Operate extends DataTable
{
    //use ExportFile;
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        $obj        = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $obj->setTransformer('App\Helper\Export\Clinic\Shop\Operate');
        } else {
            $obj->setTransformer('App\Helper\Table\Clinic\Shop\Operate');
        }
        //构造查询条件(公共)
        if(isset($RegDate) && $RegDate){
            $date = explode('~',$RegDate);
            $obj->whereBetween('RegDate',[date('Y.m.d',strtotime(trim($date[0]))),date('Y.m.d',strtotime(trim($date[1])))]);
        }
        ////////////////////
        ///获取柱状图数据///
        ////////////////////
        if(isset($type) && $type == 'pie'){
           $retJson = $obj->where('RegDate','2017.03.14')->groupBy('ShopId')->make(true);
           return $retJson; 
        }
        //构造折线图特有数据条件
        if(isset($CityId) && $CityId){
            $obj->where('CityId',$CityId);
        }
        if(isset($ShopId) && $ShopId){
            $obj->where('ShopId',$ShopId);
        }
        // Export
        if ($export === true && $time === false) {
            return $obj->count();
        } elseif ($export === true) {
            $skip = $time * $take;
            return $obj->skip($skip)->take($take)->make(true);
        }
        
        ////////////////////
        ///获取线性图数据///
        ////////////////////
        $retJson = $obj->groupBy('RegDate')->orderBy('RegDate', 'DESC')->make(true);
        return $retJson;
    }

    public function query()
    {
        $basic = new Basic();
        $sql   = "RegDate,CityId,CityName,ShopId,ShopName,SUM(OutpatientNum) as OutpatientSum,SUM(TotalCharges) as TotalChargesSum,SUM(TreatCharges) as TreatChargesSum,SUM(ExamCharges) as ExamChargesSum,SUM(AgreeRecipeCharges) as AgreeRecipeChargesSum,SUM(GuixiCharges) as GuixiChargesSum,SUM(FirstVisitNum) as FirstVisitSum,(SUM(FirstVisitNum)/SUM(OutpatientNum)) as FirstVisitRate,(SUM(FurtherVisitNum)/SUM(OutpatientNum)) as FurtherVisitRate,(SUM(EscapeChargeNum)/SUM(OutpatientNum)) as EscapeChargeRate,(SUM(PeakGetMedTmes)/SUM(PeakGetMedNum)) as PeakGetMedAverage,(SUM(PeakVisitTimes)/SUM(PeakVisitNum)) as PeakVisitTimesAverage";
        $model = $basic->resetConnection('dbcenter')->resetTable('Rep_OperationDataDaySum_Shop')->addSelect(DB::raw($sql));
        return $this->applyScopes($model);
    }
    //
    protected function filename()
    {
        return '门店经营数据' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.drug.purchase');
        $this->buildExcel($headers_map);
    }
}
