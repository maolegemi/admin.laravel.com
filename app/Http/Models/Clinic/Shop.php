<?php
namespace App\Http\Models\Clinic;

use App\Http\Models\Common\Basic;
use Excel;
use DB;
class Shop extends Basic
{
    public function __construct()
    {
        $this->connection = 'dbcenter';
        $this->table      = 'Rep_OperationDataDaySum_Shop';
    }
    //
    public function getShopOperationData($where = [], $export = '')
    {
        $retArr      = [];
        $model       = DB::connection($this->connection)->table($this->table);
        $currentWeek = 0; //本周
        $prevWeek    = 0; //上周
        $prevOneWeek = 0; //上一周
        $prevTwoWeek = 0; //上二周
        if ($where['date']) {
            //计算三周前的数据
            $currentWeek  = strtotime("-1 weeks", strtotime($where['date']));
            $prevWeek     = strtotime("-2 weeks", strtotime($where['date']));
            $prevOneWeek  = strtotime("-3 weeks", strtotime($where['date']));
            $prevTwoWeek  = strtotime("-4 weeks", strtotime($where['date']));
            $RegDateStart = date('Y.m.d', $prevTwoWeek);
            $RegDateEnd   = date('Y.m.d', strtotime('-1 day', strtotime($where['date'])));
            $model->where('RegDate', '>=', "{$RegDateStart}")->where('RegDate', '<=', "{$RegDateEnd}");
        }
        if ($where['CityId']) {
            $model->where('CityId', $where['CityId']);
        }
        if ($where['ShopId']) {
            $model->where('ShopId', $where['ShopId']);
        }
        $records = $model->get();
        //构造表格KEYS
        $keys    = 'TotalCharges,OutpatientNum,FirstVisitNum,FirstVisitRate,FurtherVisitNum,FurtherVisitRate,ReturnHeadNum_Week,ReturnHeadNum_Month,EscapeChargeNum,EscapeChargeRate,FirstEscapeChgNum,FirstEscapeChgRate,FurEscapeChgNum,FurEscapeChgRate,ReturnVisitNum_Week,ReturnVisitRate_Week,ReturnVisitNum_Month,ReturnVisitRate_Month,ChargeTimes,ChargeTimes_V,PeakChargeNum,PeakChargeTimes,PeakChargeTimes_V,PeakGetMedNum,PeakGetMedTmes,PeakGetMedTmes_V,PeakVisitNum,PeakVisitTimes,PeakVisitTimes_V,FirstTimeToCome,RecipeNum,RecipeNum_V,RepFryRecipeNum,OralPasteNum';
        $keyArr  = explode(',', $keys);
        $weekArr = [
            'current' => '本周',
            'prev'    => '上周',
            'cycle'   => '环比',
            'prevOne' => '上一周',
            'prevTwo' => '上两周',
        ];
        //初始化集团数据
        foreach ($keyArr as $k => $v) {
            foreach ($weekArr as $kk => $vv) {
                $retArr['company']['week'][$kk]['id']       = 0;
                $retArr['company']['week'][$kk]['name']     = $vv;
                $retArr['company']['week'][$kk]['data'][$v] = 0;
            }
        }
        foreach ($records as $k => $v) {
            $retArr['company']['citys'][$v['CityId']]['id']     = $v['CityId'];
            $retArr['company']['citys'][$v['CityId']]['name']   = $v['CityName'];
            $retArr['company']['citys'][$v['CityId']]['rowNum'] = 0; //城市包含门店数，用来确定表格rowspan值
            //初始化城市汇总数据
            foreach ($keyArr as $kk => $vv) {
                foreach ($weekArr as $kkk => $vvv) {
                    $retArr['company']['citys'][$v['CityId']]['week'][$kkk]['id']        = 0;
                    $retArr['company']['citys'][$v['CityId']]['week'][$kkk]['name']      = $vvv;
                    $retArr['company']['citys'][$v['CityId']]['week'][$kkk]['data'][$vv] = 0;
                }
            }
            $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['id']     = $v['ShopId'];
            $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['name']   = $v['ShopName'];
            $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['rowNum'] = 5; //暂时为5

            //周期
            $RegDateStamp = strtotime(implode('-', explode('.', $v['RegDate'])));
            //本周
            if ($currentWeek <= $RegDateStamp) {
                $dayRange                                                                                   = date('Y-m-d', $currentWeek) . "~" . date('Y-m-d', strtotime('-1 day', strtotime($where['date'])));
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['current']['id']   = $dayRange;
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['current']['name'] = '本周'; //日期
                //周数据
                foreach ($keyArr as $kk => $vv) {
                    $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['current']['data'][$vv] = 0;
                }
                //日数据
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['current']['date'][$v['RegDate']]['id']   = $v['RegDate'];
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['current']['date'][$v['RegDate']]['name'] = $v['RegDate'];
                foreach ($keyArr as $kk => $vv) {
                    $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['current']['date'][$v['RegDate']]['data'][$vv] = isset($v[$vv]) ? $v[$vv] : 0;
                }
            }
            //上周
            if (($RegDateStamp >= $prevWeek) && ($RegDateStamp < $currentWeek)) {
                $dayRange                                                                                = date('Y-m-d', $prevWeek) . "~" . date('Y-m-d', strtotime('-1 day', $currentWeek));
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prev']['id']   = $dayRange;
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prev']['name'] = '上周';
                //周数据
                foreach ($keyArr as $kk => $vv) {
                    $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prev']['data'][$vv] = 0;
                }
                //日数据
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prev']['date'][$v['RegDate']]['id']   = $v['RegDate'];
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prev']['date'][$v['RegDate']]['name'] = $v['RegDate'];
                foreach ($keyArr as $kk => $vv) {
                    $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prev']['date'][$v['RegDate']]['data'][$vv] = isset($v[$vv]) ? $v[$vv] : 0;
                }
            }
            //本周与上周环比
            $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['cycle']['id']   = date('Y-m-d', $prevWeek) . "~" . date('Y-m-d', $currentWeek);
            $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['cycle']['name'] = '环比'; //日期
            foreach ($keyArr as $kk => $vv) {
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['cycle']['data'][$vv] = 0;
            }
            //上一周
            if (($RegDateStamp >= $prevOneWeek) && ($RegDateStamp < $prevWeek)) {
                $dayRange                                                                                   = date('Y-m-d', $prevOneWeek) . "~" . date('Y-m-d', strtotime('-1 day', $prevWeek));
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevOne']['id']   = $dayRange;
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevOne']['name'] = '上一周';
                //周数据
                foreach ($keyArr as $kk => $vv) {
                    $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevOne']['data'][$vv] = 0;
                }
                //日数据
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevOne']['date'][$v['RegDate']]['id']   = $v['RegDate'];
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevOne']['date'][$v['RegDate']]['name'] = $v['RegDate'];
                foreach ($keyArr as $kk => $vv) {
                    $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevOne']['date'][$v['RegDate']]['data'][$vv] = isset($v[$vv]) ? $v[$vv] : 0;
                }
            }
            //上两周
            if (($RegDateStamp >= $prevTwoWeek) && ($RegDateStamp < $prevOneWeek)) {
                $dayRange                                                                                   = date('Y-m-d', $prevTwoWeek) . "~" . date('Y-m-d', strtotime('-1 day', $prevOneWeek));
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevTwo']['id']   = $dayRange;
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevTwo']['name'] = '上两周';
                //周数据
                foreach ($keyArr as $kk => $vv) {
                    $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevTwo']['data'][$vv] = 0;
                }
                //日数据
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevTwo']['date'][$v['RegDate']]['id']   = $v['RegDate'];
                $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevTwo']['date'][$v['RegDate']]['name'] = $v['RegDate'];
                foreach ($keyArr as $kk => $vv) {
                    $retArr['company']['citys'][$v['CityId']]['shops'][$v['ShopId']]['week']['prevTwo']['date'][$v['RegDate']]['data'][$vv] = isset($v[$vv]) ? $v[$vv] : 0;
                }
            }
        }
        //第二次构造数据(计算集团+城市总数+周总数+城市包含门店数)
        foreach ($retArr as $k => $v) {
            foreach ($v['citys'] as $kk => $vv) {
                foreach ($vv['shops'] as $kkk => $vvv) {
                    foreach ($vvv['week'] as $kkkk => $vvvv) {
                        if ($kkkk != 'cycle') {
                            foreach ($vvvv['date'] as $kkkkk => $vvvvv) {
                                foreach ($keyArr as $key => $value) {
                                    //集团总数
                                    $retArr['company']['week'][$kkkk]['data'][$value] += $vvvvv['data'][$value];
                                    //周总数
                                    $sum = $retArr['company']['citys'][$kk]['shops'][$kkk]['week'][$kkkk]['date'][$kkkkk]['data'][$value];
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week'][$kkkk]['data'][$value] += $sum;
                                }
                            }
                        } //end if
                    }
                    $retArr['company']['citys'][$kk]['rowNum']++; //门店数
                    //区域总数
                    foreach ($weekArr as $key => $value) {
                        if ($key != 'cycle') {
                            foreach ($keyArr as $_key => $_value) {
                                if (isset($retArr['company']['citys'][$kk]['shops'][$kkk]['week'][$key])) {
                                    $sum = $retArr['company']['citys'][$kk]['shops'][$kkk]['week'][$key]['data'][$_value];
                                    $retArr['company']['citys'][$kk]['week'][$key]['data'][$_value] += $sum;
                                }
                            }
                        }
                    }
                } //end shop
            }
        }
        //第三次构造数据(计算环比+门店周补全)
        foreach ($retArr as $k => $v) {
            foreach ($v['citys'] as $kk => $vv) {
                foreach ($vv['shops'] as $kkk => $vvv) {
                    foreach ($vvv['week'] as $kkkk => $vvvv) {
                        if ($kkkk == 'cycle') {
                            foreach ($keyArr as $key => $value) {
                                //集团环比(本周与上周)
                                $retArr['company']['week'][$kkkk]['data'][$value] = $v['week']['prev']['data'][$value] - $v['week']['current']['data'][$value];
                                //区域环比(本周与上周)
                                $retArr['company']['citys'][$kk]['week'][$kkkk]['data'][$value] = $vv['week']['prev']['data'][$value] - $vv['week']['current']['data'][$value];
                                //(门店周补全补全)
                                if (!isset($vvv['week']['current'])) {
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['current']['id']           = date('Y-m-d', $currentWeek) . "~" . $where['date'];
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['current']['name']         = '本周';
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['current']['data'][$value] = 0;
                                }
                                if (!isset($vvv['week']['prev'])) {
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prev']['id']           = date('Y-m-d', $prevWeek) . "~" . date('Y-m-d', $currentWeek);
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prev']['name']         = '上周';
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prev']['data'][$value] = 0;
                                }
                                if (!isset($vvv['week']['prevOne'])) {
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prevOne']['id']           = date('Y-m-d', $prevOneWeek) . "~" . date('Y-m-d', $prevWeek);
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prevOne']['name']         = '上一周';
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prevOne']['data'][$value] = 0;
                                }
                                if (!isset($vvv['week']['prevTwo'])) {
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prevTwo']['id']           = date('Y-m-d', $prevTwoWeek) . "~" . date('Y-m-d', $prevOneWeek);
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prevTwo']['name']         = '上两周';
                                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prevTwo']['data'][$value] = 0;
                                }
                                //门店环比[(本周与上周)
                                $retArr['company']['citys'][$kk]['shops'][$kkk]['week'][$kkkk]['data'][$value] = $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['current']['data'][$value] - $retArr['company']['citys'][$kk]['shops'][$kkk]['week']['prev']['data'][$value];
                            }
                        }
                    }
                }
            }
        }
        //第四次构造数据[导出数据](计算占比+平均数)
        if (isset($export) && $export) {
            foreach ($retArr as $k => $v) {
                $retArr[$k]['week'] = $this->toDealWithExportData($v['week']);
                foreach ($v['citys'] as $kk => $vv) {
                    $retArr['company']['citys'][$kk]['week'] = $this->toDealWithExportData($vv['week']);
                    foreach ($vv['shops'] as $kkk => $vvv) {
                        $retArr['company']['citys'][$kk]['shops'][$kkk]['week'] = $this->toDealWithExportData($vvv['week']);
                    }
                }
            }
            return $this->toExportShopOperationData($retArr);
        }
        //第四次构造数据[视图](计算占比+平均数)
        foreach ($retArr as $k => $v) {
            $retArr[$k]['week'] = $this->toDealWithViewData($v['week']);
            foreach ($v['citys'] as $kk => $vv) {
                $retArr['company']['citys'][$kk]['week'] = $this->toDealWithViewData($vv['week']);
                foreach ($vv['shops'] as $kkk => $vvv) {
                    $retArr['company']['citys'][$kk]['shops'][$kkk]['week'] = $this->toDealWithViewData($vvv['week']);
                }
            }
        }
        return $retArr;
    }
    //处理视图数据
    public function toDealWithViewData($wdata = [])
    {
        $retArr = [];
        foreach ($wdata as $k => $v) {
            $_retArr[$k] = $v;
            //$_retArr[$k]['data']['TotalCharges']          = $this->toGetAPercent($v['data']['TotalCharges'],1);
            $_retArr[$k]['data']['FirstVisitRate']        = $this->toGetAPercent($v['data']['FirstVisitNum'], $v['data']['OutpatientNum']); //首诊占比
            $_retArr[$k]['data']['FurtherVisitRate']      = $this->toGetAPercent($v['data']['FurtherVisitNum'], $v['data']['OutpatientNum']); //复诊占比
            $_retArr[$k]['data']['EscapeChargeRate']      = $this->toGetAPercent($v['data']['EscapeChargeNum'], $v['data']['OutpatientNum']); //跑单率
            $_retArr[$k]['data']['FirstEscapeChgRate']    = $this->toGetAPercent($v['data']['FirstEscapeChgNum'], $v['data']['OutpatientNum']); //初诊跑单率
            $_retArr[$k]['data']['FurEscapeChgRate']      = $this->toGetAPercent($v['data']['FurEscapeChgNum'], $v['data']['OutpatientNum']); //复诊跑单率
            $_retArr[$k]['data']['ReturnVisitRate_Week']  = $this->toGetAPercent($v['data']['ReturnVisitNum_Week'], $v['data']['OutpatientNum']); //周回诊单率
            $_retArr[$k]['data']['ReturnVisitRate_Month'] = $this->toGetAPercent($v['data']['ReturnVisitNum_Month'], $v['data']['OutpatientNum']); //月回诊单率

            $_retArr[$k]['data']['ChargeTimes']       = round($v['data']['ChargeTimes'] / 60, 1);
            $_retArr[$k]['data']['ChargeTimes_V']     = $v['data']['OutpatientNum'] ? round($v['data']['ChargeTimes'] / $v['data']['OutpatientNum'], 1) : 0; //收费平均时长
            $_retArr[$k]['data']['PeakChargeTimes']   = round($v['data']['PeakChargeTimes'] / 60, 1); //高峰候诊收费时长
            $_retArr[$k]['data']['PeakChargeTimes_V'] = $v['data']['PeakChargeNum'] ? round($v['data']['PeakChargeTimes'] / $v['data']['PeakChargeNum'], 1) : 0; //高峰候诊收费平均时长
            $_retArr[$k]['data']['PeakGetMedTmes']    = round($v['data']['PeakGetMedTmes'] / 60, 1); //高峰候药时长
            $_retArr[$k]['data']['PeakGetMedTmes_V']  = $v['data']['PeakGetMedNum'] ? round($v['data']['PeakGetMedTmes'] / $v['data']['PeakGetMedNum'], 1) : 0; //高峰候药平均时长
            $_retArr[$k]['data']['PeakVisitTimes']    = round($v['data']['PeakVisitTimes'] / 60, 1); //高峰候诊时长
            $_retArr[$k]['data']['PeakVisitTimes_V']  = $v['data']['PeakVisitNum'] ? round($v['data']['PeakVisitTimes'] / $v['data']['PeakVisitNum'], 1) : 0; //高峰候诊平均时长
            $_retArr[$k]['data']['FirstTimeToCome']   = $v['data']['FirstVisitNum']; //第一次到店
            $_retArr[$k]['data']['RecipeNum_V']       = $v['data']['OutpatientNum'] ? round($v['data']['RecipeNum'] / $v['data']['OutpatientNum'], 1) : 0; //处方人均量
        }
        //重新排序
        $retArr[1] = $_retArr['current'];
        $retArr[2] = $_retArr['prev'];
        $retArr[3] = $_retArr['cycle'];
        $retArr[4] = $_retArr['prevOne'];
        $retArr[5] = $_retArr['prevTwo'];
        return $retArr;
    }
    //处理表格数据
    public function toDealWithExportData($wdata = [])
    {
        $retArr = [];
        foreach ($wdata as $k => $v) {
            $_retArr[$k] = $v;
            //$_retArr[$k]['data']['TotalCharges']          = $this->toGetAPercent($v['data']['TotalCharges'],1);
            $_retArr[$k]['data']['FirstVisitRate']        = $this->toGetAPercent($v['data']['FirstVisitNum'], $v['data']['OutpatientNum']); //首诊占比
            $_retArr[$k]['data']['FurtherVisitRate']      = $this->toGetAPercent($v['data']['FurtherVisitNum'], $v['data']['OutpatientNum']); //复诊占比
            $_retArr[$k]['data']['EscapeChargeRate']      = $this->toGetAPercent($v['data']['EscapeChargeNum'], $v['data']['OutpatientNum']); //跑单率
            $_retArr[$k]['data']['FirstEscapeChgRate']    = $this->toGetAPercent($v['data']['FirstEscapeChgNum'], $v['data']['OutpatientNum']); //初诊跑单率
            $_retArr[$k]['data']['FurEscapeChgRate']      = $this->toGetAPercent($v['data']['FurEscapeChgNum'], $v['data']['OutpatientNum']); //复诊跑单率
            $_retArr[$k]['data']['ReturnVisitRate_Week']  = $this->toGetAPercent($v['data']['ReturnVisitNum_Week'], $v['data']['OutpatientNum']); //周回诊单率
            $_retArr[$k]['data']['ReturnVisitRate_Month'] = $this->toGetAPercent($v['data']['ReturnVisitNum_Month'], $v['data']['OutpatientNum']); //月回诊单率

            $_retArr[$k]['data']['ChargeTimes']       = round($v['data']['ChargeTimes'], 2);
            $_retArr[$k]['data']['ChargeTimes_V']     = $v['data']['OutpatientNum'] ? round($v['data']['ChargeTimes'] / $v['data']['OutpatientNum'], 2) : 0; //收费平均时长
            $_retArr[$k]['data']['PeakChargeTimes']   = round($v['data']['PeakChargeTimes'], 2); //高峰候诊收费时长
            $_retArr[$k]['data']['PeakChargeTimes_V'] = $v['data']['PeakChargeNum'] ? round($v['data']['PeakChargeTimes'] / $v['data']['PeakChargeNum'], 2) : 0; //高峰候诊收费平均时长
            $_retArr[$k]['data']['PeakGetMedTmes']    = round($v['data']['PeakGetMedTmes'], 2); //高峰候药时长
            $_retArr[$k]['data']['PeakGetMedTmes_V']  = $v['data']['PeakGetMedNum'] ? round($v['data']['PeakGetMedTmes'] / $v['data']['PeakGetMedNum'], 2) : 0; //高峰候药平均时长
            $_retArr[$k]['data']['PeakVisitTimes']    = round($v['data']['PeakVisitTimes'], 2); //高峰候诊时长
            $_retArr[$k]['data']['PeakVisitTimes_V']  = $v['data']['PeakVisitNum'] ? round($v['data']['PeakVisitTimes'] / $v['data']['PeakVisitNum'], 2) : 0; //高峰候诊平均时长
            $_retArr[$k]['data']['FirstTimeToCome']   = $v['data']['FirstVisitNum']; //第一次到店
            $_retArr[$k]['data']['RecipeNum_V']       = $v['data']['OutpatientNum'] ? round($v['data']['RecipeNum'] / $v['data']['OutpatientNum'], 2) : 0; //处方人均量
        }
        //重新排序
        $retArr[1] = $_retArr['current'];
        $retArr[2] = $_retArr['prev'];
        $retArr[3] = $_retArr['cycle'];
        $retArr[4] = $_retArr['prevOne'];
        $retArr[5] = $_retArr['prevTwo'];
        return $retArr;
    }
    //导出数据
    public function toExportShopOperationData($_data = [])
    {
        //构造excel表格数据
        $data             = [];
        $fileName         = "运营数据周报表" . date('Y-m-d');
        $data['fileName'] = 'hello PHPExcel';
        $headStr          = "区域,分院,时间日期,业绩额,就诊人次,初诊人次,初诊率,复诊人次,复诊率,周回头,月回头,跑单量,跑单率,初诊跑单,初诊跑单率,复诊跑单,复诊跑单率,周回诊量,周回诊率,月回诊量,月回诊率,收费时间,收费平均时间,高峰收费人次,高峰收费时间,高峰收费平均时间,高峰候药人次,高峰候药时间,高峰候药平均时间,高峰候诊人次,高峰候诊时间,高峰候诊平均时间,第一次到店,处方量,人均调剂量,代煎处方量,膏方处方量";
        $data['header']   = explode(',', $headStr);
        $data['body']     = $_data;
        //dump($data);
        Excel::create($fileName, function ($excel) use ($data) {
            $excel->sheet($data['fileName'], function ($sheet) use ($data) {
                //构造表格头部信息
                $sheet->row(1, $data['header']);
                $sheet->cells("A1:AK1", function ($cells) {
                    $cells->setBackground('#4198db');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontColor('#ffffff');
                });
                $sheet->setWidth(array(
                    'A'  => 10,
                    'B'  => 20,
                    'C'  => 30,
                    'D'  => 25,
                    'E'  => 15,
                    'F'  => 15,
                    'G'  => 15,
                    'H'  => 15,
                    'I'  => 15,
                    'J'  => 15,
                    'K'  => 15,
                    'L'  => 15,
                    'M'  => 15,
                    'O'  => 15,
                    'P'  => 15,
                    'Q'  => 15,
                    'R'  => 15,
                    'S'  => 15,
                    'T'  => 15,
                    'U'  => 15,
                    'V'  => 15,
                    'W'  => 15,
                    'X'  => 15,
                    'Y'  => 15,
                    'Z'  => 15,
                    'AA' => 10,
                    'AB' => 15,
                    'AC' => 15,
                    'AD' => 15,
                    'AE' => 15,
                    'AF' => 15,
                    'AG' => 15,
                    'AH' => 15,
                    'AI' => 15,
                    'AJ' => 15,
                    'AK' => 15,

                ));
                $sheet->freezeFirstRow();
                //构造数据主体

                $columns = [];
                $index   = 2;
                foreach ($data['body']['company']['citys'] as $k => $v) {
                    //开始
                    $columns['A'][$index][] = $index;
                    //结束
                    $columns['A'][$index][] = $index + (($v['rowNum'] + 1) * 5) - 1;

                    //构造门店周数据
                    foreach ($v['shops'] as $kk => $vv) {
                        //开始
                        $columns['B'][$index][] = $index;
                        //结束
                        $columns['B'][$index][] = $index + 4;
                        foreach ($vv['week'] as $kkk => $vvv) {
                            $_clean = array_merge([$v['name'], $vv['name'], "{$vvv['name']}({$vvv['id']})"], $vvv['data']);
                            $sheet->row($index, $_clean);
                            $sheet->cells("A{$index}:AK{$index}", function ($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                            $index++;
                        }
                    }
                    //构造城市数据
                    //开始
                    $columns['B'][$index][] = $index;
                    //结束
                    $columns['B'][$index][] = $index + 4;
                    foreach ($v['week'] as $kk => $vv) {
                        $_clean = array_merge([$v['name'], "{$v['name']}汇总", "{$vv['name']}"], $vv['data']);
                        $sheet->row($index, $_clean);
                        $sheet->cells("A{$index}:AK{$index}", function ($cells) {
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                        });
                        $index++;
                    }
                } //end foreach
                //构造集团总数据
                //开始
                $columns['A'][$index][] = $index;
                //结束
                $columns['A'][$index][] = $index + 4;
                //开始
                $columns['B'][$index][] = $index;
                //结束
                $columns['B'][$index][] = $index + 4;
                foreach ($data['body']['company']['week'] as $k => $v) {
                    $_clean = array_merge(["", "集团总数据", $v['name']], $v['data']);
                    $sheet->row($index, $_clean);
                    $sheet->cells("A{$index}:AK{$index}", function ($cells) {
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });
                    $index++;
                }
                //合并单元格(列)
                foreach ($columns as $k => $v) {
                    $sheet->setMergeColumn(
                        [
                            'columns' => [$k],
                            'rows'    => $v,
                        ]
                    );
                }

            });
        })->export('xls');
    }

}
