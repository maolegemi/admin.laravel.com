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
        轻问诊数据
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">医生数据统计</h3>
        </div>
        <div class="box-body">
          <form id="qingchat-doctor-kpi-form" action="" method="get">
           <div class="row">
            <div class="col-md-2">
             <label>快捷选择:</label>
              <div class="form-group">
                  <select class="form-control">
                   <option>最近一周</option>
                   <option>最近一个月</option>
                   <option>最近半年</option>
                  </select>
              </div>
            </div>
            <div class="col-md-2">
             <div class="form-group">
                <label>自定义时间:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" name='Stat_Time' value="{{date('Y-m-d',strtotime('-2 week'))}} ~ {{date('Y-m-d')}}" type="text">
                </div>
              </div>
             </div>
           </div>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-body">
         <div class="row">
          <div class="col-md-2">
          <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-commenting"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">当日问诊医生量(总)</span>
              <span class="info-box-number">410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-2">
          <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-commenting"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">当日新增问诊医生量(总)</span>
              <span class="info-box-number">410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-2">
          <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-commenting"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">当日总问诊量(总)</span>
              <span class="info-box-number">410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-2">
          <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-commenting"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">2小时回复咨询量(总)</span>
              <span class="info-box-number">410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-2">
          <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-commenting"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">首次回复医生量(总)</span>
              <span class="info-box-number">410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-2">
          <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-commenting"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">两周内有回复医生量(总)</span>
              <span class="info-box-number">410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        </div>
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
       <div class="box">
        <div class="box-header with-border">
           <h3 class="box-title">可视化展示</h3>
        </div>
        <div class="box-body">
         <div class="row">
          <div class="col-md-12">

          <div class="chart">
                <canvas id="areaChart" style="height:300px"></canvas>
          </div>

          </div>
         </div>
        </div>
        <!-- /.box-body-->

       </div>
      <!-- /.box-->

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">数据表格</h3>
          <button class="btn btn-default" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover" id="qingchat-doctor-kpi-table">
               <thead>
                <tr>
                 <th rowspan="2">日期</th>
                 <th colspan="3">问诊医生量</th>
                 <th colspan="2">总问诊量</th>
                 <th colspan="4">回复咨询量</th>
                 <th colspan="4">转换量</th>
                </tr>
                <tr>
                 <th>当天</th>
                 <th>当日新增</th>
                 <th>累计</th>
                 <th>当天</th>
                 <th>累计</th>
                 <th>二十四小时</th>
                 <th>两小时</th>
                 <th>每天新增首次</th>
                 <th>两周内有回复</th>
                 <th>当日挂号粉丝</th>
                 <th>当日问诊预约</th>
                 <th>累计问诊预约</th>
                 <th>累计挂号粉丝</th>
                </tr>
                </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <!-- /.box-body-->

       </div>
      <!-- /.box-->

    </section>
    <!-- /.content -->


@stop
