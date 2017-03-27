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
医馆统计 
</h1>
</section>
<!-- Main content -->
<section class="content">  
        <div class="box">
        <div class="box-header with-border">
        <h3 class="box-title">门店经营数据-患者端</h3>
        </div>
        <div class="box-body"> 
        <div class="row">
        <div class="col-md-2">
        <div class="form-group">
        <label>日期选择:</label>
        <div class="input-group">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input id="ResDate" class="form-control pull-right" name="ResDate" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
        </div>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>城市选择:</label>
        <select id="city" class="form-control" name="CityId" onchange="patientObj.cityChange(this)">
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
        <select id="shop" class="form-control" name="ShopId" onchange="patientObj.search()">
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
        <label>渠道选择:</label>
        <select id="source" class="form-control" onchange="patientObj.sourceChange(this);">
        <!-- <option value="">请选择渠道</option> -->
        <option disabled="disabled">自有渠道</option>
        @foreach($data['init']['source']['owner'] as $k=>$v)
        <option value="{{$k}}">{{$v}}</option>
        @endforeach
        <option disabled="disabled">第三方渠道</option>
         @foreach($data['init']['source']['third'] as $k=>$v)
        <option value="{{$k}}">{{$v}}</option>
        @endforeach
        </select>
        </div>
        </div>
        <!-- <div class="col-md-3">
        <div class="form-group">
        <label>&nbsp;</label>
        <div class="input-group">
        <button class="btn btn-info margin-r-5" type="button"><span class="fa fa-search"></span>查询</button>
        <button class="btn btn-default margin-r-5" type="button"><span class="fa fa-undo"></span>重置</button>
        <button class="btn btn-success margin-r-5" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
        </div>
        </div>
        </div> -->
        </div><!--end /.row-->
        <!--########图表#######-->
        <div class="row">
          <div class="col-md-12">
           <div class="box box-primary">
             <br/>
             <div id="lineBox" style="height:300px"></div>
             <br/>
           </div>
          </div>
        </div><!--end .row-->
        <div class="row">
          <div class="col-md-6">
           <div class="box box-primary">
             <br/>
             <div id="resPieBox" style="height:400px"></div>
             <br/>
           </div>
          </div>
          <div class="col-md-6">
           <div class="box box-primary">
              <br/>
              <div id="firstPieBox" style="height:400px"></div>
           </div>
          </div>
        </div><!--end .row-->
        <!--#######表格#######-->
        <div class="row">
         <div class="col-md-12">
          <div class="box">
            <table id="patientTable" class="table table-bordered">
              <thead>
                <th>时间日期</th>
                <th>渠道ID</th>
                <th>渠道名称</th>
                <th>城市ID</th>
                <th>城市名称</th>
                <th>门店ID</th>
                <th>门店名称</th>
                <th>预约人数</th>
                <th>首诊人数</th>
              </thead>
              <tbody></tbody>
            </table>
          </div><!--end .box-->
         </div>
        </div><!--end .row-->

        </div><!--end .box-body-->
        </div><!--end .box-->
</section>
<!-- /.content -->
@stop
