<?php

namespace App\Http\Models\Operation;

use App\Http\Models\Common\Basic;
use App\Http\Models\Common\Tools;
use DB;
use Excel;

class Booking extends Basic
{
    //
    public function onlineData($where = [])
    {
        $retArr = [];
        switch ($where['type']) {
            case 'kpi':
                $retArr = $this->getKpiData($where);
                break;
            case 'rate':
                $retArr = $this->getRateData($where);
                break;
            case 'doctor':
                $retArr = $this->getDoctorData($where);
                break;
            case 'shop':
                $retArr = $this->getShopData($where);
                break;
            case 'source':
                $retArr = $this->getSourceData($where);
                break;
        }
        return $retArr;
    }
    //
    private function getKpiData($where = [])
    {
        $retArr = [];
        $this->resetConnection('dbcenter');
        $this->resetTable('Rep_OnlineKPIDaySum');
        $model = DB::connection($this->connection)->table($this->table);
        $model->addSelect(DB::raw("Source_Id,Source_Name,SUM(Order_Num) as Order_Sum,IsFirst"));
        extract($where);
        if (isset($Sum_Date) && $Sum_Date) {
            $date = explode('~', $Sum_Date);
            $model->whereBetween('Sum_Date', [trim($date[0]), trim($date[1])]);
        }
        if (isset($City_Id) && $City_Id) {
            $model->where('City_Id', $City_Id);
        }
        if (isset($Shop_Id) && $Shop_Id) {
            $model->where('Shop_Id', $Shop_Id);
        }
        $rst = $model->groupBy('Source_Id')->groupBy('IsFirst')->get();
        //////////////////////////
        ///////初始化数据////////
        /////////////////////////
        $tools     = new Tools();
        $sourceArr = $tools->getSource();
        $ownKeys   = array_keys($tools->getSource(1));
        $thirdKeys = array_keys($tools->getSource(2));
        foreach ($sourceArr as $k => $v) {
            if (in_array($k, [3, 5, 17, 18, 28])) {
                $retArr['data'][$k]['Source_Id']          = $k;
                $retArr['data'][$k]['Source_Name']        = $v;
                $retArr['data'][$k]['Order_Sum']          = 0;
                $retArr['data'][$k]['First_Order_Sum']    = 0;
                $retArr['data'][$k]['First_Order_Rate']   = 0;
                $retArr['data'][$k]['Further_Order_Sum']  = 0;
                $retArr['data'][$k]['Further_Order_Rate'] = 0;
            }
        }
        $retArr['Order_Sum']          = 0;
        $retArr['Own_Order_Sum']      = 0;
        $retArr['Third_Order_Sum']    = 0;
        $retArr['First_Order_Sum']    = 0;
        $retArr['First_Order_Rate']   = 0;
        $retArr['Further_Order_Sum']  = 0;
        $retArr['Further_Order_Rate'] = 0;
        //////////////////////////
        ///////累计数据//////////
        /////////////////////////
        foreach ($rst as $k => $v) {
            if (isset($retArr['data'][$v['Source_Id']])) {
                switch ($v['IsFirst']) {
                    case 1:
                        $retArr['data'][$v['Source_Id']]['First_Order_Sum'] += $v['Order_Sum'];
                        $retArr['First_Order_Sum'] += $v['Order_Sum'];
                        break;
                    case 2:
                        $retArr['data'][$v['Source_Id']]['Further_Order_Sum'] += $v['Order_Sum'];
                        $retArr['Further_Order_Sum'] += $v['Order_Sum'];
                        break;
                }
                //当前渠道预约总量
                $retArr['data'][$v['Source_Id']]['Order_Sum'] += $v['Order_Sum'];
                //自有平台总量
                if (in_array($v['Source_Id'], $ownKeys)) {
                    $retArr['Own_Order_Sum'] += $v['Order_Sum'];
                }
                //第三方平台总量
                if (in_array($v['Source_Id'], $thirdKeys)) {
                    $retArr['Third_Order_Sum'] += $v['Order_Sum'];
                }
            }
        }
        //////////////////////////
        ////计算各渠道比例数据////
        /////////////////////////
        foreach ($retArr['data'] as $k => $v) {
            $retArr['data'][$k]['First_Order_Rate']   = $this->toGetAPercent($v['First_Order_Sum'], $v['Order_Sum']);
            $retArr['data'][$k]['Further_Order_Rate'] = $this->toGetAPercent($v['Further_Order_Sum'], $v['Order_Sum']);
        }
        //////////////////////////
        ////计算渠道总比例数据////
        /////////////////////////
        $retArr['Order_Sum']          = $retArr['First_Order_Sum'] + $retArr['Further_Order_Sum'];
        $retArr['First_Order_Rate']   = $this->toGetAPercent($retArr['First_Order_Sum'], $retArr['Order_Sum']);
        $retArr['Further_Order_Rate'] = $this->toGetAPercent($retArr['Further_Order_Sum'], $retArr['Order_Sum']);
        //判断是否导出
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $excelData             = [];
            $excelData['fileName'] = '线上KPI-首诊占比';
            $excelData['header']   = config('export.operate.online.kpi');
            $excelData['body']     = $retArr['data'];
            $this->exportKpiExcel($excelData);
        }
        return $retArr;
    }
    //导出数据
    public function exportKpiExcel($data = [])
    {
        //构造excel表格数据
        Excel::create($data['fileName'], function ($excel) use ($data) {
            $excel->sheet($data['fileName'], function ($sheet) use ($data) {
                //构造表格头部信息
                $sheet->row(1, $data['header']);
                $sheet->cells("A1:G1", function ($cells) {
                    $cells->setBackground('#4198db');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->setWidth(array(
                    'A' => 10,
                    'B' => 20,
                    'C' => 30,
                    'D' => 25,
                    'E' => 15,
                    'F' => 15,
                    'G' => 15,
                ));
                $sheet->freezeFirstRow();
                //构造数据主体
                //$sheet->rows($data['body']);
                $index = 2;
                foreach ($data['body'] as $k => $v) {
                    $sheet->row($index, $v);
                    $sheet->cells("A{$index}:G{$index}", function ($cells) {
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });
                    $index++;
                }
            });
        })->export('xls');
    }
    //
    public function getRateData($where = [])
    {
        $retArr = [];
        $this->resetConnection('dbcenter');
        $this->resetTable('Rep_OrderDetailDaily');
        $model = DB::connection($this->connection)->table($this->table);
        //
        $model->addSelect(DB::raw('SourceId as Source_Id,SourceName as Source_Name,OrderStatus,OrderType,COUNT(*) as Order_Sum'));
        extract($where);
        if (isset($OrderConfirmDate) && $OrderConfirmDate) {
            $date = explode('~', $OrderConfirmDate);
            $model->whereBetween('OrderConfirmDate', [trim($date[0]), trim($date[1])]);
        }
        if (isset($CityId) && $CityId) {
            $model->where('CityId', $CityId);
        }
        if (isset($ShopId) && $ShopId) {
            $model->where('ShopId', $ShopId);
        }
        if (isset($DoctorName) && $DoctorName) {
            $model->where('DoctorName', trim($DoctorName));
        }
        $model->groupBy('SourceId')->groupBy('OrderStatus');
        $rst       = $model->get();
        $tools     = new Tools();
        $sourceArr = $tools->getSource();
        //////////////////////////
        ///////初始化数据////////
        /////////////////////////
        foreach ($sourceArr as $k => $v) {
            if (in_array($k, [3, 5, 17, 18, 28])) {
                $retArr['data'][$k]['Source_Id']         = $k;
                $retArr['data'][$k]['Source_Name']       = $v;
                $retArr['data'][$k]['Order_Sum']         = 0;
                $retArr['data'][$k]['Cancel_Order_Sum']  = 0;
                $retArr['data'][$k]['Cancel_Order_Rate'] = 0;
                $retArr['data'][$k]['Miss_Order_Sum']    = 0;
                $retArr['data'][$k]['Miss_Order_Rate']   = 0;
            }
        }
        $retArr['Order_Sum']         = 0;
        $retArr['Success_Order_Sum'] = 0;
        $retArr['Cancel_Order_Sum']  = 0;
        $retArr['Cancel_Order_Rate'] = 0;
        $retArr['Miss_Order_Sum']    = 0;
        $retArr['Miss_Order_Rate']   = 0;
        //////////////////////////
        /////////处理数据////////
        /////////////////////////
        foreach ($rst as $k => $v) {
            if (isset($retArr['data'][$v['Source_Id']])) {
                //取消量
                if (in_array($v['OrderStatus'], [18, 12, 13, 19])) {
                    $retArr['data'][$v['Source_Id']]['Cancel_Order_Sum'] += $v['Order_Sum'];
                    $retArr['Cancel_Order_Sum'] += $v['Order_Sum'];
                }
                //爽约量
                if (in_array($v['OrderStatus'], [15])) {
                    $retArr['data'][$v['Source_Id']]['Miss_Order_Sum'] += $v['Order_Sum'];
                    $retArr['Miss_Order_Sum'] += $v['Order_Sum'];
                }
                //各渠道预约总量
                $retArr['data'][$v['Source_Id']]['Order_Sum'] += $v['Order_Sum'];
                //渠道预约总量
                $retArr['Order_Sum'] += $v['Order_Sum'];
                //成功总量
                if (in_array($v['OrderStatus'], [17, 5, 14])) {
                    $retArr['Success_Order_Sum'] += $v['Order_Sum'];
                }
                //取消总量
                if (in_array($v['OrderStatus'], [18, 12, 13, 19])) {
                    $retArr['Cancel_Order_Sum'] += $v['Order_Sum'];
                }
                //爽约总量
                if (in_array($v['OrderStatus'], [15])) {
                    $retArr['Miss_Order_Sum'] += $v['Order_Sum'];
                }
            }
        }
        //////////////////////////
        ////计算各渠道比例数据////
        /////////////////////////
        foreach ($retArr['data'] as $k => $v) {
            $retArr['data'][$k]['Cancel_Order_Rate'] = $this->toGetAPercent($v['Cancel_Order_Sum'], $v['Order_Sum']);
            $retArr['data'][$k]['Miss_Order_Rate']   = $this->toGetAPercent($v['Miss_Order_Sum'], $v['Order_Sum']);
        }
        //////////////////////////
        ////计算渠道总比例数据////
        /////////////////////////
        $retArr['Cancel_Order_Rate'] = $this->toGetAPercent($retArr['Cancel_Order_Sum'], $retArr['Order_Sum']);
        $retArr['Miss_Order_Rate']   = $this->toGetAPercent($retArr['Miss_Order_Sum'], $retArr['Order_Sum']);
        //判断是否导出
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $excelData             = [];
            $excelData['fileName'] = '取消-预约占比';
            $excelData['header']   = config('export.operate.online.rate');
            $excelData['body']     = $retArr['data'];
            $this->exportRateExcel($excelData);
        }
        return $retArr;
    }
    //
    public function exportRateExcel($data = [])
    {
        //构造excel表格数据
        Excel::create($data['fileName'], function ($excel) use ($data) {
            $excel->sheet($data['fileName'], function ($sheet) use ($data) {
                //构造表格头部信息
                $sheet->row(1, $data['header']);
                $sheet->cells("A1:G1", function ($cells) {
                    $cells->setBackground('#4198db');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->setWidth(array(
                    'A' => 10,
                    'B' => 20,
                    'C' => 30,
                    'D' => 25,
                    'E' => 15,
                    'F' => 15,
                    'G' => 15,
                ));
                $sheet->freezeFirstRow();
                //构造数据主体
                //$sheet->rows($data['body']);
                $index = 2;
                foreach ($data['body'] as $k => $v) {
                    $sheet->row($index, $v);
                    $sheet->cells("A{$index}:G{$index}", function ($cells) {
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });
                    $index++;
                }
            });
        })->export('xls');
    }
//
    public function getDoctorData($where = [])
    {
        $retArr = [];
        $this->resetConnection('dbcenter');
        $this->resetTable('Rep_OrderDetailDaily');
        $model = DB::connection($this->connection)->table($this->table);
        //
        $clums = "DoctorMisId,
                DoctorName,
                CityId,
                ShopId,
                SUM(CASE WHEN SourceId=3 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS wx_first_order_sum,
                SUM(CASE WHEN SourceId=3 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS wx_further_order_sum,
                SUM(CASE WHEN SourceId=5 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS web_first_order_sum,
                SUM(CASE WHEN SourceId=5 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS web_further_order_sum,
                SUM(CASE WHEN SourceId=11 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS jy160_first_order_sum,
                SUM(CASE WHEN SourceId=11 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS jy160_further_order_sum,
                SUM(CASE WHEN SourceId=8 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS gh_first_order_sum,
                SUM(CASE WHEN SourceId=8 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS gh_further_order_sum,
                SUM(CASE WHEN SourceId=15 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS yjk_first_order_sum,
                SUM(CASE WHEN SourceId=15 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS yjk_further_order_sum,
                SUM(CASE WHEN SourceId not in (1, 2, 3, 4, 5, 14, 17, 18,11,8,15) AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS other_first_order_sum,
                SUM(CASE WHEN SourceId not in (1, 2, 3, 4, 5, 14, 17, 18,11,8,15) AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS other_further_order_sum,
                SUM(CASE WHEN FirstVisitFlag=1  THEN 1 ELSE 0 END) AS first_order_sum,
                SUM(CASE WHEN FirstVisitFlag=2 THEN 1 ELSE 0 END) AS further_order_sum";
        $model->addSelect(DB::raw($clums));
        //条件
        extract($where);
        if (isset($OrderVisitDate) && $OrderVisitDate) {
            $date = explode('~', $OrderVisitDate);
            $model->whereBetween('OrderVisitDate', [trim($date[0]), trim($date[1])]);
        }
        if (isset($DoctorName) && $DoctorName) {
            $model->where('DoctorName', 'like', "%{$DoctorName}%");
        }
        $model->groupBy('DoctorMisId');
        $rst            = $model->paginate($length)->toArray();
        $list           = $model->skip($start)->take($length)->get();
        $retArr['data'] = [];
        ////////////////////////////
        ///////////构造数据////////
        ///////////////////////////
        $tools   = new Tools();
        $shopArr = $tools->getShop(1);
        foreach ($list as $k => $v) {
            $retArr['data'][] = [
                'index'       => $start + $k + 1,
                'DoctorMisId' => $v['DoctorMisId'],
                'CityName'    => $v['CityId'],
                'ShopName'    => isset($shopArr[$v['ShopId']]) ? $shopArr[$v['ShopId']] : $v['ShopId'],
                'DoctorName'  => $v['DoctorName'],
                'Wx_Order'    => [
                    'first_sum'    => $v['wx_first_order_sum'],
                    'further_sum'  => $v['wx_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Web_Order'   => [
                    'first_sum'   => $v['web_first_order_sum'],
                    'further_sum' => $v['web_further_order_sum'],
                    'first_rate'  => 0,
                    'further_sum' => 0,
                ],
                'Jy160_Order' => [
                    'first_sum'    => $v['jy160_first_order_sum'],
                    'further_sum'  => $v['jy160_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Gh_Order'    => [
                    'first_sum'    => $v['gh_first_order_sum'],
                    'further_sum'  => $v['gh_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Yjk_Order'   => [
                    'first_sum'    => $v['yjk_first_order_sum'],
                    'further_sum'  => $v['yjk_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Other_Order' => [
                    'first_sum'    => $v['other_first_order_sum'],
                    'further_sum'  => $v['other_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Total_Order' => [
                    'first_sum'    => $v['first_order_sum'],
                    'further_sum'  => $v['further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
            ];
        }
        //////////////////
        ////计算转换比例//
        /////////////////
        foreach ($retArr['data'] as $k => $v) {
            foreach ($v as $kk => $vv) {
                if (is_array($vv)) {
                    foreach ($vv as $kkk => $vvv) {
                        $retArr['data'][$k][$kk]['first_rate']   = $this->toGetAPercent($vv['first_sum'], $v['Total_Order']['first_sum']);
                        $retArr['data'][$k][$kk]['further_rate'] = $this->toGetAPercent($vv['further_sum'], $v['Total_Order']['further_sum']);
                    }
                }
            }
        }
        $retArr['recordsTotal']    = $rst['total'];
        $retArr['recordsFiltered'] = $rst['total'];
        return $retArr;
    }
//
    public function getShopData($where = [])
    {
        $retArr = [];
        $this->resetConnection('dbcenter');
        $this->resetTable('Rep_OrderDetailDaily');
        $model = DB::connection($this->connection)->table($this->table);
        //
        $clums = "
                CityId,
                ShopId,
                SUM(CASE WHEN SourceId=3 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS wx_first_order_sum,
                SUM(CASE WHEN SourceId=3 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS wx_further_order_sum,
                SUM(CASE WHEN SourceId=5 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS web_first_order_sum,
                SUM(CASE WHEN SourceId=5 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS web_further_order_sum,
                SUM(CASE WHEN SourceId=11 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS jy160_first_order_sum,
                SUM(CASE WHEN SourceId=11 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS jy160_further_order_sum,
                SUM(CASE WHEN SourceId=8 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS gh_first_order_sum,
                SUM(CASE WHEN SourceId=8 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS gh_further_order_sum,
                SUM(CASE WHEN SourceId=15 AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS yjk_first_order_sum,
                SUM(CASE WHEN SourceId=15 AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS yjk_further_order_sum,
                SUM(CASE WHEN SourceId not in (1, 2, 3, 4, 5, 14, 17, 18,11,8,15) AND FirstVisitFlag=1  THEN 1 ELSE 0 END) AS other_first_order_sum,
                SUM(CASE WHEN SourceId not in (1, 2, 3, 4, 5, 14, 17, 18,11,8,15) AND FirstVisitFlag=2  THEN 1 ELSE 0 END) AS other_further_order_sum,
                SUM(CASE WHEN FirstVisitFlag=1  THEN 1 ELSE 0 END) AS first_order_sum,
                SUM(CASE WHEN FirstVisitFlag=2 THEN 1 ELSE 0 END) AS further_order_sum";
        $model->addSelect(DB::raw($clums));
        //条件
        extract($where);
        if (isset($OrderVisitDate) && $OrderVisitDate) {
            $date = explode('~', $OrderVisitDate);
            $model->whereBetween('OrderVisitDate', [trim($date[0]), trim($date[1])]);
        }
        if (isset($CityId) && $CityId) {
            $model->where('CityId', $CityId);
        }
        if (isset($ShopId) && $ShopId) {
            $model->where('ShopId', $ShopId);
        }
        $model->groupBy('ShopId');
        $rst            = $model->paginate($length)->toArray();
        $list           = $model->skip($start)->take($length)->get();
        $retArr['data'] = [];
        ////////////////////////////
        ///////////构造数据////////
        ///////////////////////////
        $tools   = new Tools();
        $shopArr = $tools->getShop(1);
        $cityArr = $tools->getCity(1);
        foreach ($list as $k => $v) {
            $retArr['data'][] = [
                'index'       => $start + $k + 1,
                'CityId'      => $v['CityId'],
                'CityName'    => isset($cityArr[$v['CityId']]) ? $cityArr[$v['CityId']] : $v['CityId'],
                'ShopId'      => $v['ShopId'],
                'ShopName'    => isset($shopArr[$v['ShopId']]) ? $shopArr[$v['ShopId']] : $v['ShopId'],
                'Wx_Order'    => [
                    'first_sum'    => $v['wx_first_order_sum'],
                    'further_sum'  => $v['wx_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Web_Order'   => [
                    'first_sum'   => $v['web_first_order_sum'],
                    'further_sum' => $v['web_further_order_sum'],
                    'first_rate'  => 0,
                    'further_sum' => 0,
                ],
                'Jy160_Order' => [
                    'first_sum'    => $v['jy160_first_order_sum'],
                    'further_sum'  => $v['jy160_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Gh_Order'    => [
                    'first_sum'    => $v['gh_first_order_sum'],
                    'further_sum'  => $v['gh_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Yjk_Order'   => [
                    'first_sum'    => $v['yjk_first_order_sum'],
                    'further_sum'  => $v['yjk_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Other_Order' => [
                    'first_sum'    => $v['other_first_order_sum'],
                    'further_sum'  => $v['other_further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
                'Total_Order' => [
                    'first_sum'    => $v['first_order_sum'],
                    'further_sum'  => $v['further_order_sum'],
                    'first_rate'   => 0,
                    'further_rate' => 0,
                ],
            ];
        }
        //////////////////
        ////计算转换比例//
        /////////////////
        foreach ($retArr['data'] as $k => $v) {
            foreach ($v as $kk => $vv) {
                if (is_array($vv)) {
                    foreach ($vv as $kkk => $vvv) {
                        $retArr['data'][$k][$kk]['first_rate']   = $this->toGetAPercent($vv['first_sum'], $v['Total_Order']['first_sum']);
                        $retArr['data'][$k][$kk]['further_rate'] = $this->toGetAPercent($vv['further_sum'], $v['Total_Order']['further_sum']);
                    }
                }
            }
        }
        $retArr['recordsTotal']    = $rst['total'];
        $retArr['recordsFiltered'] = $rst['total'];
        return $retArr;
    }
//
    public function getSourceData($where = [])
    {
        $retArr = [];
        $this->resetConnection('dbcenter');
        $this->resetTable('Rep_OrderDetailDaily');
        $model  = DB::connection($this->connection)->table($this->table);
        $clumns = "CityId,ShopId,SourceId,FirstVisitFlag,OrderType,OrderStatus,SUM(CASE WHEN FirstVisitFlag=1  THEN 1 ELSE 0 END) AS First_Order_Sum,COUNT(*) AS Order_Sum";
        $model->addSelect(DB::raw($clumns));
        //条件
        extract($where);
        if (isset($OrderVisitDate) && $OrderVisitDate) {
            $date = explode('~', $OrderVisitDate);
            $model->whereBetween('OrderVisitDate', [trim($date[0]), trim($date[1])]);
        }
        if (!isset($action)) {
            $model->whereIn('CityId', [20, 10, 755]);
        }
        $model->groupBy('SourceId')->groupBy('ShopId');
        $rst       = $model->get();
        $tools     = new Tools();
        $cityArr   = $tools->getCity(1);
        $shopArr   = $tools->getShop(1);
        $sourceArr = $tools->getSource();
        //////////////////////////
        ///////初始化数据////////
        /////////////////////////
        $retArr['header'] = [];
        foreach ($sourceArr as $k => $v) {
            if (in_array($k, [3, 5, 17, 18, 28])) {
                $retArr['body'][$k]['Source_Id']        = $k;
                $retArr['body'][$k]['Source_Name']      = $v;
                $retArr['body'][$k]['Order_Sum']        = 0;
                $retArr['body'][$k]['Order_Rate']       = 0;
                $retArr['body'][$k]['First_Order_Sum']  = 0;
                $retArr['body'][$k]['First_Order_Rate'] = 0;
                $retArr['body'][$k]['city']             = [];
            }
        }
        $retArr['sum']['Order_Sum']       = 0;
        $retArr['sum']['First_Order_Sum'] = 0;
        //第一次循环初始化表格头部数据
        foreach ($rst as $k => $v) {
            $retArr['header']['city'][$v['CityId']]['CityId']                         = $v['CityId'];
            $city_name                                                                = isset($cityArr[$v['CityId']]) ? $cityArr[$v['CityId']] : $v['CityId'];
            $retArr['header']['city'][$v['CityId']]['CityName']                       = $city_name;
            $retArr['header']['city'][$v['CityId']]['shop'][$v['ShopId']]['ShopId']   = $v['ShopId'];
            $_shop_name                                                               = isset($shopArr[$v['ShopId']]) ? $shopArr[$v['ShopId']] : $v['ShopId'];
            $shop_name                                                                = mb_strlen($_shop_name) > 4 ? str_replace($city_name, '', $_shop_name) : $_shop_name;
            $retArr['header']['city'][$v['CityId']]['shop'][$v['ShopId']]['ShopName'] = $shop_name;
        }
        //第二次循环构造头部对应的表格主体数据
        foreach ($retArr['header']['city'] as $k => $v) {
            foreach ($v['shop'] as $kk => $vv) {
                foreach ($retArr['body'] as $kkk => $vvv) {
                    ///主体////
                    $retArr['body'][$kkk]['city'][$k]['shop'][$kk]['Order_Sum']        = 0;
                    $retArr['body'][$kkk]['city'][$k]['shop'][$kk]['Order_Rate']       = 0;
                    $retArr['body'][$kkk]['city'][$k]['shop'][$kk]['First_Order_Sum']  = 0;
                    $retArr['body'][$kkk]['city'][$k]['shop'][$kk]['First_Order_Rate'] = 0;
                    $retArr['body'][$kkk]['city'][$k]['Order_Sum']                     = 0;
                    $retArr['body'][$kkk]['city'][$k]['Order_Rate']                    = 0;
                    $retArr['body'][$kkk]['city'][$k]['First_Order_Sum']               = 0;
                    $retArr['body'][$kkk]['city'][$k]['First_Order_Rate']              = 0;
                }
                ///总和///
                $retArr['sum']['city'][$k]['shop'][$kk]['Order_Sum']        = 0;
                $retArr['sum']['city'][$k]['shop'][$kk]['Order_Rate']       = 0;
                $retArr['sum']['city'][$k]['shop'][$kk]['First_Order_Sum']  = 0;
                $retArr['sum']['city'][$k]['shop'][$kk]['First_Order_Rate'] = 0;
                $retArr['sum']['city'][$k]['Order_Sum']                     = 0;
                $retArr['sum']['city'][$k]['Order_Rate']                    = 0;
                $retArr['sum']['city'][$k]['First_Order_Sum']               = 0;
                $retArr['sum']['city'][$k]['First_Order_Rate']              = 0;
            }
        }
        //第三次循环获取渠道-门店对应的数据
        foreach ($rst as $k => $v) {
            if (isset($retArr['body'][$v['SourceId']])) {
                $retArr['body'][$v['SourceId']]['city'][$v['CityId']]['shop'][$v['ShopId']]['Order_Sum']       = $v['Order_Sum'];
                $retArr['body'][$v['SourceId']]['city'][$v['CityId']]['shop'][$v['ShopId']]['First_Order_Sum'] = $v['First_Order_Sum'];
            }
        }
        //第四次循环，计算区域总和
        foreach ($retArr['body'] as $k => $v) {
            foreach ($v['city'] as $kk => $vv) {
                foreach ($vv['shop'] as $kkk => $vvv) {
                    //渠道总和//
                    $retArr['body'][$k]['Order_Sum'] += $vvv['Order_Sum'];
                    $retArr['body'][$k]['First_Order_Sum'] += $vvv['First_Order_Sum'];
                    //区域总和//
                    $retArr['body'][$k]['city'][$kk]['Order_Sum'] += $vvv['Order_Sum'];
                    $retArr['body'][$k]['city'][$kk]['First_Order_Sum'] += $vvv['First_Order_Sum'];
                    //渠道门店总和//
                    $retArr['sum']['city'][$kk]['shop'][$kkk]['Order_Sum'] += $vvv['Order_Sum'];
                    $retArr['sum']['city'][$kk]['shop'][$kkk]['First_Order_Sum'] += $vvv['First_Order_Sum'];
                    //渠道区域总和//
                    $retArr['sum']['city'][$kk]['Order_Sum'] += $vvv['Order_Sum'];
                    $retArr['sum']['city'][$kk]['First_Order_Sum'] += $vvv['First_Order_Sum'];
                    //全区域全渠道合计总和//
                    $retArr['sum']['Order_Sum'] += $vvv['Order_Sum'];
                    $retArr['sum']['First_Order_Sum'] += $vvv['First_Order_Sum'];
                }
            }
        }
        //第四次循环,把数字转换为百分比
        foreach ($retArr['body'] as $k => $v) {
            foreach ($v['city'] as $kk => $vv) {
                foreach ($vv['shop'] as $kkk => $vvv) {
                    //门店占比
                    $retArr['body'][$k]['city'][$kk]['shop'][$kkk]['Order_Rate']       = $this->toGetAPercent($vvv['Order_Sum'], $retArr['body'][$k]['Order_Sum']);
                    $retArr['body'][$k]['city'][$kk]['shop'][$kkk]['First_Order_Rate'] = $this->toGetAPercent($vvv['First_Order_Sum'], $retArr['body'][$k]['First_Order_Sum']);
                }
                //城市占比
                $retArr['body'][$k]['city'][$kk]['Order_Rate']       = $this->toGetAPercent($vv['Order_Sum'], $retArr['body'][$k]['Order_Sum']);
                $retArr['body'][$k]['city'][$kk]['First_Order_Rate'] = $this->toGetAPercent($vv['First_Order_Sum'], $retArr['body'][$k]['First_Order_Sum']);
            }
        }
        //
        foreach ($retArr['sum']['city'] as $k => $v) {
            foreach ($v['shop'] as $kk => $vv) {
                //门店总占比
                $retArr['sum']['city'][$k]['shop'][$kk]['Order_Rate']       = $this->toGetAPercent($vv['Order_Sum'], $retArr['sum']['Order_Sum']);
                $retArr['sum']['city'][$k]['shop'][$kk]['First_Order_Rate'] = $this->toGetAPercent($vv['First_Order_Sum'], $retArr['sum']['First_Order_Sum']);
            }
            //城市总占比
            $retArr['sum']['city'][$k]['Order_Rate']       = $this->toGetAPercent($v['Order_Sum'], $retArr['sum']['Order_Sum']);
            $retArr['sum']['city'][$k]['First_Order_Rate'] = $this->toGetAPercent($v['First_Order_Sum'], $retArr['sum']['First_Order_Sum']);
        }
        //////////////////////////
        /////判断是否导出/////////
        //////////////////////////
        if (isset($action) && in_array($action, ['print', 'excel'])) {
            $excelData             = [];
            $excelData['fileName'] = '渠道贡献';
            $excelData['data']     = $retArr;
            $this->exportSourceExcel($excelData);
        }
        return $retArr;
    }
    //
    public function exportSourceExcel($data = [])
    {
        Excel::create($data['fileName'], function ($excel) use ($data) {
            $excel->sheet($data['fileName'], function ($sheet) use ($data) {
                //构造表格头部数据
                $header = ['#', '渠道', '分类', '合计量'];
                $length = 1;
                foreach ($data['data']['header']['city'] as $k => $v) {
                    foreach ($v['shop'] as $kk => $vv) {
                        $header[] = $vv['ShopName'];
                        $length++;
                    }
                    $header[] = '区域合计';
                }
                //构造每一列对应的字段
                $sheet->row(1, $header);
                $element = range('A', 'Z');
                $times   = floor($length / count($element));
                $start   = 0;
                $eleArr  = [];
                for ($time = 0; $time <= $times; $time++) {
                    for ($start = 0; $start < 26; $start++) {
                        $eleArr[] = $time ? ($element[$time - 1] . $element[$start]) : ($element[$start]);
                    }
                }
                $widthArr = [];
                foreach ($eleArr as $k => $v) {
                    $widthArr[$v] = 15;
                }
                //初始化表格每一行
                $sheet->setWidth($widthArr);
                $sheet->freezeFirstRow();
                //构造数据主体
                $index = 2;
                $body  = [];
                foreach ($data['data']['body'] as $k => $v) {
                    $body[$index][] = $v['Source_Id'];
                    $body[$index][] = $v['Source_Name'];
                    $body[$index][] = "预约|首诊";
                    $body[$index][] = "{$v['Order_Sum']}|{$v['First_Order_Sum']}";
                    foreach ($v['city'] as $kk => $vv) {
                        foreach ($vv['shop'] as $kkk => $vvv) {
                            $body[$index][] = "{$vvv['Order_Rate']}|{$vvv['First_Order_Rate']}";
                        }
                        $body[$index][] = "{$vv['Order_Rate']}|{$vv['First_Order_Rate']}";
                    }
                    $index++;
                }
                $sheet->rows($body);
                //构造总和数据
                $sum           = [];
                $sum[$index][] = "#";
                $sum[$index][] = "合计";
                $sum[$index][] = "预约|首诊";
                $sum[$index][] = "{$data['data']['sum']['Order_Sum']}|{$data['data']['sum']['First_Order_Sum']}";
                foreach ($data['data']['sum']['city'] as $k => $v) {
                    foreach ($v['shop'] as $kk => $vv) {
                        $sum[$index][] = "{$vv['Order_Rate']}|{$vv['First_Order_Rate']}";
                    }
                    $sum[$index][] = "{$v['Order_Rate']}|{$v['First_Order_Rate']}";
                }
                $sheet->rows($sum);

            });
        })->export('xls');
        //构造excel表格数据
        // Excel::create($data['fileName'], function ($excel) use ($data) {
        //     $excel->sheet($data['fileName'], function ($sheet) use ($data) {
        //         //构造表格头部信息
        //         $sheet->row(1, $data['header']);
        //         $sheet->cells("A1:G1", function ($cells) {
        //             $cells->setBackground('#4198db');
        //             $cells->setAlignment('center');
        //             $cells->setValignment('center');
        //             $cells->setFontColor('#ffffff');
        //         });
        //         $sheet->setWidth(array(
        //             'A' => 10,
        //             'B' => 20,
        //             'C' => 30,
        //             'D' => 25,
        //             'E' => 15,
        //             'F' => 15,
        //             'G' => 15,
        //         ));
        //         $sheet->freezeFirstRow();
        //         //构造数据主体
        //         //$sheet->rows($data['body']);
        //         $index = 2;
        //         foreach ($data['body'] as $k => $v) {
        //             $sheet->row($index, $v);
        //             $sheet->cells("A{$index}:G{$index}", function ($cells) {
        //                 $cells->setAlignment('center');
        //                 $cells->setValignment('center');
        //             });
        //             $index++;
        //         }
        //     });
        // })->export('xls');

    }
}
