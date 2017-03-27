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
        <div class="box">
        <div class="box-header with-border">
        <h3 class="box-title">门店经营报表</h3>
        </div>
        <div class="box-body"> 
        <form id="reoprt-form" action="" method="get">
        <div class="row">
        <div class="col-md-2">
        <div class="form-group">
        <label>日期选择:</label>
        <div class="input-group">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input data='datepicker' class="form-control pull-right" name="date" value="{{date('Y-m-d',strtotime('-1 days'))}}" type="text">
        </div>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>城市选择:</label>
        <select id="city" class="form-control" name="CityId" onchange="reportObj.cityChange(this)">
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
        <select id="shop" class="form-control" name="ShopId"">
        <option value="">请选择门店</option>
         @foreach($data['init']['csd'] as $k=>$v)
          @foreach($v['shops'] as $kk=>$vv)
           <option class='shop' data="city_no_{{$v['city_no']}}" value="{{$vv['shop_no']}}">{{$vv['shop_nick_name']}}</option>
          @endforeach
         @endforeach
        </select>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
        <label>&nbsp;</label>
        <div class="input-group">
        <button class="btn btn-info margin-r-5" type="button" onclick="reportObj.search();"><span class="fa fa-search"></span>查询</button>
        <button class="btn btn-default margin-r-5" type="button" onclick="reportObj.reset();"><span class="fa fa-undo"></span>重置</button>
        <button class="btn btn-success" type="button" value="{{route('clinic.shop.report')}}" onclick="reportObj.export(this)"><span class="fa fa-file-excel-o"></span>导出全部</button>
        <span class="text-red">PS:若要看全部数据，请导出全部数据!</span>
        </div>
        </div>
        </div>
        </div><!--end /.row-->
        </form>
        <!--#######表格#######-->
        <div class="row">
         <div class="col-md-12">
          <div class="box">
              <div id="operateBox"></div>
          </div><!--end .box-->
         </div>
        </div><!--end .row-->

        </div><!--end .box-body-->
        </div><!--end .box-->
</section>
<!-- /.content -->
@stop
