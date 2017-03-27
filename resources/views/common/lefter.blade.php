    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{$admin['admin_header']}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{$admin['admin_realname']}}-{{$admin['admin_roles']['0']['name']}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        @foreach($menu as $k=>$v)
         @if(isset($v['name']) && $v['name'])
         <li class="treeview">
           <a href="javascript:void(0);">
            <i class="fa {{$v['css']}}"></i> <span>{{$v['name']}}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @foreach($v['children'] as $kk=>$vv)
            <li><a href="{{route($vv['url'])}}"><i class="fa {{ $vv['css'] }}"></i>{{$vv['name']}}</a></li>
            @endforeach
          </ul>
         </li>
         @endif
        @endforeach
      </ul>
    </section>
    <!-- /.sidebar -->
