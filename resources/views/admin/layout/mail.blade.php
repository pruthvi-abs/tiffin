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
  <script src="{{asset('public/admin/build/js/jquery-2.2.3.min.js')}}"></script>
</head>
<body class="nav-md">
  @yield('content')

<script src="{{asset('public/admin/build/js/jquery.validate.min.js')}}"></script>
</body>
</Html>
