@extends('common.layout')
@section('content')
<style>
.table-bordered thead tr th,.table-bordered tbody tr td{
vertical-align: middle;
text-align: center;
border:1px solid #d7d7d7;
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
        <div class="box">
        <div class="box-header with-border">
        <h3 class="box-title">门店经营数据</h3>
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
        <input id="RegDate" class="form-control pull-right" name="RegDate" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
        </div>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>城市选择:</label>
        <select id="city" class="form-control" name="CityId" onchange="operateObj.cityChange(this)">
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
        <select id="shop" class="form-control" id="ShopId" onchange="operateObj.shopChange(this)">
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
        <label>指标选择:</label>
        <select id="point" class="form-control" onchange="operateObj.pointChange();">
        <option disabled="disabled" class="text-gray">经营指标</option>
        @foreach($data['init']['point']['menage'] as $k=>$v)
        <option value="{{$k}}">{{$v}}</option>
        @endforeach
        <option disabled="disabled" class="text-gray">收入指标</option>
        @foreach($data['init']['point']['income'] as $k=>$v)
        <option value="{{$k}}">{{$v}}</option>
        @endforeach
        <option disabled="disabled" class="text-gray">服务指标</option>
        @foreach($data['init']['point']['service'] as $k=>$v)
        <option value="{{$k}}">{{$v}}</option>
        @endforeach
        </select>
        </div>
        </div>
       <!--  <div class="col-md-3">
        <div class="form-group">
        <label>&nbsp;</label>
        <div class="input-group">
        <button class="btn btn-info margin-r-5" type="button" onclick="operateObj.search();"><span class="fa fa-search"></span>查询</button>
        <button class="btn btn-default margin-r-5" type="button"><span class="fa fa-undo"></span>重置</button>
        <button class="btn btn-success margin-r-5" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
        </div>
        </div>
        </div> -->
        </div><!--end /.row-->
        <!--########图表#######-->
        <div class="row">
          <div class="col-md-6">
           <div class="box box-primary">
             <br/>
             <div id="cityPieBox" style="height:450px"></div>
           </div>
          </div>
          <div class="col-md-6">
           <div class="box box-primary">
              <br/>
              <div id="shopPieBox" style="height:450px"></div>
           </div>
          </div>
        </div><!--end .row-->
        <div class="row">
          <div class="col-md-12">
           <div class="box box-primary">
             <br/>
             <div id="lineBox" style="height:300px"></div>
           </div>
          </div>
        </div><!--end .row-->
        <!--#######表格#######-->
        <div class="row">
         <div class="col-md-12">
          <div class="box">
            <table id="operateTable" class="table table-bordered">  
              <thead>
                <tr>
                  <th rowspan="2">日期</th>
                  <th colspan="2"><i class="fa  fa-strikethrough text-olive margin-r-5"></i>经营数据</th>
                  <th colspan="4"><i class="fa fa-cny text-red margin-r-5"></i>收入数据</th>
                  <th colspan="6"><i class="fa fa-info-circle text-orange margin-r-5"></i>服务数据</th>
                </tr>
                <tr>
                  <th>门诊量</th>
                  <th>收入</th>
                  <th>治疗费用</th>
                  <th>检验检查费用</th>
                  <th>协定方(膏方)费用</th>
                  <th>贵细费用</th>
                  <th>初诊量</th>
                  <th>初诊率</th>
                  <th>复诊率</th>
                  <th>跑单率</th>
                  <th>高峰候药平均时间</th>
                  <th>高峰就诊平均时间</th>
                </tr>
              </thead>

            </table>
          </div><!--end .box-->
         </div>
        </div><!--end .row-->

        </div><!--end .box-body-->
        </div><!--end .box-->
</section>
<!-- /.content -->
@stop
