@extends('common.layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
固生堂-数据平台
</h1>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
    <!-- About Me Box -->
    <div class="box box-danger">
    <div class="box-header with-border">
    <h3 class="box-title text-red"><i class='fa  fa-warning margin-r-5'></i>ERROR当前权限不足</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body text-red">
    <strong><i class="fa  fa-question-circle margin-r-5"></i>帮助：</strong>
     <br/>
     <br/>
     <p>1-注销后重新登录;</p>
     <p>2-联系管理员;</p>
     <p>3-更换登录用户;</p>
    </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
    </div>
</div>
<!-- /.row -->

</section>
<!-- /.content -->


@stop
