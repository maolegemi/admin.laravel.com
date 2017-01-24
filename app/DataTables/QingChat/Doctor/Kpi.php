<?php
/**
 * Display ajax response.
 *
 * @return \Illuminate\Http\JsonResponse
 */
namespace App\DataTables\QingChat\Doctor;

use App\Http\Models\Common\Basic;
use Yajra\Datatables\Services\DataTable;

class Kpi extends DataTable
{
    //use \App\DataTables\ExportFile;
    //
    public function ajax($export = false, $take = 1000, $time = false)
    {
        $retJson = '';
        $_data   = $this->request()->all();
        $obj     = $this->datatables->eloquent($this->query());
        // 格式化
        if (isset($_data['action']) && in_array($_data['action'], ['print', 'excel'])) {
            $obj->setTransformer('App\Helper\Export\QingChat\Doctor\Kpi');
        } else {
            $obj->setTransformer('App\Helper\Table\QingChat\Doctor\Kpi');
        }
        //构造查询条件
        if (isset($_data['Stat_Time']) && $_data['Stat_Time']) {
            $statTime = explode('~', $_data['Stat_Time']);
            $obj->whereBetween('Stat_Time', [trim($statTime[0]), trim($statTime[1])]);
        }
        if ($export === true && $time === false) {
            return $obj->count();
        } elseif ($export === true) {
            $skip = $time * $take;
            return $obj->skip($skip)->take($take)->make(true);
        }
        $retJson = $obj->orderBy("Stat_Time","DESC")->make(true);
        return $retJson;
    }
    //
    public function query()
    {
        $_model = new Basic();
        $model  = $_model->resetConnection('dbcenter')->resetTable('Rep_QinChatLeiJi_Day')->select($this->getColumns());
        return $this->applyScopes($model);
    }
    //
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->ajax('')
            ->addAction(['width' => '80px'])
            ->parameters($this->getBuilderParameters());
    }
    //
    private function getColumns()
    {
        $retArr = [
            'Stat_Time',
            'Doctor_Num',
            'Online_ChatNum',
            'Online_AnswerNum',
            'TowHourAnswerNum',
            'First_AnswerDoctorNum',
            'TwoWeek_AnswerDoctorNum',
            'LeiJi_NewDoctorNum',
            'ChangeToFans_Num',
            'ChatToApp_Num',
            'LeiJi_AppNum',
            'LeiJi_DoctorNum',
            'LeiJi_ChatNum',
            'LeiJi_ToFansNum',
        ];
        return $retArr;
    }
    //
    protected function filename()
    {
        return '轻问诊-医生数据统计' . date('Ymd');
    }
    // Override parent function
    public function excel()
    {
        $headers_map = config('export.fac.stat');
        $this->buildExcel($headers_map);
    }
}
