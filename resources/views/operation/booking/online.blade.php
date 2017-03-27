@extends('common.layout')
@section('content')
    <style>
      .table-bordered thead tr th,.table-bordered tbody tr td,.table-bordered tfoot tr td{
        vertical-align: middle;
        border:1px solid #ddd;
      }
      .table-bordered thead tr th{
        text-align:center;
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
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> 线上预约数据</h3>
        </div>
        <div class="box-body">
        <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="online-nav">
              <li class="active"><a href="#kpi" data-toggle="tab"><i class="fa fa-linkedin text-olive"></i>&nbsp;线上KPI-首诊占比</a></li>
              <li><a href="#rate" data-toggle="tab"><i class="fa fa-balance-scale text-red"></i>&nbsp;取消-预约占比</a></li>
              <li><a href="#doctor" data-toggle="tab"><i class="fa fa-user-md text-orange"></i>&nbsp;医生贡献</a></li>
              <li><a href="#shop" data-toggle="tab"><i class="fa fa-hospital-o text-teal"></i>&nbsp;门店贡献</a></li>
              <li><a href="#source" data-toggle="tab"><i class="fa fa-send-o text-blue"></i>&nbsp;渠道贡献</a></li>
            </ul>
            <div class="tab-content">
            <br/>
              <div class="active tab-pane" id="kpi">
                <form id="kpi-form" method="get" action="">
                  <div class="row">
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>日期选择:</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" name="Sum_Date" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
                  </div>
                  </div>
                  </div>
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>城市选择:</label>
                  <select class="form-control" name="City_Id" onchange="tableObj.cityChange(this,'kpi')">
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
                  <select id="shop-kpi" name="Shop_Id" class="form-control">
                  <option value="">请选择门店</option>
                  @foreach($data['init']['csd'] as $k=>$v)
                  @foreach($v['shops'] as $kk=>$vv)
                  <option class='shop' data="city_no_{{$v['city_no']}}" value="{{$vv['shop_no']}}">{{$vv['shop_nick_name']}}</option>
                  @endforeach
                  @endforeach
                  </select>
                  </div>
                  </div>
                  <!-- <div class="col-md-2">
                  <div class="form-group">
                  <label>预约渠道</label>
                  <select class="form-control">
                  <option>请选择渠道</option>
                  </select>
                  </div>
                  </div> -->
                  <div class="col-md-4">
                  <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="input-group">
                  <button class="btn btn-info margin-r-5" type="button" onClick="tableObj.search('kpi');"><span class="fa fa-search"></span>查询</button>
                  <button class="btn btn-default margin-r-5" type="button" onClick="tableObj.reset('kpi');"><span class="fa fa-undo"></span>重置</button>
                  <button class="btn btn-success" type="button" onClick="tableObj.export('kpi');"><span class="fa fa-file-excel-o"></span>导出</button>
                  </div>
                  </div>
                  </div>
                  </div><!--end /.row-->
                  </form>
                  <div id="kpiBox"></div><!--end #kpiBox-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="rate">
              <form id="rate-form" method="get" action="">
                <div class="row">
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>日期选择:</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" name='OrderConfirmDate' value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
                  </div>
                  </div>
                  </div>
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>城市选择:</label>
                  <select  class="form-control" name="CityId" onchange="tableObj.cityChange(this,'rate')">
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
                  <select id="shop-rate" class="form-control" name='ShopId'>
                  <option value="">请选择门店</option>
                  @foreach($data['init']['csd'] as $k=>$v)
                  @foreach($v['shops'] as $kk=>$vv)
                  <option class='shop' data="city_no_{{$v['city_no']}}" value="{{$vv['shop_no']}}">{{$vv['shop_nick_name']}}</option>
                  @endforeach
                  @endforeach
                  </select>
                  </div>
                  </div>
                  <!-- <div class="col-md-2">
                  <div class="form-group">
                  <label>预约渠道</label>
                  <select class="form-control">
                  <option>请选择渠道</option>
                  </select>
                  </div>
                  </div> -->
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>医生</label>
                  <input type="text" class="form-control" name="DoctorName" placeholder="请输入医生姓名...">
                  </div>
                  </div>
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="input-group">
                  <button class="btn btn-info margin-r-5" type="button" onclick="tableObj.search('rate')"><span class="fa fa-search"></span>查询</button>
                  <button class="btn btn-default margin-r-5" type="button" onclick="tableObj.reset('rate')"><span class="fa fa-undo"></span>重置</button>
                  <button class="btn btn-success" type="button" onClick="tableObj.export('rate');"><span class="fa fa-file-excel-o"></span>导出</button>
                  </div>
                  </div>
                  </div>
                 </div><!--end /.row-->
                 </form>
                <div id="rateBox"></div><!--end #rateBox-->
              </div>
              <!--end /.pane-->
              <div class="tab-pane" id="doctor">
               <form id="doctor-form" method="get" action="">
                <div class="row">
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>预约时间:</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" name="OrderVisitDate" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
                  </div>
                  </div>
                  </div>
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>医生姓名</label>
                  <input type="text" class="form-control" name="DoctorName" placeholder="请输入医生姓名...">
                  </div>
                  </div>
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="input-group">
                  <button class="btn btn-info margin-r-5" type="button" onclick="tableObj.search('doctor')"><span class="fa fa-search"></span>查询</button>
                  <button class="btn btn-default margin-r-5" type="button" onclick="tableObj.reset('doctor')"><span class="fa fa-undo"></span>重置</button>
                  <!-- <button class="btn btn-success" type="button" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button> -->
                  </div>
                  </div>
                  </div>
                  </div><!--end /.row-->
                  </form>
                  <!--#######表格#######-->
                  <div class="row">
                  <div class="col-md-12">
                  <div class="box">
                  <table id="doctorTable" class="table table-bordered table-striped dataTable">
                  <thead>
                  <tr>
                  <th rowspan="2"> # </th>
                  <th rowspan="2"> 门店</th>
                  <th rowspan="2"> 医生[城市]</th>
                  <th rowspan="2"> 分类</th>
                  <th rowspan="2"> 微信</th>
                  <th rowspan="2"> 官网</th>
                  <th colspan="4"> 第三方 </th>
                  <th rowspan="2"> 线上和计量 </th>
                  </tr>
                  <tr>
                  <th> 就医160</th>
                  <th> 挂号网</th>
                  <th> 翼健康</th>
                  <th> 其它</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
                  </table>
                  </div><!--end .box-->
                  </div>
                  </div><!-- /.row-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="shop">
               <form id="shop-form" method="get" action="">
                <div class="row">
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>日期选择:</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" name="OrderVisitDate" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
                  </div>
                  </div>
                  </div>
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>城市选择:</label>
                  <select  class="form-control" name="CityId" onchange="tableObj.cityChange(this,'shop')">
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
                  <select id="shop-shop" class="form-control" name='ShopId'>
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
                  <button class="btn btn-info margin-r-5" type="button" onclick="tableObj.search('shop')"><span class="fa fa-search"></span>查询</button>
                  <button class="btn btn-default margin-r-5" type="button" onclick="tableObj.reset('shop')"><span class="fa fa-undo"></span>重置</button>
                  <!-- <button class="btn btn-success" type="button" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button> -->
                  </div>
                  </div>
                  </div>
                  </div><!--end /.row-->
                </form>
                  <!--#######表格#######-->
                  <div class="row">
                  <div class="col-md-12">
                  <div class="box">
                  <table id="shopTable" class="table table-bordered">
                  <thead>
                  <tr>
                  <th rowspan="2"> # </th>
                  <th rowspan="2"> 所属区域</th>
                  <th rowspan="2"> 门店名称</th>
                  <th rowspan="2"> 分类</th>
                  <th rowspan="2"> 微信</th>
                  <th rowspan="2"> 官网</th>
                  <th colspan="4"> 第三方 </th>
                  <th rowspan="2"> 线上和计量 </th>
                  </tr>
                  <tr>
                  <th> 就医160</th>
                  <th> 挂号网</th>
                  <th> 翼健康</th>
                  <th> 其它</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
                  </table>
                  </div><!--end .box-->
                  </div>
                </div><!-- /.row-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="source">
               <form id="source-form" method="get" action="">
                <div class="row">
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>日期选择:</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" name="OrderVisitDate" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
                  </div>
                  </div>
                  </div>
                  <!-- <div class="col-md-2">
                  <div class="form-group">
                  <label>城市选择</label>
                  <select class="form-control">
                  <option>请选择城市</option>
                  </select>
                  </div>
                  </div>
                  <div class="col-md-2">
                  <div class="form-group">
                  <label>渠道选择</label>
                  <select class="form-control">
                  <option>请选择渠道</option>
                  </select>
                  </div>
                  </div> -->
                  <div class="col-md-6">
                  <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="input-group">
                  <button class="btn btn-info margin-r-5" type="button" onclick="tableObj.search('source')"><span class="fa fa-search"></span>查询</button>
                  <button class="btn btn-default margin-r-5" type="button" onclick="tableObj.reset('source')"><span class="fa fa-undo"></span>重置</button>
                  <button class="btn btn-success margin-r-5" type="button" onClick="tableObj.export('source');"><span class="fa fa-file-excel-o"></span>导出全部</button>
                  <span class="text-red">PS:若要看全部数据，请导出全部数据!</span>
                  </div>
                  </div>
                  </div>
                </div><!--end /.row-->
              </form>
                <div id="sourceBox">

                </div><!--end #sourceBox-->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
        </div><!--end .row-->
      </div><!--end .box-body-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
@stop
