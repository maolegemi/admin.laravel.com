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
        运营数据 
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">门店预约统计</h3>
        </div>
        <div class="box-body">
         <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul id="shop-kpi-nav" class="nav nav-tabs" id="online-nav">
              <li class="active"><a href="#daily" data-toggle="tab"><i class="fa  fa-calendar text-olive margin-r-5"></i>日报表</a></li>
              <li><a href="#weekly" data-toggle="tab"><i class="fa fa-calendar-check-o text-red margin-r-5"></i>周报表</a></li>
              <li><a href="#monthly" data-toggle="tab"><i class="fa fa-calendar-plus-o text-orange margin-r-5"></i>月报表</a></li>
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
              <input data='daterangepicker' class="form-control pull-right" name="Sum_Date" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="City_Id" onchange="shopObj.cityChange(this,'daily')">
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
              <select id="shop-daily" name="Shop_Id" class="form-control">
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
              <label>&nbsp;</label>
              <div class="input-group">
              <input  type="hidden" class="form-control" name="tb"  value="KPIDaySum">
              <button class="btn btn-info margin-r-5" type="button" onclick="shopObj.search('daily')"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="shopObj.reset('daily');"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
              </form>
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
                <table id="dailyTable" class="table table-bordered">
                <thead class="bg-gray">
                <tr>
                <th>日期</th>
                <th>区域</th>
                <th>门店</th>
                <th>放号量</th>
                <th>门诊量</th>
                <th>首诊量</th>
                <th>预约量</th>
                <th>首诊量</th>
                <th>门诊预约率</th>
                <th>首诊预约率</th>
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
               <input data='weekpicker' class="form-control pull-right" name="Sum_Week" value="{{date('Y-m-d',$data['init']['last_thursday'])}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="City_Id" onchange="shopObj.cityChange(this,'weekly')">
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
              <select id="shop-weekly" name="Shop_Id" class="form-control">
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
              <label>&nbsp;</label>
              <div class="input-group">
              <input  type="hidden" class="form-control" name="tb"  value="KPIWeekSum">
              <button class="btn btn-info margin-r-5" type="button" onclick="shopObj.search('weekly')"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="shopObj.reset('weekly');"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
            </form>
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
                <table id="weeklyTable" class="table table-bordered">
                <thead class="bg-gray">
                <tr>
                <th rowspan="2">周期</th>
                <th rowspan="2">区域</th>
                <th rowspan="2">门店</th>
                <th rowspan="2">放号量</th>
                <th rowspan="2">门诊量</th>
                <th rowspan="2">首诊量</th>
                <th rowspan="2">预约量</th>
                <th rowspan="2">首诊量</th>
                <th rowspan="2">门诊预约率</th>
                <th rowspan="2">首诊预约率</th>
                <th colspan="3">线上预约占比</th>
                <th colspan="3">线上首诊占比</th>
                </tr>
                <tr>
                 <th>A</th>
                 <th>B</th>
                 <th>C</th>
                 <th>A</th>
                 <th>B</th>
                 <th>C</th>
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
              <label>月份选择:</label>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
               <input data='monthpicker' class="form-control pull-right" name="Sum_Month" value="{{date('Y-m',strtotime('-1 months'))}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="City_Id" onchange="shopObj.cityChange(this,'monthly')">
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
              <select id="shop-monthly" name="Shop_Id" class="form-control">
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
              <label>&nbsp;</label>
              <div class="input-group">
              <input  type="hidden" class="form-control" name="tb"  value="KPIMonthSum">
              <button class="btn btn-info margin-r-5" type="button" onclick="shopObj.search('monthly')"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="shopObj.reset('monthly');"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
            </form>
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
                <table id="monthlyTable" class="table table-bordered">
                <thead class="bg-gray">
                <tr>
                <th rowspan="2">月份</th>
                <th rowspan="2">区域</th>
                <th rowspan="2">门店</th>
                <th rowspan="2">放号量</th>
                <th rowspan="2">门诊量</th>
                <th rowspan="2">首诊量</th>
                <th rowspan="2">预约量</th>
                <th rowspan="2">首诊量</th>
                <th rowspan="2">门诊预约率</th>
                <th rowspan="2">首诊预约率</th>
                <th colspan="3">线上预约占比</th>
                <th colspan="3">线上首诊占比</th>
                </tr>
                <tr>
                 <th>A</th>
                 <th>B</th>
                 <th>C</th>
                 <th>A</th>
                 <th>B</th>
                 <th>C</th>
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
