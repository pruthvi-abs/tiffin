<?php
/*
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="#" class="site_title">
          @php
  					$theme_data = App\ThemeSetting::select('tenant_image','tenant_title')->where('deleted_at',null)->where('id',1)->first();
  				@endphp
          <span>{{ $theme_data->tenant_title }}</span>
      </a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        @if(Auth::user()->photo!="")
          <img src="{{ url('/') }}/public/userimages/{{Auth::user()->photo->file}}" class="img-circle profile_img">
        @else
          <img src="{{asset('public/admin/user.jpg')}}" class="img-circle profile_img">
        @endif
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <span class="hidden-xs">{{ Auth::user()->name }}</span>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">
          <li class="@if($webpage=='Dashboard') {{ 'active' }} @endif" ><a href="{!! url('counterdashboard') !!}" ><i class="fa fa-home"></i> Dashboard</a></li>
        </ul>
      </div>

    </div>
    <!-- /sidebar menu -->

    </div>
  </div>

<!-- /.sidebar -->
*/
?>
