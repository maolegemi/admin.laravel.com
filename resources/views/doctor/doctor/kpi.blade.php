@extends('common.layout')
@section('content')
      <style>
      .table-bordered thead tr th,.table-bordered tbody tr td{
      vertical-align: middle;
      text-align: center;
      }
      </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        医生业绩
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">医生业绩数据</h3>
        </div>
        <div class="box-body">
         <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="doctor-kpi-nav">
              <li class="active"><a href="#daily" data-toggle="tab"><i class="fa  fa-calendar text-olive margin-r-5"></i>日数据</a></li>
              <li><a href="#weekly" data-toggle="tab"><i class="fa fa-calendar-check-o text-red margin-r-5"></i>周数据</a></li>
              <li><a href="#monthly" data-toggle="tab"><i class="fa fa-calendar-plus-o text-orange margin-r-5"></i>月数据</a></li>
            </ul>
            <div class="tab-content">
            <div class="active tab-pane" id="daily">
            <form id="daily-form" action="" method="get">
              <div class="row">
              <div class="col-md-2">
              <div class="form-group">
              <label>日期选择:</label>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input data='daterangepicker' class="form-control pull-right" name="RegDate" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="CityId" onchange="kpiObj.cityChange(this,'daily')">
              <option value="">请选择城市</option>
              @foreach($data['init']['csd'] as $k=>$v)
              <option value="{{$v['city_no']}}">{{$v['city_name']}}</option>
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>门店</label>
              <select id="shop-daily" name="ShopId" class="form-control">
              <option value="">请选择门店</option>
              @foreach($data['init']['csd'] as $k=>$v)
              @foreach($v['shops'] as $kk=>$vv)
              <option class='shop' data="city_no_{{$v['city_no']}}" value="{{$vv['shop_no']}}">{{$vv['shop_nick_name']}}</option>
              @endforeach
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>医生姓名</label>
              <input type="text" class="form-control" name="DoctorName" placeholder="请输入医生姓名..">
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>查看指标:</label>
              <select id="dailyPoint" class="form-control" onchange="kpiObj.pointChange('daily')">
              @foreach($data['init']['point'] as $k=>$v)
              <option value="{{$k}}">{{$v}}</option>
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>&nbsp;</label>
              <div class="input-group">
              <input type="hidden" name="type" value="daily">
              <button class="btn btn-info margin-r-5" type="button" onclick="kpiObj.search('daily')"><span class="fa fa-search"></span>查看</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="kpiObj.reset('daily')"><span class="fa fa-undo"></span>重置</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
            </form>
              <!--########各费用总数########-->
              <div class="box">
              <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">挂号费</span>
                  <hr>
                  <h5 class="description-header" id="dailyRegCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">药品费</span>
                  <hr>
                  <h5 class="description-header" id="dailyDrugCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">协定方（膏方）费</span>
                  <hr>
                  <h5 class="description-header" id="dailyAgreeRecipeCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">检验检查费</span>
                  <hr>
                  <h5 class="description-header" id="dailyExamCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">治疗费</span>
                  <hr>
                  <h5 class="description-header" id="dailyTreatCharges">-</h5>
                  </div>
                </div>
                 <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">无锡贵细</span>
                  <hr>
                  <h5 class="description-header" id="dailyGuixiCharges">-</h5>
                  </div>
                </div>
              </div><!--end .row-->
              </div><!--end .box-body-->
              </div><!--end .box-->
             <!--########报表数据######-->
              <div class="row">
               <div class="col-md-4">
                       <div class="box box-primary">
                       <br/>
                       <div id="dailyPieBox" style="width:100%;height:300px;"></div>
                 </div>
               </div>
               <div class="col-md-8">
                      <div class="box box-primary">
                      <br/>
                      <div id="dailyLineBox" style="width:100%;height:300px;"></div>
                 </div>
               </div>
              </div><!--end .row-->
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
                <table id="dailyTable" class="table table-bordered">
                <thead>
                <tr>
                <th>日期</th>
                <th>门诊量</th>
                <th>挂号费</th>
                <th>药费</th>
                <th>协定方（膏方）费</th>
                <th>检验检查费</th>
                <th>治疗费</th>
                <th>无锡贵细</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
              </div><!--end .box-->
              </div>
              </div><!-- /.row-->
             </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="weekly">
            <form id="weekly-form" action="" method="get">
              <div class="row">
              <div class="col-md-2">
              <div class="form-group">
              <label>周期选择:</label>&nbsp;<span class="badge bg-red">*周四</span>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input data='daterangepicker' class="form-control pull-right" name="SummaryWeek" value="{{date('Y-m-d',strtotime('-10 weeks',$data['init']['last_thursday']))}} ~ {{date('Y-m-d',$data['init']['last_thursday'])}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="CityId" onchange="kpiObj.cityChange(this,'weekly')">
              <option value="">请选择城市</option>
              @foreach($data['init']['csd'] as $k=>$v)
              <option value="{{$v['city_no']}}">{{$v['city_name']}}</option>
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>门店</label>
              <select id="shop-weekly" name="ShopId" class="form-control">
              <option value="">请选择门店</option>
              @foreach($data['init']['csd'] as $k=>$v)
              @foreach($v['shops'] as $kk=>$vv)
              <option class='shop' data="city_no_{{$v['city_no']}}" value="{{$vv['shop_no']}}">{{$vv['shop_nick_name']}}</option>
              @endforeach
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>医生姓名</label>
              <input type="text" class="form-control" name="DoctorName" placeholder="请输入医生姓名..">
              </div>
              </div>
               <div class="col-md-2">
              <div class="form-group">
              <label>查看指标:</label>
              <select id="weeklyPoint" class="form-control" onchange="kpiObj.pointChange('weekly')">
              @foreach($data['init']['point'] as $k=>$v)
              <option value="{{$k}}">{{$v}}</option>
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>&nbsp;</label>
              <div class="input-group">
              <input type="hidden" name="type" value="weekly">
              <button class="btn btn-info margin-r-5" type="button" onclick="kpiObj.search('weekly')"><span class="fa fa-search"></span>查看</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="kpiObj.reset('weekly')"><span class="fa fa-undo"></span>重置</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
              </form>
              <!--########各费用总数########-->
              <div class="box">
              <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">挂号费</span>
                  <hr>
                  <h5 class="description-header" id="weeklyRegCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">药品费</span>
                  <hr>
                  <h5 class="description-header" id="weeklyDrugCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">协定方（膏方）费</span>
                  <hr>
                  <h5 class="description-header" id="weeklyAgreeRecipeCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">检验检查费</span>
                  <hr>
                  <h5 class="description-header" id="weeklyExamCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">治疗费</span>
                  <hr>
                  <h5 class="description-header" id="weeklyTreatCharges">-</h5>
                  </div>
                </div>
                 <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">无锡贵细</span>
                  <hr>
                  <h5 class="description-header" id="weeklyGuixiCharges">-</h5>
                  </div>
                </div>
              </div><!--end .row-->
              </div><!--end .box-body-->
              </div><!--end .box-->
              <!--########报表数据######-->
              <div class="row">
               <div class="col-md-4">
                       <div class="box box-primary">
                       <br/>
                       <div id="weeklyPieBox" style="width:100%;height:300px;"></div>
                 </div>
               </div>
               <div class="col-md-8">
                      <div class="box box-primary">
                      <br/>
                      <div id="weeklyLineBox" style="width:100%;height:300px;"></div>
                 </div>
               </div>
              </div><!--end .row-->
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
                <table id="weeklyTable" class="table table-bordered">
                <thead>
                <tr>
                <th>周期</th>
                <th>门诊量</th>
                <th>挂号费</th>
                <th>药费</th>
                <th>协定方（膏方）费</th>
                <th>检验检查费</th>
                <th>治疗费</th>
                <th>无锡贵细</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
              </div><!--end .box-->
              </div>
              </div><!-- /.row-->
             </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="monthly">
            <form id="monthly-form" action="" method="get">
              <div class="row">
              <div class="col-md-2">
              <div class="form-group">
              <label>月份开始:</label>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input data='daterangepicker' class="form-control pull-right" name="SummaryMonth" value="{{date('Y-m-d',strtotime('-1 year'))}} ~ {{date('Y-m-d')}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="CityId" onchange="kpiObj.cityChange(this,'monthly')">
              <option value="">请选择城市</option>
              @foreach($data['init']['csd'] as $k=>$v)
              <option value="{{$v['city_no']}}">{{$v['city_name']}}</option>
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>门店</label>
              <select id="shop-monthly" name="ShopId" class="form-control">
              <option value="">请选择门店</option>
              @foreach($data['init']['csd'] as $k=>$v)
              @foreach($v['shops'] as $kk=>$vv)
              <option class='shop' data="city_no_{{$v['city_no']}}" value="{{$vv['shop_no']}}">{{$vv['shop_nick_name']}}</option>
              @endforeach
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>医生姓名</label>
              <input type="text" class="form-control" name="DoctorName" placeholder="请输入医生姓名..">
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>查看指标:</label>
              <select id="monthlyPoint" class="form-control" onchange="kpiObj.pointChange('monthly')">
              @foreach($data['init']['point'] as $k=>$v)
              <option value="{{$k}}">{{$v}}</option>
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>&nbsp;</label>
              <div class="input-group">
              <input type="hidden" name="type" value="monthly">
              <button class="btn btn-info margin-r-5" type="button" onclick="kpiObj.search('monthly')"><span class="fa fa-search"></span>查看</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="kpiObj.reset('monthly')"><span class="fa fa-undo"></span>重置</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
            </form>
              <!--########各费用总数########-->
              <div class="box">
              <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">挂号费</span>
                  <hr>
                  <h5 class="description-header" id="monthlyRegCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">药品费</span>
                  <hr>
                  <h5 class="description-header" id="monthlyDrugCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">协定方（膏方）费</span>
                  <hr>
                  <h5 class="description-header" id="monthlyAgreeRecipeCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">检验检查费</span>
                  <hr>
                  <h5 class="description-header" id="monthlyExamCharges">-</h5>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">治疗费</span>
                  <hr>
                  <h5 class="description-header" id="monthlyTreatCharges">-</h5>
                  </div>
                </div>
                 <div class="col-md-2">
                  <div class="description-block">
                  <span class="description-text">无锡贵细</span>
                  <hr>
                  <h5 class="description-header" id="monthlyGuixiCharges">-</h5>
                  </div>
                </div>
              </div><!--end .row-->
              </div><!--end .box-body-->
              </div><!--end .box-->
              <!--########报表数据######-->
              <div class="row">
               <div class="col-md-4">
                       <div class="box box-primary">
                       <br/>
                       <div id="monthlyPieBox" style="width:100%;height:300px;"></div>
                 </div>
               </div>
               <div class="col-md-8">
                      <div class="box box-primary">
                      <br/>
                      <div id="monthlyLineBox" style="width:100%;height:300px;"></div>
                 </div>
               </div>
              </div><!--end .row-->
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
                <table id="monthlyTable" class="table table-bordered">
                <thead>
                <tr>
                <th>月份</th>
                <th>门诊量</th>
                <th>挂号费</th>
                <th>药费</th>
                <th>协定方（膏方）费</th>
                <th>检验检查费</th>
                <th>治疗费</th>
                <th>无锡贵细</th>
                </tr>
                </thead>
                <tbody></tbody>
                </table>
              </div><!--end .box-->
              </div>
              </div><!-- /.row-->
             </div>
              <!-- /.tab-pane -->
            </div><!--end .tab-content-->
          </div>
        </div>
        </div><!--end .row-->
        </div><!--end .box-body-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
@stop
