<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <nav class="nav navbar-nav">
      <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
          <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
            @if(Auth::user()->photo!="")
              <img src="{{ url('/') }}/public/userimages/{{Auth::user()->photo->file}}">
            @else
              <img src="{{asset('public/admin/user.jpg')}}">
            @endif
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"  href="{!! url('showuserprofile') !!}"> Profile</a>
            <a href="javascript:void(0)" id="changepassword" class="dropdown-item">Change Password</a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i>Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->
<?php
/*
<!-- Logo -->
<a href="{!! url('dashboard') !!}" class="logo">
  <span class="logo-mini">TFCI</span>
  <span class="logo-lg"><img src="{{asset('public/logo.png')}}" width="200px"></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
   <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="{!! url('showuserprofile') !!}">
                              @if(Auth::user()->photo!="")
                                <img src="{{ url('/') }}/public/userimages/{{Auth::user()->photo->file}}" class="user-image">
                              @else
                                <img src="{{asset('public/admintheme/img/placeholder.png')}}" class="user-image">
                              @endif
                              <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            </li>
                            <li>
                              <a href="javascript:void(0)" id="changepassword" class=""><i class="fa fa-edit"></i> <span class="hidden-xs">Change Password</span></a>
                            </li>
                            <li>
                              <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i><span class="hidden-xs">Logout</span></a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>

                            </li>
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    </ul>
                </div>
</nav>
*/
?>
