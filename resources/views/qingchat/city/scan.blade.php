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
        轻问诊 
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">   
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">区域二维码汇总日报</h3>
        </div>
        <div class="box-body">
      <form id="scan-form" action="" method="get">
        <div class="row">
        <div class="col-md-2">
        <div class="form-group">
        <label>日期选择:</label>
        <div class="input-group">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input data='datepicker' class="form-control pull-right" name="Insert_Date" value="{{date('Y-m-d',strtotime('-1 days'))}}" type="text">
        </div>
        </div>
        </div>
        <!-- <div class="col-md-2">
            <div class="form-group">
            <label>城市选择:</label>
            <select  class="form-control" name="City_Id">
            <option value="">请选择城市</option>
            @foreach($data['init']['csd'] as $k=>$v)
            <option value="{{$v['city_no']}}">{{$v['city_name']}}</option>
            @endforeach
            </select>
            </div>
        </div> -->
        <div class="col-md-2">
        <div class="form-group">
        <label>查看指标:</label>
        <select id="point" class="form-control" onchange="scanObj.pointChange(this)">
            @foreach($data['init']['point'] as $k=>$v)
            <option value="{{$k}}">{{$v}}</option>
            @endforeach
        </select>
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
        <label>&nbsp;</label>
        <div class="input-group">
        <button class="btn btn-info margin-r-5" type="button" onclick="scanObj.search()"><span class="fa fa-search"></span>查询</button>
        <button class="btn btn-default margin-r-5" type="button" onclick="scanObj.reset()"><span class="fa fa-undo"></span>重置</button>
        <button class="btn btn-success margin-r-5" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
        </div>
        </div>
        </div>
        </div><!--end .row-->
        </form>
        <!--##########汇总########-->
         <!--########渠道总数以及各渠道总数########-->
        <div class="box">
        <div class="box-body">
        <div class="row">
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">当日新增粉丝数</span>
            <hr>
            <h5 class="description-header" id="NewFans_Num">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">当日开通二维码人数</span>
            <hr>
            <h5 class="description-header" id="Today_Qrcode_Num">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">当日净增扫码量</span>
            <hr>
            <h5 class="description-header" id="Today_NewScan_Num">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">当月净增扫码量</span>
            <hr>
            <h5 class="description-header" id="Month_New_Scan">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">当日开通轻问诊人数</span>
            <hr>
            <h5 class="description-header" id="KT_QingChart_Num">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">当日有效问题净增量</span>
            <hr>
            <h5 class="description-header" id="Today_EffectAsk_Num">-</h5>
            </div>
          </div>
        </div><!--end .row-->
        </div><!--end .box-body-->
        </div><!--end .box-->
        <!--########视图##########-->
        <div class="row">
           <div class="col-md-12">
                  <div class="box">
                  <br/>
                  <div id="barBox" style="width:100%;height:300px;"></div>
             </div>
           </div>
          </div><!--end .row-->
        <!--########表格详情########-->
        <div class="box">
        <div class="row">
        <div class="col-md-12">
        <table id="scanTable" class="table table-bordered">
          <thead>
            <th>#</th>
            <th>区域</th>
            <th>当日新增粉丝数</th>
            <th>当月粉丝数</th>
            <th>当日开通二维码人数</th>
            <th>累计开通二维码人数(系统上线至今)</th>
            <th>当日净增扫码量</th>
            <th>累计扫码量</th>
            <th>当月净增扫码量</th>
            <th>开通轻问诊人数</th>
            <th>当日有效问题净增量</th>
            <th>有效问题累计量</th>
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
