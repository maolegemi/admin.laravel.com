<?php
namespace App\DataTables\Clinic\Shop;

use App\Http\Models\Common\Basic;
use DB;
use Yajra\Datatables\Services\DataTable;

class Patient extends DataTable
{
    //use ExportFile;
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        extract($this->request()->all());
        $obj        = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $obj->setTransformer('App\Helper\Export\Clinic\Shop\Patient');
        } else {
            $obj->setTransformer('App\Helper\Table\Clinic\Shop\Patient');
        }
        //构造查询条件
        if(isset($ResDate) && $ResDate){
            $date = explode('~',$ResDate);
            $obj->whereBetween('ResDate',[trim($date[0]),trim($date[1])]);
        }
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
        ///获取饼状图数据///
        ////////////////////
        if(isset($type) && $type==='pie'){
          $retJson = $obj->groupBy('SourceId')->groupBy('ShopId')->make(true);
          return $retJson;
        }
        ////////////////////
        ///获取线性图数据///
        ////////////////////
        $retJson = $obj->groupBy('SourceId')->groupBy('ResDate')->orderBy('ResDate', 'DESC')->make(true);
        return $retJson;
    }

    public function query()
    {
        $basic = new Basic();
        $sql   = "ResDate,CityId,CityName,ShopId,ShopName,SourceId,SourceName,SUM(ResNum) as Res_Sum,SUM(FirstVisitNum) as FirstVisit_Sum";
        $model = $basic->resetConnection('dbcenter')->resetTable('Rep_OperationalChannelAnalysisDailyData')->addSelect(DB::raw($sql));
        return $this->applyScopes($model);
    }
    //
    protected function filename()
    {
        return '门店经营数据-患者端' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.drug.purchase');
        $this->buildExcel($headers_map);
    }
}
