@extends('common.layout')
@section('content')
      <style>
      .table-bordered thead tr th,.table-bordered tbody tr td{
      vertical-align: middle;
      text-align: center;
      border-color:#ddd;
      }
      </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        财务报表 
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">门店提成运营报表</h3>
        </div>
        <div class="box-body">
         <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="shop-nav">
              <li class="active"><a href="#monthly" data-toggle="tab"><i class="fa fa-calendar-plus-o text-orange margin-r-5"></i>月报表</a></li>
            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
              <div class="active tab-pane" id="monthly">
              <form id="monthly-form" action="" method="get">
              <div class="row">
              <div class="col-md-2">
              <div class="form-group">
              <label>月份选择:</label>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input data='monthpicker' class="form-control pull-right" name="Sum_Month" value="{{date('Y-m',strtotime('-1 month'))}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control" name="City_Id" onchange="operateObj.cityChange(this,'monthly')">
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
              <button class="btn btn-info margin-r-5" type="button" onclick="operateObj.search('monthly')"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default margin-r-5" type="button" onclick="operateObj.reset('monthly')"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success margin-r-5" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
              </form>
              <br/>
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
               <table id="monthlyTable" class="table table-bordered">
                <thead>
                <tr>
                <th rowspan="2" width="5%">区域</th>
                <th rowspan="2" width="5%">门店名称</th>
                <th rowspan="2" width="5%">挂号人次</th>
                <th rowspan="2" width="5%">就诊人数</th>
                <th rowspan="2" width="5%">跑单人次</th>
                <th colspan="2" width="10%">扫码数据</th>
                <th colspan="2" width="10%">回诊数据</th>
                <th colspan="2" width="10%">处方量数据</th>
                <th colspan="2" width="10%">微信预约</th>
                <th colspan="3" width="15%">高峰数据(分钟)</th>
                <th colspan="2" width="10%">爽约数据</th>
                <th colspan="2" width="10%">代煎代寄</th>
                </tr>
                <th>人次</th>
                <th>占比</th>
                <th>人次</th>
                <th>占比</th>
                <th>协定方</th>
                <th>中药饮片</th>
                <th>预约量</th>
                <th>预约率</th>
                <th>候药时间</th>
                <th>就诊时间</th>
                <th>收费时间</th>
                <th>人次</th>
                <th>占比</th>
                <th>处方量</th>
                <th>代寄占比</th>
                </thead>
                <tbody></tbody>
                </table>
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
