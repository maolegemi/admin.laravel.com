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
          <h3 class="box-title">订单预约明细</h3>
        </div>
        <div class="box-body">

         <form id="booking-detail-form" method="get" action="">
          <div class="row">
             <div class="col-md-2">
             <div class="form-group">
                <label>下单时间:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar-check-o"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" name="OrderConfirmDate" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
                </div>
              </div>
             </div>
             <div class="col-md-2">
             <div class="form-group">
                <label>预约时间:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" value="" name='OrderVisitDate' placeholder="请选择预约时间.." type="text">
                </div>
              </div>
             </div>
             <div class="col-md-2">
             <div class="form-group">
             <label>预约渠道</label>
             <select class="form-control" name="SourceId">
               <option value="">所有渠道</option>
               @foreach($data['init']['source_map'] as $k=>$v)
                  <option value="{{$k}}">{{$v}}</option>
               @endforeach   
             </select>
             </div>
            </div>
            <div class="col-md-2">
             <div class="form-group">
             <label>支付方式</label>
             <select class="form-control" name="PayType">
               <option value="">所有支付</option>
               @foreach($data['init']['pay_mode_map'] as $k=>$v)
                  <option value="{{$k}}">{{$v}}</option>
               @endforeach   
             </select>
             </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>首诊状态</label>
                <select class="form-control" name="FirstVisitFlag">
                  <option value="">请选择状态</option>
                  @foreach($data['init']['visit_state_map'] as $k=>$v)
                  <option value="{{$k}}">{{$v}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>到店状态</label>
                <select class="form-control" name="OrderStatus">
                  <option value="">所有状态</option>
                  @foreach($data['init']['go_shop_state_map'] as $k=>$v)
                  <option value="{{$k}}">{{$v}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <!--end .row-->
          <div class="row">
           <div class="col-md-2">
            <div class="form-group">
            <label>城市选择:</label>
            <select  class="form-control" name="CityId" onchange="orderObj.cityChange(this)">
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
            <select id="shop" class="form-control" name='ShopId'>
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
                <label>医生姓名:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input class="form-control pull-right" name="DoctorName" placeholder="请输入医生姓名.." type="text">
                </div>
              </div>
             </div>
             <div class="col-md-2">
             <div class="form-group">
                <label>患者姓名:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-odnoklassniki"></i>
                  </div>
                  <input class="form-control pull-right" name="PatientName" placeholder="请输入患者姓名.." type="text">
                </div>
              </div>
             </div>
             <div class="col-md-2">
             <div class="form-group">
                <label>&nbsp;</label>
                <div class="input-group">
                  <button class="btn btn-info margin-r-5" type="button" onclick="orderObj.search();"><span class="fa fa-search"></span>查询</button>
                  <button class="btn btn-default margin-r-5" type="button" onclick="orderObj.reset();"><span class="fa fa-undo"></span>重置</button>
                  <button class="btn btn-success margin-r-5" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
                </div>
              </div>
             </div>
          </div>
          </form>

          <!--end .row-->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box">
          <table class="table table-bordered table-hover" id="orderTable">
            <thead class="bg-gray">
              <tr>
                <th class="text-center">订单号</th>
                <th class="text-center">下单时间</th>
                <th class="text-center">预约日期</th>
                <th class="text-center">区域</th>
                <th class="text-center">门店</th>
                <th class="text-center">医生</th>
                <th class="text-center">患者姓名</th>
                <th class="text-center">患者手机</th>
                <th class="text-center">到店状态</th>
                <th class="text-center">订单类型</th>
                <th class="text-center">来源</th>
                <th class="text-center">支付状态</th>
                <th class="text-center">支付类型</th>
                <th class="text-center">是否首诊</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
      </div><!--end .box-->

    </section>
    <!-- /.content -->


@stop
