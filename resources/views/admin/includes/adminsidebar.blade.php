
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
          <li class="@if($webpage=='Dashboard') {{ 'active' }} @endif" ><a href="{!! url('dashboard') !!}" > Dashboard</a></li>
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
          <li><a> Catalog Management <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="@if($webpage=='Main Categories') {{ 'active' }} @endif"><a href="{{route('maincategory.index')}}"> Main Categories</a></li>
              <li class="@if($webpage=='Product Categories') {{ 'active' }} @endif"><a href="{{route('category.index')}}"> Product Categories</a></li>
              <li class="@if($webpage=='Tiffin Product') {{ 'active' }} @endif"><a href="{{route('tiffinproduct.index')}}"> Tiffin - Products</a></li>
              <li class="@if($webpage=='Menu Product') {{ 'active' }} @endif"><a href="{{route('product.index')}}"> Menu - Products</a></li>
              <li class="@if($webpage=='Catering Product') {{ 'active' }} @endif"><a href="{{route('cateringproduct.index')}}"> Catering - Products</a></li>
            </ul>
          </li>
          <li><a> Settings <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <?php
              /*
              <li class="@if($webpage=='Country') {{ 'active' }} @endif"><a href="{{route('country.index')}}"> Country</a></li>
              */
              ?>
              <li class="@if($webpage=='Roles') {{ 'active' }} @endif"><a href="{{route('roles.index')}}"> Roles</a></li>
              <li class="@if($webpage=='UsersManagement') {{ 'active' }} @endif"><a href="{{route('users.index')}}">System Users</a></li>
              <li class="@if($webpage=='FrontUsersManagement') {{ 'active' }} @endif"><a href="{{route('frontusers.index')}}">Frontend Users</a></li>
              <li class="@if($webpage=='Theme Setting') {{ 'active' }} @endif"><a href="{!! url('showconfig') !!}"> Theme Settings</a></li>
              <li class="@if($webpage=='SliderManagement') {{ 'active' }} @endif"><a href="{{route('frontslider.index')}}"> Slider Management</a></li>
              <li class="@if($webpage=='Audit') {{ 'active' }} @endif"><a href="{!! url('audit') !!}"> Audit</a></li>
            </ul>
          </li>
          <li class="@if($webpage=='Yearly Dashboard') {{ 'active' }} @endif">
          {!! Form::open(['route'=>'yearlydashboard','method'=>'POST','role'=>'form','id'=>'formsubmit']) !!}
            <input type="hidden" name="year" value="<?php echo date('Y'); ?>"/>
            <a href="#" onclick="$(this).closest('form').submit()" >Yearly Dashboard</a>
          {!! Form::close() !!}
          </li>
          <?php /*
          <li><a> Coupan Management<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="@if($webpage=='Coupan') {{ 'active' }} @endif"><a href="{{route('coupon.index')}}"> Coupan</a></li>
            </ul>
          </li>
          */
          ?>

        </ul>
      </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
      <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" href="{!! url('showconfig') !!}" title="Configuration">
          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
      </div>
      <!-- /menu footer buttons -->
    </div>
  </div>

<?php /*
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="@if($webpage=='Dashboard') {{ 'active' }} @endif "><a href="{!! url('dashboard') !!}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="treeview @if(in_array($webpage,['Roles','UsersManagement','Financialyears'])) {{ 'active' }} @endif " ></a>
        <a href="#">
        <i class="fa fa-circle-o"></i>
        <span>Main Menu</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="@if($webpage=='UsersManagement') {{ 'active' }} @endif"><a href="{{route('users.index')}}"><i class="fa fa-user"></i>Users</a></li>
        <li class="@if($webpage=='Roles') {{ 'active' }} @endif"><a href="{{route('roles.index')}}"><i class="fa fa-circle-o"></i>Role</a></li>
        <li class="@if($webpage=='Financialyears') {{ 'active' }} @endif"><a href="{{route('financialyears.index')}}"><i class="fa fa-circle-o"></i>Financial Years</a></li>
      </ul>
    </li>
    <li class="@if($webpage=='Corporatepolicy') {{ 'active' }} @endif "><a href="{{route('corporatepolicies.index')}}"><i class="fa fa-list"></i>Corporate Policy</a></li>
    <li class="treeview @if(in_array($webpage,['Promoter','Publicshareholder'])) {{ 'active' }} @endif " ></a>
        <a href="#">
        <i class="fa fa-circle-o"></i>
        <span>Share Holding Pattern </span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="@if($webpage=='Promoter') {{ 'active' }} @endif"><a href="{{route('promoters.index')}}"><i class="fa fa-users"></i>Promoters</a></li>
        <li class="@if($webpage=='Publicshareholder') {{ 'active' }} @endif"><a href="{{route('publicshareholders')}}"><i class="fa fa-users"></i>Publicshareholder</a></li>
      </ul>
    </li>
    <li class="@if($webpage=='FiveStarHotels') {{ 'active' }} @endif "><a href="{{route('fivestarhotels.index')}}"><i class="fa fa-picture-o"></i>Heritage and<br> 5-star Hotels</a></li>
    <li class="@if($webpage=='FourStarHotels') {{ 'active' }} @endif "><a href="{{route('fourstarhotels.index')}}"><i class="fa fa-picture-o"></i>4-star Hotels and<br> Amusement Parks</a></li>

    <li class="@if($webpage=='GetInTouch') {{ 'active' }} @endif "><a href="{{route('getintouch.index')}}"><i class="fa fa-list"></i>Get In Touch</a></li>
    <li class="treeview @if(in_array($webpage,['Careers','Careeropening'])) {{ 'active' }} @endif " ></a>
        <a href="#">
        <i class="fa fa-address-card" aria-hidden="true"></i>
        <span>Careers</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="@if($webpage=='Careers') {{ 'active' }} @endif"><a href="{{route('career.index')}}"><i class="fa fa-list"></i>List</a></li>
        <li class="@if($webpage=='Careeropening') {{ 'active' }} @endif"><a href="{{route('careeropening.index')}}"><i class="fa fa-address-card" aria-hidden="true"></i>Openings</a></li>
      </ul>
    </li>
    <li class="treeview @if(in_array($webpage,['Investor','Investorcategory','Otherinvestor'])) {{ 'active' }} @endif " ></a>
        <a href="#">
        <i class="fa fa-area-chart" aria-hidden="true"></i>
        <span>Investor</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="@if($webpage=='Investorcategory') {{ 'active' }} @endif"><a href="{{route('investorcategory.index')}}"><i class="fa fa-circle-o"></i>Category</a></li>
        <li class="@if($webpage=='Investor') {{ 'active' }} @endif"><a href="{{route('manageinvestor.index')}}"><i class="fa fa-list"></i>Investor PDF List</a></li>
        <li class="@if($webpage=='Otherinvestor') {{ 'active' }} @endif "><a href="{{route('otherinvestor.index')}}"><i class="fa fa-list"></i>Other Investor PDF List</a></li>
      </ul>
    </li>
    <li class="treeview @if(in_array($webpage,['Event','Eventcategory'])) {{ 'active' }} @endif " ></a>
        <a href="#">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        <span>Events and Update</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="@if($webpage=='Eventcategory') {{ 'active' }} @endif"><a href="{{route('eventcategory.index')}}"><i class="fa fa-circle-o"></i>Category</a></li>
        <li class="@if($webpage=='Event') {{ 'active' }} @endif"><a href="{{route('event.index')}}"><i class="fa fa-list"></i>Events List</a></li>
      </ul>
    </li>
    <li class="treeview @if(in_array($webpage,['Blog','Blogcategory'])) {{ 'active' }} @endif " ></a>
        <a href="#">
        <i class="fa fa-rss" aria-hidden="true"></i>
        <span>Blogs</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="@if($webpage=='Blogcategory') {{ 'active' }} @endif"><a href="{{route('blogcategory.index')}}"><i class="fa fa-circle-o"></i>Category</a></li>
        <li class="@if($webpage=='Blog') {{ 'active' }} @endif"><a href="{{route('manageblogs.index')}}"><i class="fa fa-list"></i>Blog List</a></li>
      </ul>
    </li>
   </ul>
</section>

*/
?>
<!-- /.sidebar -->
