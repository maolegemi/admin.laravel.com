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
        二维码 
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">门店扫码统计</h3>
        </div>
        <div class="box-body">
         <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="shop-nav">
              <li class="active"><a href="#daily" data-toggle="tab"><i class="fa  fa-calendar text-olive margin-r-5"></i>日报表</a></li>
              <!-- <li><a href="#weekly" data-toggle="tab"><i class="fa fa-calendar-check-o text-red margin-r-5"></i>周报表</a></li> -->
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
              <input data='datepicker' class="form-control pull-right" name="Date" value="{{date('Y-m-d',strtotime('-1 days'))}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="City_Id" onchange="scanObj.cityChange(this,'daily')">
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
              <select id="shop-daily" class="form-control" name="Shop_Id">
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
              <input type="hidden" name="type" value="daily">
              <button class="btn btn-info margin-r-5" type="button" onclick="scanObj.search('daily')"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="scanObj.reset('daily')"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success margin-r-5" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
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
                <thead>
                <tr>
                <th>门店ID</th>
                <th>区域</th>
                <th>门店</th>
                <th>扫码净增次数</th>
                <th>扫码净增变动值</th>
                <th>累计扫码次数</th>
                <th>累计扫码次数变动值</th>
                <th>累计关注数</th>
                <th>累计关注数变动值</th>
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
              <label>周期选择:</label>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input data='weekpicker' class="form-control pull-right" name="date" value="{{date('Y-m-d',strtotime('-4 month'))}} " type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="CityId" onchange="scanObj.cityChange(this,'weekly')">
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
              <select id="shop-weekly" class="form-control" name="ShopId">
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
              <input type="hidden" name="type" value="weekly">
              <button class="btn btn-info margin-r-5" type="button" onclick="scanObj.search('weekly')"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="scanObj.reset('weekly')"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success margin-r-5" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
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
                <thead>
                <tr>
                <th>门店ID</th>
                <th>周期</th>
                <th>门店名称</th>
                <th>扫码新用户人数</th>
                <th>新用户-变动值</th>
                <th>累计扫码用户总人数</th>
                <th>累计 - 变动值</th>
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
              <input data='monthpicker' class="form-control pull-right" name="Date" value="{{date('Y-m',strtotime('-1 month'))}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="City_Id" onchange="scanObj.cityChange(this,'monthly')">
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
              <select id="shop-monthly" class="form-control" name="Shop_Id">
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
              <input type="hidden" name="type" value="monthly">
              <button class="btn btn-info margin-r-5" type="button" onclick="scanObj.search('monthly')"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="scanObj.reset('monthly')"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success margin-r-5" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
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
                <thead>
                <tr>
                <th>门店ID</th>
                <th>区域</th>
                <th>门店</th>
                <th>扫码净增次数</th>
                <th>扫码净增变动值</th>
                <th>累计扫码次数</th>
                <th>累计扫码次数变动值</th>
                <th>累计关注数</th>
                <th>累计关注数变动值</th>
                </tr>
                </thead>
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
