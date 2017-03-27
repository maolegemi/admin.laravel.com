<?php

namespace App\Http\Controllers\Clinic;

use App\DataTables\Clinic\Shop\Operate;
use App\DataTables\Clinic\Shop\Patient;
use App\Http\Controllers\Common\BasicController;
use App\Http\Models\Clinic\Shop;
use Illuminate\Http\Request;

class ShopController extends BasicController
{
    //
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct();
    }
    //
    public function getOperate(Operate $dd)
    {
        $data                  = [];
        $data['init']['point'] = [
            'menage'  => [
                'OutpatientSum'   => '总门诊量',
                'TotalChargesSum' => '总费用(收入)',
            ],
            'income'  => [
                'TreatChargesSum'       => '治疗费用',
                'ExamChargesSum'        => '检验检查费用',
                'AgreeRecipeChargesSum' => '协定方(膏方)费用',
                'GuixiChargesSum'       => '贵细费用',
            ],
            'service' => [
                'FirstVisitSum'         => '初诊量',
                'FirstVisitRate'        => '初诊率',
                'FurtherVisitRate'      => '复诊率',
                'EscapeChargeRate'      => '跑单率',
                'PeakGetMedAverage'     => '高峰候药平均时间',
                'PeakVisitTimesAverage' => '高峰就诊平均时间',
            ],
        ];
        $data['init']['csd'] = self::getCityShopMap();
        return $dd->render('clinic.shop.operate', compact('data'));
    }
    //
    public function getPatient(Patient $dd)
    {
        $data                            = [];
        $data['init']['source']['owner'] = [
            3  => '微信',
            4  => 'MIS电话预约(线下)',
            5  => 'PC官网',
            17 => '运营后台(线下)',
            18 => 'H5',
        ];
        $data['init']['source']['third'] = [
            7  => '39健康',
            8  => '挂号网',
            9  => '广东12580',
            10 => '健康之路',
            11 => '深圳就医160',
            14 => '家庭医生在线',
            15 => '翼健康',
            28 => '平安金管家',
            29 => '医程通',
            30 => '其它-30',
            32 => '其它-32',
        ];
        $data['init']['csd'] = self::getCityShopMap();
        return $dd->render('clinic.shop.patient', compact('data'));
    }
    //
    public function getReport()
    {
        if ($this->request->ajax()) {
            extract($this->request->all());
            $where           = [];
            $where['date']   = (isset($date) && $date) ? $date : date('Y-m-d');
            $where['CityId'] = isset($CityId) ? $CityId : '';
            $where['ShopId'] = isset($ShopId) ? $ShopId : '';
            $shop            = new Shop();
            $data            = [];
            $data            = $shop->getShopOperationData($where);
            return View('clinic.shop.temp.report', compact('data'));
        } else {
            extract($this->request->all());
            //导出操作
            if (isset($export) && $export) {
                $where           = [];
                $where['date']  = (isset($date) && $date) ? $date : date('Y-m-d');
                $where['CityId'] = isset($CityId) ? $CityId : '';
                $where['ShopId'] = isset($ShopId) ? $ShopId : '';
                $shop            = new Shop();
                $shop->getShopOperationData($where, $export);
            }
            $data                = [];
            $data['init']['csd'] = self::getCityShopMap();
            return View('clinic.shop.report', compact('data'));
        }
    }
}
