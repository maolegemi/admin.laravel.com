@extends('common.layout')
@section('content')
      <style>
      .table-bordered thead tr th,.table-bordered tbody tr td{
      vertical-align: middle;
      text-align: center;
      }
      .table-bordered tbody>tr>td,.table-bordered thead>tr>th{
        border:1px solid #dfdfdf;
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
          <h3 class="box-title">来源数据分析</h3>
        </div>
        <div class="box-body">
      <form id="source-form" action="" method="get">
        <div class="row">
        <div class="col-md-1">
        <div class="form-group">
        <label>快速选择:</label>
        <button type="button" class="btn btn-default btn-primary form-control date" data='15' onclick="sourceObj.quickTime(this)">最近15天</button>
        </div>
        </div>
        <div class="col-md-1">
        <div class="form-group">
        <label>&nbsp;</label>
        <button type="button" class="btn btn-default form-control date" data='30' onclick="sourceObj.quickTime(this)">最近30天</button>
        </div>
        </div>
        <div class="col-md-1">
        <div class="form-group">
        <label>&nbsp;</label>
        <button type="button" class="btn btn-default form-control date" data='180' onclick="sourceObj.quickTime(this)">最近180天</button>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>日期选择:</label>
        <div class="input-group">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input id="Insert_Date" name="Insert_Date" class="form-control pull-right" value="{{date('Y-m-d',strtotime('-15 days'))}} ~ {{date('Y-m-d')}}" type="text">
        </div>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>查看指标:</label>
        <select class="form-control" id="Source_Id" onChange="sourceObj.pointChange(this);">
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
        <button class="btn btn-info margin-r-5" type="button" onclick="sourceObj.search()"><span class="fa fa-search"></span>查看</button>
        <button class="btn btn-default" type="button" onclick="sourceObj.reset()"><span class="fa fa-undo"></span>重置</button>
        </div>
        </div>
        </div>
        </div><!--end .row-->
      </form>
        <!--########渠道总数以及各渠道总数########-->
        <div class="box">
        <div class="box-header">
         <p class="text-blue">PS：数据从2016年3月29日开始统计。2016年10月27日始对注册用户来源: PC官网，平安进行了区分。</p>
        </div>
        <div class="box-body">
        <div class="row">
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">渠道总和</span>
            <hr>
            <h5 class="description-header" id="Source_All">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">PC官网</span>
            <hr>
            <h5 class="description-header" id="Source_7">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">平安</span>
            <hr>
            <h5 class="description-header" id="Source_5">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">H5</span>
            <hr>
            <h5 class="description-header" id="Source_4">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">微信</span>
            <hr>
            <h5 class="description-header" id="Source_1">-</h5>
            </div>
          </div>
           <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">其他</span>
            <hr>
            <h5 class="description-header" id="Source_255">-</h5>
            </div>
          </div>
        </div><!--end .row-->
        </div><!--end .box-body-->
        </div><!--end .box-->
        <!--########渠道数据######-->
          <div class="row">
           <div class="col-md-4">
                   <div class="box box-primary">
                   <br/>
                   <div id="pieBox" style="width:100%;height:300px;"></div>
             </div>
           </div>
           <div class="col-md-8">
                  <div class="box box-primary">
                  <br/>
                  <div id="lineBox" style="width:100%;height:300px;"></div>
             </div>
           </div>
          </div><!--end .row-->
        <!--########表格数据######-->
        <div class="box">
        <div class="row">
        <div class="col-md-12">
        <table id="sourceTable" class="table table-bordered">
          <thead>
            <tr>
            <th rowspan="2">日期</th>
            <th rowspan="2">渠道ID</th>
            <th rowspan="2">渠道</th>
            <th colspan="3">访问数据</th>
            <th colspan="3">看诊数据</th>
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
