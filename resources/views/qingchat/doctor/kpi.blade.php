@extends('common.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('/css/qingchat/doctor/kpi.css') }}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        轻问诊数据
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">医生数据统计</h3>
        </div>
        <div class="box-body">
        <form id="qingchat-doctor-kpi-form" action="" method="get">
        <div class="row">
        <div class="col-md-1">
        <div class="form-group">
        <label>快速选择:</label>
        <button type="button" class="btn btn-default btn-primary form-control date" data='15' onclick="kpiObj.quickTime(this)">最近15天</button>
        </div>
        </div>
        <div class="col-md-1">
        <div class="form-group">
        <label>&nbsp;</label>
        <button type="button" class="btn btn-default form-control date" data='30' onclick="kpiObj.quickTime(this)">最近30天</button>
        </div>
        </div>
        <div class="col-md-1">
        <div class="form-group">
        <label>&nbsp;</label>
        <button type="button" class="btn btn-default form-control date" data='180' onclick="kpiObj.quickTime(this)">最近180天</button>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>日期选择:</label>
        <div class="input-group">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input id="Insert_Date" name="Stat_Time" class="form-control pull-right" value="{{date('Y-m-d',strtotime('-15 days'))}} ~ {{date('Y-m-d')}}" type="text">
        </div>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label>&nbsp;</label>
        <div class="input-group">
        <button class="btn btn-info margin-r-5" type="button" onclick="kpiObj.search()"><span class="fa fa-search"></span>查询</button>
        <button class="btn btn-default margin-r-5" type="button" onclick="kpiObj.reset()"><span class="fa fa-undo"></span>重置</button>
        <button class="btn btn-success" type="submit" name="action" value="excel"><span class="fa fa-file-excel-o"></span>导出</button>
        </div>
        </div>
        </div>
        </div><!--end .row-->
        </form>
        </div>
        <!-- /.box-body -->
        </div>
      <!-- /.box -->
      <!--########渠道总数以及各渠道总数########-->
        <div class="box">
        <div class="box-body">
        <div class="row">
          <div class="col-md-1">
            <div class="description-block">
            <span class="description-text">问诊总量</span>
            <hr>
            <h5 class="description-header" id="Doctor_Num">-</h5>
            </div>
          </div>
          <div class="col-md-1">
            <div class="description-block">
            <span class="description-text">新增问诊总量</span>
            <hr>
            <h5 class="description-header" id="LeiJi_NewDoctorNum">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">总问诊量</span>
            <hr>
            <h5 class="description-header" id="Online_ChatNum">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">24H回复总量</span>
            <hr>
            <h5 class="description-header" id="Online_AnswerNum">-</h5>
            </div>
          </div>
          <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">2小时回复总量</span>
            <hr>
            <h5 class="description-header" id="TowHourAnswerNum">-</h5>
            </div>
          </div>
           <div class="col-md-2">
            <div class="description-block">
            <span class="description-text">首次回复总量</span>
            <hr>
            <h5 class="description-header" id="First_AnswerDoctorNum">-</h5>
            </div>
          </div>
          <div class="col-md-1">
            <div class="description-block">
            <span class="description-text">2周回复总量</span>
            <hr>
            <h5 class="description-header" id="TwoWeek_AnswerDoctorNum">-</h5>
            </div>
          </div>
          <div class="col-md-1">
            <div class="description-block">
            <span class="description-text">预约转化总量</span>
            <hr>
            <h5 class="description-header" id="ChatToApp_Num">-</h5>
            </div>
          </div>
        </div><!--end .row-->
        </div><!--end .box-body-->
        </div><!--end .box-->
       
       <div class="box">
        <div class="box-header with-border">
    
        <div class="row">
         <div class="col-md-2">
         <div class="pointBox">
          <button class="btn btn-default btn-sm btn-block" style="text-align:left;position:relative;">
             请选择要查看的数据<span class="text-danger">[问诊量]</span>
            <span class="caret text-right" style="position:absolute;right:2.5%;top:45%;"></span>
          </button>
          <div class="contentBox">
             <dl>
                <dt>
                <label class="title" for="id_00_01">当日问诊医生量</label>
                <div class="select">
                <input id="id_00_01" class="flat-red" checked value="Doctor_Num" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_00_02">当日新增问诊医生量</label>
                <div class="select">
                <input id="id_00_02" class="flat-red" value="LeiJi_NewDoctorNum" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_00_03">累计问诊医生量</label>
                <div class="select">
                <input id="id_00_03" class="flat-red" value="LeiJi_DoctorNum" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_00_04">当天总问诊量</label>
                <div class="select">
                <input id="id_00_04" class="flat-red" checked  value="Online_ChatNum" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_00_05">累计总问诊量</label>
                <div class="select">
                <input id="id_00_05" class="flat-red" value="LeiJi_ChatNum" type="checkbox">
                </div>
                </dt>
             </dl>
          </div>
          </div>
          <!--end .pointBox-->
         </div>
         <div class="col-md-2">
         <div class="pointBox">
          <button class="btn btn-default btn-sm btn-block" style="text-align:left;position:relative;">
             请选择要查看的数据<span class="text-danger">[回复咨询量]</span>
            <span class="caret text-right" style="position:absolute;right:2.5%;top:45%;"></span>
          </button>
          <div class="contentBox">
             <dl>
                <dt>
                <label class="title" for="id_01_01">24H回复咨询量</label>
                <div class="select">
                <input id="id_01_01" class="flat-red" value="Online_AnswerNum" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_01_02">2小时回复咨询量</label>
                <div class="select">
                <input id="id_01_02" class="flat-red" value="TowHourAnswerNum" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_01_03">首次回复医生量</label>
                <div class="select">
                <input id="id_01_03" class="flat-red" value="First_AnswerDoctorNum" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_01_04">两周内有回复</label>
                <div class="select">
                <input id="id_01_04" class="flat-red" value="TwoWeek_AnswerDoctorNum" type="checkbox">
                </div>
                </dt>
             </dl>
          </div>
          </div>
          <!--end .pointBox-->  
         </div>
           
         <div class="col-md-2">
         <div class="pointBox">
          <button class="btn btn-default btn-sm btn-block" style="text-align:left;position:relative;">
             请选择要查看的数据<span class="text-danger">[转换量]</span>
            <span class="caret text-right" style="position:absolute;right:2.5%;top:45%;"></span>
          </button>
          <div class="contentBox">
             <dl>
                <dt>
                <label class="title" for="id_02_01">当日挂号粉丝转换量</label>
                <div class="select">
                <input id="id_02_01" class="flat-red" value="ChangeToFans_Num" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_02_02">当日问诊预约转化量</label>
                <div class="select">
                <input id="id_02_02" class="flat-red" value="ChatToApp_Num" type="checkbox">
                </div>
                </dt>
                <dt>
                <label class="title" for="id_02_03">累计问诊预约转化量</label>
                <div class="select"><input id="id_02_03" value="LeiJi_AppNum" class="flat-red" type="checkbox"></div>
                </dt>
                <dt>
                <label class="title" for="id_02_04">累计挂号粉丝转换量</label>
                <div class="select"><input id="id_02_04" value="LeiJi_ToFansNum" class="flat-red" type="checkbox"></div>
                </dt>
             </dl>
          </div>
          </div>
          <!--end .pointBox-->  
         </div>
        </div>
        <!-- end row-->
        </div>
        <div class="box-body">
         <div class="row">
          <div class="col-md-12">
      
          <div class="chart">
                <div id="lineBox" style="width:100%;height:300px;"></div>
          </div>

          </div>
         </div>
        </div>
        <!-- /.box-body-->

       </div>
      <!-- /.box-->

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">数据表格</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover" id="qingchat-doctor-kpi-table">
               <thead>
                <tr>
                 <th rowspan="2">日期</th>
                 <th colspan="3">问诊医生量</th>
                 <th colspan="2">总问诊量</th>
                 <th colspan="4">回复咨询量</th>
                 <th colspan="4">转换量</th>
                </tr>
                <tr>
                 <th>当天</th>
                 <th>当日新增</th>
                 <th>累计</th>
                 <th>当天</th>
                 <th>累计</th>
                 <th>二十四小时</th>
                 <th>两小时</th>
                 <th>每天新增首次</th>
                 <th>两周内有回复</th>
                 <th>当日挂号粉丝</th>
                 <th>当日问诊预约</th>
                 <th>累计问诊预约</th>
                 <th>累计挂号粉丝</th>
                </tr>
                </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <!-- /.box-body-->
       </div>
      <!-- /.box-->

    </section>
    <!-- /.content -->


@stop
