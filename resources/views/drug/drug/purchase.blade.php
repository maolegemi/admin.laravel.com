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
        药品分析 
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">药品采购领取</h3>
        </div>
        <div class="box-body">
        <form id="purchase-form" action="" method="get">
        <div class="row">
        <div class="col-md-2">
        <div class="form-group">
        <label>日期选择:</label>
        <div class="input-group">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input data='daterangepicker' class="form-control pull-right" name="Vou_Date" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
        </div>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>城市选择:</label>
        <select class="form-control" name="City_Id" onchange="purchaseObj.cityChange(this)">
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
        <select id="shop" name="Shop_Id" class="form-control">
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
        <label>药品代码</label>
        <input class="form-control" name="Item_Code" type="text" placeholder="请输入完整的代码..">
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>项目名称</label>
        <input class="form-control" name="Item_Name" type="text" placeholder="请输入项目名称..">
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>&nbsp;</label>
        <div class="input-group">
        <button class="btn btn-info margin-r-5" type="button" onclick="purchaseObj.search()"><span class="fa fa-search"></span>查询</button>
        <button class="btn btn-default margin-r-5" type="button" onclick="purchaseObj.reset()"><span class="fa fa-undo"></span>重置</button>
        </div>
        </div>
        </div>
        </div><!--end .row-->
        </form>
        <!--########排行榜########-->
        <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">采购领取前十二名
            <small>
            <label>
            <input id='quantity' checked type="radio" name="orderBar" value="QTY" onChange='purchaseObj.pointChange(this)' />
            数量(总)</label>
            </small>
            <small>
            <label class="margin-r-5">
            <input id='Ret_AllMoney' type="radio" name="orderBar" value="Ret_AllMoney" onChange='purchaseObj.pointChange(this)' />
            成本(总)</label>
            </small>
            <small>
            <label class="margin-r-5">
            <input id='Buy_SumMoney' type="radio" name="orderBar" value="Buy_SumMoney" onChange='purchaseObj.pointChange(this)' />
            零售(总)</label>
            </small>
          </h3>
        </div>
        <div class="box-body">
          <div id="barBox" style="width:100%;height:350px;"></div>
        </div><!--end .box-body-->
        </div><!--end .box-->
        <!--########表格详情########-->
        <div class="box">
        <div class="row">
        <div class="col-md-12">
        <table id="purchaseTable" class="table table-bordered">
          <thead>
            <th>领用日期</th>
            <th>城市</th>
            <th>门店</th>
            <th>科室名称</th>
            <th>药品代码</th>
            <th>项目名称</th>
            <th>基础分类</th>
            <th>领用数量</th>
            <th>进价</th>
            <th>零售价</th>
            <th>成本(总)</th>
            <th>零售(总)</th>
            <th>单位</th>
            <th>规格</th>
            <th>出库单位</th>
            <th>领取单位</th>
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
