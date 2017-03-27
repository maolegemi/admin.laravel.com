<!--#######总和#######-->
<div class="box box-primary">
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
<span class="description-text">成功总量</span>
<hr/>
<h5 class="description-header">{{number_format($data['Success_Order_Sum'])}}</h5>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
<div class="col-md-2">
<div class="description-block">
<span class="description-text">取消总量</span>
<hr/>
<h5 class="description-header">{{number_format($data['Cancel_Order_Sum'])}}</h5>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
<div class="col-md-2">
<div class="description-block">
<span class="description-text">爽约总量</span>
<hr/>
<h5 class="description-header">{{number_format($data['Miss_Order_Sum'])}}</h5>
</div>
<!-- /.description-block -->
</div>
<div class="col-md-2">
<div class="description-block">
<span class="description-text">取消率</span>
<hr/>
<h5 class="description-header">{{$data['Cancel_Order_Rate']}}</h5>
</div>
<!-- /.description-block -->
</div>
<div class="col-md-2">
<div class="description-block">
<span class="description-text">爽约率</span>
<hr/>
<h5 class="description-header">{{$data['Miss_Order_Rate']}}</h5>
</div>
<!-- /.description-block -->
</div>
</div><!--end .row-->
</div><!--end .box-->
<!--#######表格#######-->
<div class="box box-primary">
<div class="row">
<div class="col-md-12">
<table class="table table-bordered">
<thead>
<tr>
<th style="width:80px;">渠道ID</th>
<th style="width:250px;">渠道名称</th>
<th>线上预约量</th>
<th>线上取消量</th>
<th>线上爽约量</th>
<th>预约取消率</th>
<th>预约爽约率</th>
</tr>
</thead>
<tbody>
 @foreach($data['data'] as $k=>$v)
  <tr>
   <td class="text-center">{{$v['Source_Id']}}</td>
   <td>{{$v['Source_Name']}}</td>
   <td class="text-center">{{$v['Order_Sum']}}</td>
   <td class="text-center">{{$v['Cancel_Order_Sum']}}</td>
   <td class="text-center">{{$v['Miss_Order_Sum']}}</td>
   <td class="text-center">{{$v['Cancel_Order_Rate']}}</td>
   <td class="text-center">{{$v['Miss_Order_Rate']}}</td>
  </tr>
 @endforeach
</tbody>
</table>
</div>
</div><!-- /.row-->
</div><!--end .box-->

