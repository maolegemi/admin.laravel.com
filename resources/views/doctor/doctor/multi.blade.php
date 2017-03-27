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
        医生业绩
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">医生多店出诊数据</h3>
        </div>
        <div class="box-body">
         <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="online-nav">
              <li class="active"><a href="#dayly" data-toggle="tab"><i class="fa  fa-calendar text-olive margin-r-5"></i>日数据</a></li>
              <li><a href="#weekly" data-toggle="tab"><i class="fa fa-calendar-check-o text-red margin-r-5"></i>周数据</a></li>
              <li><a href="#monthly" data-toggle="tab"><i class="fa fa-calendar-plus-o text-orange margin-r-5"></i>月数据</a></li>
            </ul>
            <div class="tab-content">
            <div class="active tab-pane" id="dayly">
              <div class="row">
              <div class="col-md-2">
              <div class="form-group">
              <label>日期选择:</label>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input  class="form-control pull-right" id="reservation" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control">
              <option>请选择城市</option>
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>门店</label>
              <select class="form-control">
              <option>请选择门店</option>
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>医生姓名</label>
              <input type="text" class="form-control" placeholder="请输入医生姓名..">
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>查看指标</label>
              <select class="form-control">
              @foreach($data['init']['point'] as $K=>$v)
              <option value="{{$k}}">{{$v}}</option>
              @endforeach
              </select>
              </div>
              </div>
              <div class="col-md-3">
              <div class="form-group">
              <label>&nbsp;</label>
              <div class="input-group">
              <button class="btn btn-info" type="button"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default" type="button"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
                <table class="table table-bordered">
                <thead class="bg-teal">
                <tr>
                <th>#</th>
                <th>所属区域</th>
                <th>所属门店</th>
                <th>医生名字</th>
                <th>日期</th>
                <th>饮片</th>
                <th>中西成药</th>
                <th>治疗</th>
                <th>理疗</th>
                <th>协定方</th>
                <th>贵细</th>
                <th>门诊量</th>
                <th>客单价</th>
                <th>总收入</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['init']['list'] as $k=>$v)
                 <tr>
                  <td>{{$k+1}}</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                 </tr>
                @endforeach
                </tbody>
                </table>
              </div><!--end .box-->
              </div>
              </div><!-- /.row-->
             </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="weekly">
              <div class="row">
              <div class="col-md-2">
              <div class="form-group">
              <label>周期选择:</label>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input data='daterangepicker' class="form-control pull-right" id="reservation" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control">
              <option>请选择城市</option>
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>门店</label>
              <select class="form-control">
              <option>请选择门店</option>
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>医生姓名</label>
              <input type="text" class="form-control" placeholder="请输入医生姓名..">
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>&nbsp;</label>
              <div class="input-group">
              <button class="btn btn-info" type="button"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default" type="button"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
               <table class="table table-bordered">
                <thead class="bg-teal">
                <tr>
                <th>#</th>
                <th>所属区域</th>
                <th>所属门店</th>
                <th>医生名字</th>
                <th>周期</th>
                <th>饮片</th>
                <th>中西成药</th>
                <th>治疗</th>
                <th>理疗</th>
                <th>协定方</th>
                <th>贵细</th>
                <th>门诊量</th>
                <th>客单价</th>
                <th>总收入</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['init']['list'] as $k=>$v)
                 <tr>
                  <td>{{$k+1}}</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                 </tr>
                @endforeach
                </tbody>
                </table>
              </div><!--end .box-->
              </div>
              </div><!-- /.row-->
             </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="monthly">
              <div class="row">
              <div class="col-md-2">
              <div class="form-group">
              <label>月份选择:</label>
              <div class="input-group">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input data='daterangepicker' class="form-control pull-right" id="reservation" value="{{date('Y-m-d',strtotime('-1 month'))}} ~ {{date('Y-m-d')}}" type="text">
              </div>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>城市选择:</label>
              <select class="form-control">
              <option>请选择城市</option>
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>门店</label>
              <select class="form-control">
              <option>请选择门店</option>
              </select>
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>医生姓名</label>
              <input type="text" class="form-control" placeholder="请输入医生姓名..">
              </div>
              </div>
              <div class="col-md-2">
              <div class="form-group">
              <label>&nbsp;</label>
              <div class="input-group">
              <button class="btn btn-info" type="button"><span class="fa fa-search"></span>查询</button>
              <button class="btn btn-default" type="button"><span class="fa fa-undo"></span>重置</button>
              <button class="btn btn-success" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
              </div>
              </div>
              </div>
              </div><!--end /.row-->
              <!--#######表格#######-->
              <div class="row">
              <div class="col-md-12">
              <div class="box">
               <table class="table table-bordered">
                <thead class="bg-teal">
                <tr>
                <th>#</th>
                <th>所属区域</th>
                <th>所属门店</th>
                <th>医生名字</th>
                <th>月份</th>
                <th>饮片</th>
                <th>中西成药</th>
                <th>治疗</th>
                <th>理疗</th>
                <th>协定方</th>
                <th>贵细</th>
                <th>门诊量</th>
                <th>客单价</th>
                <th>总收入</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['init']['list'] as $k=>$v)
                 <tr>
                  <td>{{$k+1}}</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                 </tr>
                @endforeach
                </tbody>
                </table>
              </div><!--end .box-->
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
