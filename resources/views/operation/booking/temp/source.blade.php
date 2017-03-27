<!--#######表格#######-->
<div class="box">
<div class="row">
<div class="col-md-12">

<table class="table table-bordered">
<thead>
<tr>
<th rowspan="2">#</th>
<th rowspan="2">渠道</th>
<th rowspan="2">分类</th>
<th rowspan="2">合计量</th>
    @foreach($data['header']['city'] as $k=>$v)
     <th colspan="{{count($v['shop'])+1}}">{{$v['CityName']}}</th>
    @endforeach()
</tr>
<tr>
    @foreach($data['header']['city'] as $k=>$v)
     @foreach($v['shop'] as $kk=>$vv)
     <th>{{$vv['ShopName']}}</th>
     @endforeach
     <th>合计</th>
    @endforeach
</tr>
</thead>
<tbody>
   @foreach($data['body'] as $k=>$v)
    <tr>
    <td class="text-center">{{$v['Source_Id']}}</td>
    <td class="text-center">{{$v['Source_Name']}}</td>
    <td class="text-center">
    	<span>预约</span>
    	<hr/>
    	<span>首诊</span>
    </td>
    <td class="text-center">
    	<span>{{number_format($v['Order_Sum'])}}</span>
    	<hr/>
    	<span>{{number_format($v['First_Order_Sum'])}}</span>
    </td>
    @foreach($v['city'] as $kk=>$vv)
       @foreach($vv['shop'] as $kkk=>$vvv)
        <td class="text-center">
    	<span>{{$vvv['Order_Rate']}}</span>
    	<hr/>
    	<span>{{$vvv['First_Order_Rate']}}</span>
        </td>
       @endforeach
        <td class="text-center">
    	<span>{{$vv['Order_Rate']}}</span>
    	<hr/>
    	<span>{{$vv['First_Order_Rate']}}</span>
        </td>
    @endforeach
    </tr>
   @endforeach
</tbody>
<tfoot class="text-red">
 <tr>
	<td colspan="2">合计</td>
	<td class="text-center">
	<span>预约</span>
	<hr/>
	<span>首诊</span>
	</td> 
	<td class="text-center">
	<span>{{number_format($data['sum']['Order_Sum'])}}</span>
	<hr/>
	<span>{{number_format($data['sum']['First_Order_Sum'])}}</span>
	</td> 
	@foreach($data['sum']['city'] as $k=>$v)
	 @foreach($v['shop'] as $kk=>$vv)
       <td class="text-center">
		{{$vv['Order_Rate']}}
		<hr/>
		{{$vv['First_Order_Rate']}}
	  </td> 
	 @endforeach
    <td class="text-center">
		{{$v['Order_Rate']}}
		<hr/>
		{{$v['First_Order_Rate']}}
	</td> 
	@endforeach
    </tr>
</tfoot>
</table>
</div> 
</div><!-- .row-->
</div><!--end .box-->