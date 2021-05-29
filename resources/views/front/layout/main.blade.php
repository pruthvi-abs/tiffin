<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="">
@php
  $theme_data = App\ThemeSetting::select('tenant_image','tenant_title','tenant_favicon','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<!-- Favicons -->

<link rel="icon" href="{{asset('public/websitelogo')}}/{{ $theme_data->tenant_favicon }}" sizes="32x32">
<title>{{ $theme_data->tenant_title }}</title>
<!-- Bootstrap core CSS -->

<!-- CSS Plugins -->
<link rel="stylesheet" href="{{asset('public/frontend/assets/plugins/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('public/frontend/assets/plugins/slick-carousel/slick/slick.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('public/frontend/assets/plugins/animate.css/animate.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('public/frontend/assets/plugins/animsition/dist/css/animsition.min.css')}}" rel="stylesheet">
<!-- CSS Icons -->
<link rel="stylesheet" href="{{asset('public/frontend/assets/css/themify-icons.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('public/frontend/assets/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

<!-- -->
<!-- bootstrap-daterangepicker -->
<link href="{{asset('public/admin/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
<!-- bootstrap-datetimepicker -->
<link href="{{asset('public/admin/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
<link href="{{asset('public/admin/build/css/sweetalert.css')}}" rel="stylesheet">
<link href="{{asset('public/admin/build/css/datepicker3.css')}}" rel="stylesheet">
<link href="{{asset('public/admin/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
<!-- -->

<!-- CSS Theme -->
<link rel="stylesheet" href="{{asset('public/frontend/assets/css/themes/theme-beige.min.css')}}" rel="stylesheet">


<!--<script src="{{asset('public/frontend/assets/plugins/jquery/dist/jquery.min.js')}}"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

</head>
<body>
<header>
<!-- Body Wrapper -->
<div id="body-wrapper" class="animsition">
    <!-- Header -->
    @include('front.includes.topheader')
    @include('front.includes.header')
    <!-- Content -->
    <div id="content">
      @yield('content')
    </div>
    <footer id="footer" class="bg-dark dark">
      @include('front.includes.footer')
    </footer>
    <!-- Footer / End -->
@include('front.includes.popup')
</div>
@include('front.includes.mobilepopup')
<!-- JS Plugins -->
<script src="{{asset('public/frontend/assets/plugins/tether/dist/js/tether.min.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>


<script src="{{asset('public/frontend/assets/plugins/slick-carousel/slick/slick.min.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/jquery.appear/jquery.appear.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/jquery.scrollto/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/jquery.localscroll/jquery.localScroll.min.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/twitter-fetcher/js/twitterFetcher_min.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/skrollr/dist/skrollr.min.js')}}"></script>
<script src="{{asset('public/frontend/assets/plugins/animsition\dist/js/animsition.min.js')}}"></script>
<!-- JS Core -->
<script src="{{asset('public/admin/build/js/jquery.inputmask.js')}}"></script>
<script src="{{asset('public/admin/build/js/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('public/admin/build/js/jquery.inputmask.extensions.js')}}"></script>

<script src="{{asset('public/admin/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<!-- bootstrap-datetimepicker -->
<script src="{{asset('public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('public/frontend/assets/js/core.js')}}"></script>


<!---  ---->

<script src="{{asset('public/admin/build/js/custom.min.js')}}"></script>


<script>

$('.product-carousel').slick({
		lazyLoad: 'ondemand',
		slidesToShow: 4,
		slidesToScroll: 1,
    speed: 2000,
    autoplay: true,
    autoplaySpeed: 4000,
		//nextArrow: '<i class="arrow right">',
		//prevArrow: '<i class="arrow left">',
    arrows: true,
    dots: true,
    //nextArrow: "Next",
		//prevArrow: "Prev",
		infinite: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
});

$(function () {

  var timeZoneOffset = -6*60 //Set specific timezone according to our need. i.e. GMT+5
  var current = new Date();

  $('.datepicker1').datetimepicker({
      format: 'MM/DD/YYYY',
      minDate:new Date(current.getTime() - 86400000)
   });
   $('.timepicker1').datetimepicker({
     format: 'HH:mm:ss',
    });

   $('.todaydatepicker1').datetimepicker({
       format: 'MM/DD/YYYY',
       minDate:new Date(current.getTime() - 86400000)
    });

    $('.todaytimepicker1').datetimepicker({
      format: 'HH:mm:ss',
      minDate:0,
     });

    $('.tomorrowdatepicker1').datetimepicker({
        format: 'MM/DD/YYYY',
        minDate:new Date(current.getTime())
     });
     $('.tomorrowtimepicker1').datetimepicker({
       format: 'HH:mm:ss',
      });

      var cateringdate = $(".catd").val();
      var cattime = cateringdate*86400000;
      $('.cateringdatepicker1').datetimepicker({
          format: 'MM/DD/YYYY',
          minDate:new Date(current.getTime() + cattime)
       });

});
</script>
</body>
</html>
