@extends('common.layout')
@section('content')
      <style>
      .table,.table > thead > tr > th,.table >tbody > tr > td{
      border-color:#ccc;
      vertical-align:middle;
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
          <h3 class="box-title">区域扫码日统计</h3>
        </div>
        <div class="box-body">
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
          <!-- <div class="col-md-2">
          <div class="form-group">
          <label>城市选择:</label>
          <select class="form-control" name="City_Id">
          <option value="">请选择城市</option>
          @foreach($data['init']['csd'] as $k=>$v)
          <option value="{{$v['city_no']}}">{{$v['city_name']}}</option>
          @endforeach
          </select>
          </div>
          </div> -->
          <div class="col-md-2">
          <div class="form-group">
          <label>折线指标:</label>
          <select class="form-control" id="dailyPoint" onchange="scanObj.pointChange(this,'daily')">
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
          <button class="btn btn-info margin-r-5" type="button" onclick="scanObj.search('daily')"><span class="fa fa-search"></span>查询</button>
          <button class="btn btn-default margin-r-5" type="button" onclick="scanObj.reset('daily')"><span class="fa fa-undo"></span>重置</button>
          <button class="btn btn-success margin-r-5" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
          </div>
          </div>
          </div>
          </div><!--end /.row-->
          </form>
        </div><!--end .box-body-->
      </div>
      <!-- /.box -->
      <!--########渠道总数以及各渠道总数########-->
        <div class="box">
        <div class="box-body">
        <div class="row">
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">扫码净增次数</span>
            <hr>
            <h5 class="description-header" id="New_Scan">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">扫码净增变动值</span>
            <hr>
            <h5 class="description-header" id="New_Scan_v">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">累计扫码次数</span>
            <hr>
            <h5 class="description-header" id="Scan">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">累计扫码次数变动值</span>
            <hr>
            <h5 class="description-header" id="Scan_v">-</h5>
            </div>
          </div>
           <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">累计关注数</span>
            <hr>
            <h5 class="description-header" id="Follow">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">累计关注数变动值</span>
            <hr>
            <h5 class="description-header" id="Follow_v">-</h5>
            </div>
          </div>
        </div><!--end .row-->
        </div><!--end .box-body-->
        </div><!--end .box-->
        <!--########区域扫码数折线图########-->
        <div class="row">
         <div class="col-md-12">
              <div class="box">
              <br/>
              <div id="dailyLineBox" style="width:100%;height:250px;"></div>
           </div>
         </div>
        </div><!--end .row-->
        <div class="box">
        <div class="box-header with-border">
        <h3 class="box-title">数据表格</h3>
        </div>
        <div class="box-body">
        <table id="dailyTable" class="table table-bordered table-hover">
        <thead>
        <tr>
        <th>区域ID</th>
        <th>区域</th>
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
        </div>
        <!-- /.box-body-->
        </div>
        <!-- /.box-->
    </section>
    <!-- /.content -->
@stop
