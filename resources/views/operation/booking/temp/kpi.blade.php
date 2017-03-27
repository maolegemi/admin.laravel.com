<!--#######总和#######-->
<div class="box text-blue text-bold">
<div class="row">
<div class="col-md-2">
<div class="description-block">
<span class="description-text">预约总量</span>
<hr/>
<h5 class="description-header">{{number_format($data['Order_Sum'])}}</h5>
</div>
<!-- /.description-block -->
</div>
<div class="col-md-2">
<div class="description-block">
<span class="description-text">自有平台</span>
<hr/>
<h5 class="description-header">{{number_format($data['Own_Order_Sum'])}}</h5>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
<div class="col-md-2">
<div class="description-block">
<span class="description-text">第三方平台</span>
<hr/>
<h5 class="description-header">{{number_format($data['Third_Order_Sum'])}}</h5>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
<div class="col-md-2">
<div class="description-block">
<span class="description-text">线上首诊</span>
<hr/>
<h5 class="description-header">{{number_format($data['First_Order_Sum'])}}</h5>
</div>
<!-- /.description-block -->
</div>
<div class="col-md-2">
<div class="description-block">
<span class="description-text">首诊占比</span>
<hr/>
<h5 class="description-header">{{$data['First_Order_Rate']}}</h5>
</div>
<!-- /.description-block -->
</div>
<div class="col-md-2">
<div class="description-block">
<span class="description-text">复诊占比</span>
<hr/>
<h5 class="description-header">{{$data['Further_Order_Rate']}}</h5>
</div>
<!-- /.description-block -->
</div>
</div><!--end .row-->
</div><!--end .box-->

<!--#######表格#######-->
<div class="box">
<div class="row">
<div class="col-md-12">
<table id="kpi-table" class="table table-bordered">
<thead>
<tr>
<th style="width:80px;">渠道ID</th>
<th style="width:200px;">渠道名称</th>
<th>预约量</th>
<th>线上首诊</th>
<th>首诊占比</th>
<th>线上复诊</th>
<th>预约占比</th>
</tr>
</thead>
<tbody>
@foreach($data['data'] as $k=>$v)
 <tr>
  <td class="text-center">{{$v['Source_Id']}}</td>
  <td>{{$v['Source_Name']}}</td>
  <td class="text-center">{{number_format($v['Order_Sum'])}}</td>
  <td class="text-center">{{number_format($v['First_Order_Sum'])}}</td>
  <td class="text-center">{{$v['First_Order_Rate']}}</td>
  <td class="text-center">{{number_format($v['Further_Order_Sum'])}}</td>
  <td class="text-center">{{$v['Further_Order_Rate']}}</td>
 </tr>
@endforeach
</tbody>
</table>
</div>
</div><!-- /.row-->
</div><!-- .box-->
</div>
<!-- /.tab-pane -->

