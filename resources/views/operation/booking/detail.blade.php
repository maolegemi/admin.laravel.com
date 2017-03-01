@extends('common.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('/css/operation/booking/detail.css') }}">
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
                <label>预约时间:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" value="" name='booking_date' type="text">
                </div>
              </div>
             </div>
             <div class="col-md-2">
             <div class="form-group">
                <label>下单时间:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar-check-o"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" id="reservation" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
                </div>
              </div>
             </div>
             <div class="col-md-2">
              <div class="form-group">
                <label>预约渠道</label>
                <div id="source" class="multiSelectBox">
                  <input class="form-control" readonly placeholder="请选择渠道.." type="text">
                  <div class="contentBox">
                   <dl>
                    @foreach($data['init']['source_map'] as $k=>$v)
                      <dt>
                      <label class="title" for="source_id_{{$k}}">{{$v}}</label>
                      <div class="select">
                      <input id="source_id_{{$k}}" class="flat-red" name="source_id" value="{{$k}}" type="checkbox">
                      </div>
                      </dt>
                    @endforeach
                   </dl>
                </div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>支付方式</label>
                <div id="paymode" class="multiSelectBox">
                  <input class="form-control" readonly placeholder="请选择支付方式.." type="text">
                  <div class="contentBox">
                   <dl>
                    @foreach($data['init']['pay_mode_map'] as $k=>$v)
                      <dt>
                      <label class="title" for="paymode_id_{{$k}}">{{$v}}</label>
                      <div class="select">
                      <input id="paymode_id_{{$k}}" class="flat-red" name="paymode" value="{{$k}}" type="checkbox">
                      </div>
                      </dt>
                    @endforeach
                   </dl>
                </div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>首诊状态</label>
                <select class="form-control">
                  <option>请选择状态</option>
                  @foreach($data['init']['visit_state_map'] as $k=>$v)
                  <option value="{{$k}}">{{$v}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>到店状态</label>
                <select class="form-control">
                  <option>请选择状态</option>
                </select>
              </div>
            </div>
          </div>
          <!--end .row-->
          <div class="row">
           <div class="col-md-2">
              <div class="form-group">
                <label>城市选择</label>
                <select class="form-control">
                 <option>请选择城市</option>
                 @foreach($data['init']['city_shop_map'] as $k=>$v)
                 <option value="{{$v['city_no']}}">{{$v['city_name']}}</option>
                 @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>门店选择</label>
                <select class="form-control">
                  <option>请选择门店</option>
                  @foreach($data['init']['city_shop_map'] as $k=>$v)
                   @foreach($v['shops'] as $kk=>$vv)
                   <option value="{{$vv['shop_no']}}">{{$vv['shop_nick_name']}}</option>
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
                  <input class="form-control pull-right" type="text">
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
                  <input class="form-control pull-right" type="text">
                </div>
              </div>
             </div>
             <div class="col-md-2">
             <div class="form-group">
                <label>&nbsp;</label>
                <div class="input-group">
                  <button class="btn btn-default" type="button"><span class="fa fa-search"></span>查询</button>
                  <button class="btn btn-default" type="button" onclick="orderObj.reset('#booking-detail-form');"><span class="fa fa-undo"></span>重置</button>
                  <button class="btn btn-default" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
                </div>
              </div>
             </div>
          </div>
          </form>
          <!--end .row-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <table class="table table-bordered table-hover" id="booking-daily-list">
            <thead>
              <tr>
                <th class="text-center">订单号</th>
                <th class="text-center">患者姓名</th>
                <th class="text-center">患者手机</th>
                <th class="text-center">预约日期</th>
                <th class="text-center">到店状态</th>
                <th class="text-center">区域</th>
                <th class="text-center">门店</th>
                <th class="text-center">医生</th>
                <th class="text-center">订单类型</th>
                <th class="text-center">来源</th>
                <th class="text-center">支付状态</th>
                <th class="text-center">支付类型</th>
                <th class="text-center">是否首诊</th>
                <th class="text-center">下单时间</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->


@stop
