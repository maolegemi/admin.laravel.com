<style>
.table-bordered tbody>tr>td,.table-bordered thead>tr>th{
  border:1px solid #ddd;
}
</style>
<table class="table table-bordered">
<thead>
<th>区域</th>
<th>分院</th>
<th>时间日期</th>
<th>业绩额</th>
<th>就诊人次</th>
<th>初诊人次</th>
<th>复诊人次</th>
<th>周回头</th>
<th>跑单量</th>
<th>初诊跑单</th>
<th>复诊跑单</th>
<th>周回诊量</th>
<th>收费时间</th>
<th>高峰候药人次</th>
<th>高峰候药时间</th>
<th>处方量</th>
<th>高峰收费时间</th>
</thead>
<tbody>
<tr>
@foreach($data['company']['citys'] as $k=>$v)
<td rowspan="{{($v['rowNum']+1)*5}}">{{$v['name']}}</td>
<!--循环门店数据-->
@foreach($v['shops'] as $kk=>$vv)
<td rowspan="{{$vv['rowNum']}}">{{ mb_substr($vv['name'],0,4,'utf-8')}}</td>
@foreach($vv['week'] as $kkk=>$vvv)
@if($kkk == 1)
<td>{{$vvv['name']}}</td>
<td>{{$vvv['data']['TotalCharges']}}</td>
<td>{{$vvv['data']['OutpatientNum']}}</td>
<td>{{$vvv['data']['FirstVisitNum']}}</td>
<td>{{$vvv['data']['FurtherVisitNum']}}</td>
<td>{{$vvv['data']['ReturnHeadNum_Week']}}</td>
<td>{{$vvv['data']['EscapeChargeNum']}}</td>
<td>{{$vvv['data']['FirstEscapeChgNum']}}</td>
<td>{{$vvv['data']['FurEscapeChgNum']}}</td>
<td>{{$vvv['data']['ReturnVisitNum_Week']}}</td>
<td>{{$vvv['data']['ChargeTimes']}}</td>
<td>{{$vvv['data']['PeakGetMedNum']}}</td>
<td>{{$vvv['data']['PeakGetMedTmes']}}</td>
<td>{{$vvv['data']['RecipeNum']}}</td>
<td>{{$vvv['data']['PeakChargeTimes']}}</td>
@else
<tr>
<td>{{$vvv['name']}}</td>
<td>{{$vvv['data']['TotalCharges']}}</td>
<td>{{$vvv['data']['OutpatientNum']}}</td>
<td>{{$vvv['data']['FirstVisitNum']}}</td>
<td>{{$vvv['data']['FurtherVisitNum']}}</td>
<td>{{$vvv['data']['ReturnHeadNum_Week']}}</td>
<td>{{$vvv['data']['EscapeChargeNum']}}</td>
<td>{{$vvv['data']['FirstEscapeChgNum']}}</td>
<td>{{$vvv['data']['FurEscapeChgNum']}}</td>
<td>{{$vvv['data']['ReturnVisitNum_Week']}}</td>
<td>{{$vvv['data']['ChargeTimes']}}</td>
<td>{{$vvv['data']['PeakGetMedNum']}}</td>
<td>{{$vvv['data']['PeakGetMedTmes']}}</td>
<td>{{$vvv['data']['RecipeNum']}}</td>
<td>{{$vvv['data']['PeakChargeTimes']}}</td>
@endif 
</tr>
@endforeach
@endforeach
<!--结束门店循环-->
<!--城市循环数据-->
<tr>
<td rowspan="5">{{$v['name']}}汇总</td>
@foreach($v['week'] as $kkk=>$vvv)
@if($kkk == 1)
<td>{{$vvv['name']}}</td>
<td>{{$vvv['data']['TotalCharges']}}</td>
<td>{{$vvv['data']['OutpatientNum']}}</td>
<td>{{$vvv['data']['FirstVisitNum']}}</td>
<td>{{$vvv['data']['FurtherVisitNum']}}</td>
<td>{{$vvv['data']['ReturnHeadNum_Week']}}</td>
<td>{{$vvv['data']['EscapeChargeNum']}}</td>
<td>{{$vvv['data']['FirstEscapeChgNum']}}</td>
<td>{{$vvv['data']['FurEscapeChgNum']}}</td>
<td>{{$vvv['data']['ReturnVisitNum_Week']}}</td>
<td>{{$vvv['data']['ChargeTimes']}}</td>
<td>{{$vvv['data']['PeakGetMedNum']}}</td>
<td>{{$vvv['data']['PeakGetMedTmes']}}</td>
<td>{{$vvv['data']['RecipeNum']}}</td>
<td>{{$vvv['data']['PeakChargeTimes']}}</td>
@else
<tr>
<td>{{$vvv['name']}}</td>
<td>{{$vvv['data']['TotalCharges']}}</td>
<td>{{$vvv['data']['OutpatientNum']}}</td>
<td>{{$vvv['data']['FirstVisitNum']}}</td>
<td>{{$vvv['data']['FurtherVisitNum']}}</td>
<td>{{$vvv['data']['ReturnHeadNum_Week']}}</td>
<td>{{$vvv['data']['EscapeChargeNum']}}</td>
<td>{{$vvv['data']['FirstEscapeChgNum']}}</td>
<td>{{$vvv['data']['FurEscapeChgNum']}}</td>
<td>{{$vvv['data']['ReturnVisitNum_Week']}}</td>
<td>{{$vvv['data']['ChargeTimes']}}</td>
<td>{{$vvv['data']['PeakGetMedNum']}}</td>
<td>{{$vvv['data']['PeakGetMedTmes']}}</td>
<td>{{$vvv['data']['RecipeNum']}}</td>
<td>{{$vvv['data']['PeakChargeTimes']}}</td>
@endif 
</tr>
@endforeach
<!--城市循环结束-->
@endforeach
<!--集团循环数据-->
<tr>
<td rowspan="5" colspan="2">集团汇总</td>
@foreach($data['company']['week'] as $kkk=>$vvv)
@if($kkk == 1)
<td>{{$vvv['name']}}</td>
<td>{{$vvv['data']['TotalCharges']}}</td>
<td>{{$vvv['data']['OutpatientNum']}}</td>
<td>{{$vvv['data']['FirstVisitNum']}}</td>
<td>{{$vvv['data']['FurtherVisitNum']}}</td>
<td>{{$vvv['data']['ReturnHeadNum_Week']}}</td>
<td>{{$vvv['data']['EscapeChargeNum']}}</td>
<td>{{$vvv['data']['FirstEscapeChgNum']}}</td>
<td>{{$vvv['data']['FurEscapeChgNum']}}</td>
<td>{{$vvv['data']['ReturnVisitNum_Week']}}</td>
<td>{{$vvv['data']['ChargeTimes']}}</td>
<td>{{$vvv['data']['PeakGetMedNum']}}</td>
<td>{{$vvv['data']['PeakGetMedTmes']}}</td>
<td>{{$vvv['data']['RecipeNum']}}</td>
<td>{{$vvv['data']['PeakChargeTimes']}}</td>
@else
<tr>
<td>{{$vvv['name']}}</td>
<td>{{$vvv['data']['TotalCharges']}}</td>
<td>{{$vvv['data']['OutpatientNum']}}</td>
<td>{{$vvv['data']['FirstVisitNum']}}</td>
<td>{{$vvv['data']['FurtherVisitNum']}}</td>
<td>{{$vvv['data']['ReturnHeadNum_Week']}}</td>
<td>{{$vvv['data']['EscapeChargeNum']}}</td>
<td>{{$vvv['data']['FirstEscapeChgNum']}}</td>
<td>{{$vvv['data']['FurEscapeChgNum']}}</td>
<td>{{$vvv['data']['ReturnVisitNum_Week']}}</td>
<td>{{$vvv['data']['ChargeTimes']}}</td>
<td>{{$vvv['data']['PeakGetMedNum']}}</td>
<td>{{$vvv['data']['PeakGetMedTmes']}}</td>
<td>{{$vvv['data']['RecipeNum']}}</td>
<td>{{$vvv['data']['PeakChargeTimes']}}</td>
@endif 
</tr>
@endforeach
<!--集团循环结束-->
</tbody>
</table>