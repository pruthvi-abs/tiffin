<!DOCTYPE Html>
<Html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @php
      $theme_data = App\ThemeSetting::select('tenant_image','tenant_title','tenant_favicon')->where('deleted_at',null)->where('id',1)->first();
    @endphp
    <link rel="icon" href="{{asset('public/websitelogo')}}/{{ $theme_data->tenant_favicon }}" sizes="32x32">
    <title>{{ $theme_data->tenant_title }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{asset('public/admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/vendors/animate.css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/admin/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/build/css/custom.min.css')}}" rel="stylesheet">

    <!--
    <script src="{{asset('public/admin/vendors/jquery/dist/jquery.min.js')}}"></script>
    -->
    <script src="{{asset('public/admin/build/js/jquery-2.2.3.min.js')}}"></script>
    <!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{asset('public/admin/vendors/validator/multifield.js')}}"></script>
    <script src="{{asset('public/admin/vendors/validator/validator.js')}}"></script>
  -->
  </head>
<body class="login">
    <div class="login-box text-center">
      <div class="login-logo">
        <a href="{{ url('/') }}"><img src="{{asset('public/websitelogo')}}/{{ $theme_data->tenant_image }}" alt="{{ $theme_data->tenant_title }}" class="img-responsive"/></a>
      </div>
      @yield('content')
    </div>


    <script src="{{asset('public/admin/build/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/fastclick/lib/fastclick.js')}}"></script>
    <script src="{{asset('public/admin/vendors/nprogress/nprogress.js')}}"></script>
    <script src="{{asset('public/admin/vendors/Chart.js/dist/Chart.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/iCheck/icheck.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/skycons/skycons.js')}}"></script>
    <script src="{{asset('public/admin/vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('public/admin/vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('public/admin/vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('public/admin/vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('public/admin/vendors/Flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('public/admin/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('public/admin/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/flot.curvedlines/curvedLines.js')}}"></script>
    <script src="{{asset('public/admin/vendors/DateJS/build/date.js')}}"></script>
    <script src="{{asset('public/admin/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('public/admin/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('public/admin/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    <script src="{{asset('public/admin/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('public/admin/build/js/custom.min.js')}}"></script>
    <script src="{{asset('public/admin/build/js/scripts.js')}}"></script>

</body>
</Html>
