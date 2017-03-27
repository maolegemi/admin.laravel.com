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
        二维码
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
       <div class="box-header with-border">
          <h3 class="box-title">扫码即时统计 - (天) </h3>
        </div>
        <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs" id="online-nav">
                    <li><a href="#doctor" data-toggle="tab"><i class="fa fa-user-md text-orange margin-r-5"></i>医生二维码</a></li>
                    <li><a href="#shop" data-toggle="tab"><i class="fa fa-hospital-o text-teal margin-r-5"></i>门店二维码</a></li>
                    <li class="active"><a href="#city" data-toggle="tab"><i class="fa fa-map-o text-blue margin-r-5"></i>区域二维码</a></li>
                  </ul>
                  <div class="tab-content">

                  <div class="tab-pane" id="doctor">
                    <div class="row">
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
                      <label>医生名字</label>
                      <input class="form-control" type="text" placeholder="请输入姓名..">
                      </div>
                      </div>
                      <div class="col-md-4">
                      <div class="form-group">
                      <label>&nbsp;</label>
                      <div class="input-group">
                      <button class="btn btn-info" type="button"><span class="fa fa-search"></span>查询</button>
                      <button class="btn btn-default" type="button"><span class="fa fa-undo"></span>重置</button>
                      <button class="btn btn-success" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
                      </div>
                      </div>
                      </div>
                    </div><!--end .row-->
                    <div class="box bg-teal">
                        <div class="row">
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">统计时间</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-red">{{date('Y-m-d H:i:s')}}</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">统计医生总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">100</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">净增人数总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">2,000</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">累计扫码人数总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">200</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div><!--end .row-->
                    </div><!--end .box-->
                    <!--########统计表格#######-->
                        <div class="box">
                        <div class="row">
                        <div class="col-md-12">
                        <table class="table table-bordered">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>所在区域</th>
                        <th>所在门店</th>
                        <th>医生ID</th>
                        <th>医生姓名</th>
                        <th>净增人数</th>
                        <th>累计扫码人数</th>
                        <th>最后扫码时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['init']['list'] as $k=>$v)
                        <tr>
                         <td>{{$k+1}}</td>
                         <td>广州</td>
                         <td>骏景</td>
                         <td>10086</td>
                         <td>李丽云</td>
                         <td>5</td>
                         <td>200</td>
                         <td>{{date('Y-m-d H:i:s')}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        </div><!-- /.row-->
                        </div><!--end .box-->
                  </div><!--end #doctor-->
                  <div class="tab-pane" id="shop">
                      <div class="row">
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
                      <label>门店名字</label>
                      <input class="form-control" type="text" placeholder="请输入门店名..">
                      </div>
                      </div>
                      <div class="col-md-4">
                      <div class="form-group">
                      <label>&nbsp;</label>
                      <div class="input-group">
                      <button class="btn btn-info" type="button"><span class="fa fa-search"></span>查询</button>
                      <button class="btn btn-default" type="button"><span class="fa fa-undo"></span>重置</button>
                      <button class="btn btn-success" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
                      </div>
                      </div>
                      </div>
                    </div><!--end .row-->
                    <div class="box bg-teal">
                        <div class="row">
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">统计时间</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-red">{{date('Y-m-d H:i:s')}}</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">统计门店总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">100</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">净增人数总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">2,000</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">累计扫码人数总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">200</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div><!--end .row-->
                    </div><!--end .box-->
                    <!--########统计表格#######-->
                        <div class="box">
                        <div class="row">
                        <div class="col-md-12">
                        <table class="table table-bordered">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>所在区域</th>
                        <th>门店编号</th>
                        <th>门店名称</th>
                        <th>净增人数</th>
                        <th>累计扫码人数</th>
                        <th>最后扫码时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['init']['list'] as $k=>$v)
                        <tr>
                         <td>{{$k+1}}</td>
                         <td>广州</td>
                         <td>10086</td>
                         <td>骏景</td>
                         <td>5</td>
                         <td>200</td>
                         <td>{{date('Y-m-d H:i:s')}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        </div><!-- /.row-->
                        </div><!--end .box-->
                  </div><!--end #shop-->
                  <div class="active tab-pane" id="city">
                      <div class="row">
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
                      <label>城市名称</label>
                      <input class="form-control" type="text" placeholder="请输入城市名..">
                      </div>
                      </div>
                      <div class="col-md-4">
                      <div class="form-group">
                      <label>&nbsp;</label>
                      <div class="input-group">
                      <button class="btn btn-info" type="button"><span class="fa fa-search"></span>查询</button>
                      <button class="btn btn-default" type="button"><span class="fa fa-undo"></span>重置</button>
                      <button class="btn btn-success" type="button"><span class="fa fa-file-excel-o"></span>导出</button>
                      </div>
                      </div>
                      </div>
                    </div><!--end .row-->
                    <div class="box bg-teal">
                        <div class="row">
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">统计时间</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-red">{{date('Y-m-d H:i:s')}}</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">统计城市总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">100</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">净增人数总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">2,000</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                        <div class="description-block">
                        <span class="description-text">累计扫码人数总数</span>
                        <hr>
                        <h5 class="description-header"><span class="pull-center badge bg-blue">200</span></h5>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div><!--end .row-->
                    </div><!--end .box-->
                    <!--########统计表格#######-->
                        <div class="box">
                        <div class="row">
                        <div class="col-md-12">
                        <table class="table table-bordered">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>城市编号</th>
                        <th>城市名称</th>
                        <th>净增人数</th>
                        <th>累计扫码人数</th>
                        <th>最后扫码时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['init']['list'] as $k=>$v)
                        <tr>
                         <td>{{$k+1}}</td>
                         <td>10086</td>
                         <td>广州</td>
                         <td>5</td>
                         <td>200</td>
                         <td>{{date('Y-m-d H:i:s')}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        </div><!-- /.row-->
                        </div><!--end .box-->
                  </div><!--end #city-->
                  </div><!--end tab-content-->
                </div><!--end nav-tabs-custom-->
              </div>
            </div><!--end .row-->
        </div><!--end .box-body-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->


@stop
