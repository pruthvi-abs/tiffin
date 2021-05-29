<!DOCTYPE Html>
<Html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @php
    $theme_data = App\ThemeSetting::select('tenant_image','tenant_title','tenant_favicon','currency')->where('deleted_at',null)->where('id',1)->first();
  @endphp
  <link rel="icon" href="{{asset('public/websitelogo')}}/{{ $theme_data->tenant_favicon }}" sizes="32x32">
  <title>{{ $theme_data->tenant_title }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="{{asset('public/admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.css" rel="stylesheet">

  <link href="{{asset('public/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
  <!-- bootstrap-daterangepicker -->
    <link href="{{asset('public/admin/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{asset('public/admin/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
<!--
  <link href="{{asset('public/admin/build/css/dataTables.bootstrap.css')}}" rel="stylesheet">
-->

<!--
  <link href="{{asset('public/admin/build/css/daterangepicker.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/build/css/datepicker3.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
-->

  <link href="{{asset('public/admin/build/css/sweetalert.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/build/dropify/dist/css/dropify.min.css')}}" rel="stylesheet">
  <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="{{asset('public/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
  <!-- Switchery -->
  <link href="{{asset('public/admin/vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet">

  <link href="{{asset('public/admin/build/css/datepicker3.css')}}" rel="stylesheet">
  <link href="{{asset('public/admin/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">

  <link href="{{asset('public/admin/build/css/custom.min.css')}}" rel="stylesheet">

  <script src="{{asset('public/admin/build/js/jquery-2.2.3.min.js')}}"></script>
  <!--
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="{{asset('public/admin/vendors/validator/multifield.js')}}"></script>
  <script src="{{asset('public/admin/vendors/validator/validator.js')}}"></script>
-->
</head>
@if(Auth::user()->role_id==4)

@else

@endif
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      @if(Auth::user()->role_id==1)
        @include('admin.includes.adminsidebar')
      @elseif(Auth::user()->role_id==2)
        @include('admin.includes.salessidebar')
      @elseif(Auth::user()->role_id==3)
        @include('admin.includes.kitchensidebar')
      @elseif(Auth::user()->role_id==4)
        @include('admin.includes.countersidebar')
      @else

      @endif

      @if(Auth::user()->role_id==4)
        @include('admin.includes.counterheader')
      @else
        @include('admin.includes.header')
      @endif

        <div class="right_col" role="main">
        <?php
        /*  <h1>{{$webpage}}</h1> */
        ?>
          @yield('content')
        </div>
      @include('admin.includes.footer')
    </div>
  </div>
<!--
  <script src="{{asset('public/admin/vendors/jquery/dist/jquery.min.js')}}"></script>
-->
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
<!-- bootstrap-datetimepicker -->
<script src="{{asset('public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>

<!--
<script src="{{asset('public/admin/build/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin/build/js/dataTables.bootstrap.min.js')}}"></script> -->
<script src="{{asset('public/admin/build/js/sweetalert.js')}}"></script>

<script src="{{asset('public/admin/build/js/jquery.inputmask.js')}}"></script>
<script src="{{asset('public/admin/build/js/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('public/admin/build/js/jquery.inputmask.extensions.js')}}"></script>

<!--
<script src="{{asset('public/admin/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('public/admin/build/js/daterangepicker.js')}}"></script>
<script src="{{asset('public/admin/build/js/bootstrap-datepicker.js')}}"></script>
-->
<!-- morris.js -->
<script src="{{asset('public/admin/vendors/raphael/raphael.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/morris.js/morris.min.js')}}"></script>

    <script src="{{asset('public/admin/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('public/admin/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/switchery/dist/switchery.min.js')}}"></script>
<script src="{{asset('public/admin/build/dropify/dist/js/dropify.min.js')}}"></script>
<script src="{{asset('public/admin/build/js/form-file-upload-data.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.js"></script>

<script src="{{asset('public/admin/build/js/custom.min.js')}}"></script>
<script src="{{asset('public/admin/build/js/scripts.js')}}"></script>

<script>
$(function () {
  $('.datepicker1').datetimepicker({
      format: 'MM/DD/YYYY'
   });
   $('.datepicker2').datetimepicker({
       format: 'MM/DD/YYYY'
    });
   $('.timepicker1').datetimepicker({
       format: 'HH:mm:ss'
   });
   $('.timepicker2').datetimepicker({
       format: 'HH:mm:ss'
   });
   $('.datetimepicker1').datetimepicker({
       format: 'MM/DD/YYYY HH:mm:ss'
    });
});
</script>
</body>
</Html>
