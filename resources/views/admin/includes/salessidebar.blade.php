
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
          <li class="@if($webpage=='Dashboard') {{ 'active' }} @endif" ><a href="{!! url('salesdashboard') !!}" ><i class="fa fa-home"></i> Dashboard</a></li>
          <li><a> Orders <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="@if($webpage=='Todays Orders') {{ 'active' }} @endif"><a href="{{route('todayorder')}}"> Todays </a></li>
              <li class="@if($webpage=='Tomorrow Orders') {{ 'active' }} @endif"><a href="{{route('tomorroworder')}}"> Tomorrows </a></li>
              <li class="@if($webpage=='Next 7 Days Orders') {{ 'active' }} @endif"><a href="{{route('nextweekorder')}}"> Next 7 Days </a></li>
              <li class="@if($webpage=='Next 30 Days Orders') {{ 'active' }} @endif"><a href="{{route('nextmonthorder')}}"> Next 30 Days </a></li>
              <li class="@if($webpage=='All Orders') {{ 'active' }} @endif"><a href="{{route('order.index')}}"> All </a></li>
            </ul>
          </li>
          <li class="@if($webpage=='Order Report') {{ 'active' }} @endif">
          {!! Form::open(['route'=>'report','method'=>'POST','role'=>'form','id'=>'formsubmit']) !!}
          <input type="hidden" name="report_date" value="today"/>
          <input type="hidden" name="startdate" value=""/>
          <input type="hidden" name="enddate" value=""/>
          <input type="hidden" name="payment_details" value="yes"/>
            <a href="#" onclick="$(this).closest('form').submit()" >Report</a>
          {!! Form::close() !!}
          </li>
          <?php
          /*
          <li><a> Order Management<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="@if($webpage=='Order') {{ 'active' }} @endif"><a href="{{route('order.index')}}"> Order</a></li>
            </ul>
          </li>
          */
          ?>
          <?php
          /*
          <li><a> Report Management<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="@if($webpage=='Order Report') {{ 'active' }} @endif">
              {!! Form::open(['route'=>'report','method'=>'POST','role'=>'form','id'=>'formsubmit']) !!}
              <input type="hidden" name="report_date" value="today"/>
              <input type="hidden" name="startdate" value=""/>
              <input type="hidden" name="enddate" value=""/>
                <a href="#" onclick="$(this).closest('form').submit()" >Order Report</a>
              {!! Form::close() !!}
              </li>
            </ul>
          </li>
          */
          ?>
        </ul>
      </div>

    </div>
    <!-- /sidebar menu -->

    </div>
  </div>

<!-- /.sidebar -->
