
    <!-- Logo -->
    <a href="javascript:void(0)" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><i class="fa fa-bar-chart-o text-green"></i></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>数据</b>平台</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="user user-menu">
            <a href="{{route('admin.admin.home')}}">
              <img src="{{$admin['admin_header']}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{$admin['admin_realname']}}-{{$admin['admin_roles']['0']['name']}}</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.login.logout')}}" class="text-red"><i class="fa fa-power-off margin-r-5"></i>注销登录</a>
          </li>
          <li>
            <a href="#">&nbsp;</a>
          </li>
        </ul>
      </div>
    </nav>
