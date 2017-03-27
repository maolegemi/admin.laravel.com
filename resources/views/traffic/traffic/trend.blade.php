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
        流量分析 
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">流量数据分析</h3>
        </div>
        <div class="box-body">

      <form id="trend-form" action="" method="">
        <div class="row">
        <div class="col-md-2">
        <div class="form-group">
        <label>渠道选择:</label>
        <select class="form-control" id="Source_Id" name="Source_Id" onchange="trendObj.search()">
        <option value="">请选择渠道</option>
        @foreach($data['init']['source'] as $k=>$v)
        <option value="{{$k}}">{{$v}}</option>
        @endforeach
        </select>
        </div>
        </div>
        <div class="col-md-1">
        <div class="form-group">
        <label>快速选择:</label>
          <button type="button" class="btn btn-default btn-primary form-control date" data='15' onclick="trendObj.quickTime(this)">最近15天</button>
        </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
           <label>&nbsp;</label>
           <button type="button" class="btn btn-default form-control date" data='30' onclick="trendObj.quickTime(this)">最近30天</button>
         </div>
        </div>
        <div class="col-md-1">
         <div class="form-group">
           <label>&nbsp;</label>
          <button type="button" class="btn btn-default form-control date" data='180' onclick="trendObj.quickTime(this)">最近180天</button>
         </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>日期选择:</label>
        <div class="input-group">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input readonly type="text" class="form-control" id="Insert_Date" name="Insert_Date" value="{{date('Y-m-d',strtotime('-15 days'))}} ~ {{date('Y-m-d')}}">
        </div>
        </div>
        </div>
        <!-- <div class="col-md-2">
        <div class="form-group">
        <label>对比日期:</label><label class="text-red">*只需选择结束日期</label>
        <div class="input-group">
        <div class="input-group-addon">
        <input type="checkbox" aria-label="...">
        </div>
        <input class="form-control pull-right" placeholder="选择后进行对比.." value="{{date('Y-m-d')}}" type="text">
        </div>
        </div>
        </div> -->
        <div class="col-md-2">
        <div class="form-group">
        <label>&nbsp;</label>
        <div class="input-group">
        <button class="btn btn-info margin-r-5" type="button" onclick="trendObj.search();"><span class="fa fa-search"></span>查看</button>
        <button class="btn btn-default margin-r-5" type="button" onclick="trendObj.reset();"><span class="fa fa-undo"></span>重置</button>
        </div>
        </div>
        </div>
        </div><!--end .row-->
      </form>

        <!--########总数########-->
        <div class="box">
        <div class="box-header bg-gray">
         <p class="text-blue">PS：数据从2016年3月29日开始统计。2016年10月27日始对注册用户来源: PC官网，平安进行了区分。</p>
        </div>
        <div class="box-body">
        <div class="row">
          <div class="col-md-1">
            <div class="description-block">
            <span class="description-text">PV总量</span>
            <hr>
            <h5 class="description-header" id="PV_Sum">-</span></h5>
            </div>
          </div>
          <div class="col-md-1">
            <div class="description-block">
            <span class="description-text">UV总量</span>
            <hr>
            <h5 class="description-header" id="UV_Sum">-</span></h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">注册用户总数</span>
            <hr>
            <h5 class="description-header" id="Register_User_Sum">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">到店总人数</span>
            <hr>
            <h5 class="description-header" id="Arrive_Sum">-</h5>
            </div>
          </div>
           <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">预约总数</span>
            <hr>
            <h5 class="description-header" id="Reservation_Sum">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">新注册用户预约总数</span>
            <hr>
            <h5 class="description-header" id="Inc_Reservation_Sum">-</h5>
            </div>
          </div>
           <div class="col-md-1">
            <div class="description-block">
            <span class="description-text">咨询总数</span>
            <hr>
            <h5 class="description-header" id="Consulting_Sum">-</h5>
            </div>
          </div>
           <div class="col-md-1">
            <div class="description-block">
            <span class="description-text">新增咨询总数</span>
            <hr>
            <h5 class="description-header" id="Inc_Consulting_Sum">-</h5>
            </div>
          </div>
        </div><!--end .row-->
        </div><!--end .box-body-->
        </div><!--end .box-->
        <!--########图表############-->
        <div class="row">
        <div class="col-md-12">
        <div class="box box-primary">
         <div class="box-body">
           <strong><i class="fa fa-bar-chart-o margin-r-5"></i> 访问数据分析</strong>
           <div id="lineBoxVisit" style="height:350px;"></div><!--end lineBox-->
         </div>
        </div><!--end .box-->
        </div>
        </div><!--end .row-->
        <div class="row">
        <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
              <strong><i class="fa fa-bar-chart-o margin-r-5"></i> 用户数据分析</strong>
              <div id="lineBoxUser" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-6">
          <!-- Line chart -->
          <div class="box box-primary">
            <div class="box-body">
              <strong><i class="fa fa-bar-chart-o margin-r-5"></i> 咨询数据分析</strong>
              <div id="lineBoxAsk" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->
          </div>
        </div><!--end .row-->
        <!--########表格详情########-->
        <div class="box" style="display:none;">
        <div class="row">
        <div class="col-md-12">
        <table id="trendTable" class="table table-bordered">
          <thead class="br-gray">
           <tr>
            <th rowspan="2">日期</th>
            <th colspan="3">访问数据</th>
            <th colspan="3">用户数据</th>
            <th colspan="2">咨询数据</th>
           </tr>
           <tr>
             <th>PV量</th>
             <th>UV量</th>
             <th>注册用户数</th>
             <th>到店人数</th>
             <th>预约数</th>
             <th>新预约数</th>
             <th>咨询数 </th>
             <th>新咨询数</th>
           </tr>
          </thead>
          <tbody></tbody>
        </table>
        </div>
        </div><!--end .row-->
        </div><!--end .box-->
        </div><!--end .box-body-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->


@stop
