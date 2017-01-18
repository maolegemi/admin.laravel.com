@extends('common.layout')
@section('content')

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
          <div class="row">
             <div class="col-md-2">
             <div class="form-group">
                <label>预约时间:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input data='daterangepicker' class="form-control pull-right" name='booking_date' type="text">
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
                  <input data='daterangepicker' class="form-control pull-right" id="reservation" type="text">
                </div>
              </div>
             </div>
             <div class="col-md-2">
              <div class="form-group">
                <label>预约渠道</label>
                <select class="form-control">
                  <option>请选择渠道</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>支付方式</label>
                <select class="form-control">
                  <option>请选择方式</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>首诊状态</label>
                <select class="form-control">
                  <option>请选择状态</option>
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
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>门店选择</label>
                <select class="form-control">
                  <option>请选择门店</option>
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
                  <button class="btn btn-default" type="button"><span class="fa fa-undo"></span>重置</button>
                  <button class="btn btn-default" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
                </div>
              </div>
             </div>
          </div>
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
