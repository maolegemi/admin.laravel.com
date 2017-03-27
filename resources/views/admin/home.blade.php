@extends('common.layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
固生堂-数据平台
<small>{{env('HOST')}}</small>
</h1>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
    <!-- About Me Box -->
    <div class="box box-primary">
    <div class="box-header with-border">
    <h3 class="box-title">平台相关</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <strong><i class="fa fa-database margin-r-5"></i>数据来源</strong>
    <br/><br/>
    <p class="text-muted">地址:{{$data['init']['db_host']}}</p>
    <p class="text-muted">库名:{{$data['init']['db_name']}}</p>
    <p class="text-muted">用户:{{$data['init']['db_user']}}</p>
    <hr>
    <strong><i class="fa fa-user margin-r-5"></i>CGI系统</strong>
    <br/><br/>
    <p class="text-muted">CGI地址:{{$data['init']['cgi_path']}}</p>
    <hr>
    <strong><i class="fa fa-gear margin-r-5"></i>权限系统</strong>
    <br/><br/>
    <p class="text-muted">CAS地址:{{$data['init']['cas_path']}}</p>
    <p class="text-muted">登录账号:{{$admin['admin_name']}}</p>
    <p class="text-muted">真实姓名:{{$admin['admin_realname']}}</p>
    <p class="text-muted">用户职位:{{$admin['admin_position']}}</p>
    <p class="text-muted">用户邮箱:{{$admin['admin_email']}}</p>
    <p class="text-muted">当前Ticket:{{$admin['admin_ticket']}}</p>
    <hr>
    <strong><i class="fa  fa-expeditedssl margin-r-5"></i> 密码修改</strong>
    <br/><br/>
    <p class="text-muted">注销登录后，在登录页面进行修改。。。</p>
    <hr>
    <strong><i class="fa fa-linux margin-r-5"></i> 运行环境</strong>
    <br/><br/>
    <p>
    <span class="label label-danger">{{$data['init']['os']}}</span>
    <span class="label label-success">PHP</span>
    <span class="label label-info">Mysql</span>
    <span class="label label-warning">{{$data['init']['software']}}</span>
    </p>
    <hr>
    <strong><i class="fa fa-file-text-o margin-r-5"></i> 说明</strong>
    <p>无。。。</p>
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
