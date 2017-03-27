<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>固生堂-数据平台</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('/js/plugin/bootstrap/css/bootstrap.min.css ') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/js/plugin/AdminLTE/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('/js/plugin/AdminLTE/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/js/plugin/AdminLTE/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('/js/plugin/AdminLTE/css/skins/_all-skins.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="{{ asset('/js/plugin/AdminLTE/js/html5shiv.min.js') }}"></script>
  <script src="{{ asset('/js/plugin/AdminLTE/js/respond.min.js') }}"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  @section('header')
   <header class="main-header">
  @include('common.header')
  </header>
  @show
  <!-- =============================================== -->
  <!-- Left side column. contains the sidebar -->
  @section('lefter')
  <aside class="main-sidebar">
  @include('common.lefter')
  </aside>
  @show
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
   @yield('content')  
  </div>
  <!-- /.content-wrapper -->
  @section('footer')
  <footer class="main-footer">
  @include('common.footer')
  </footer>
  @show
  <!-- =============================================== -->
  <!-- Control Sidebar -->
  @section('righter')
  <aside class="control-sidebar control-sidebar-dark">
  @include('common.righter')
  </aside>
  @show
  <!-- /.control-sidebar -->
  <!-- =============================================== -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg">
    
  </div>
</div>
<!-- ./wrapper -->
</body>
</html>