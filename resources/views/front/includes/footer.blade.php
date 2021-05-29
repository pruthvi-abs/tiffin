<!-- Section -->
<?php
/*
<section class="section section-lg dark bg-dark">
    <div class="bg-image bg-parallax"><img src="assets\img\photos\bg-croissant.jpg" alt=""></div>
    <div class="container text-center">
        <div class="col-lg-8 push-lg-2">
            <h2 class="mb-3">Check our promo video!</h2>
            <h5 class="text-muted">Book a table even right now or make an online order!</h5>
            <button class="btn-play" data-toggle="video-modal" data-target="#modalVideo" data-video="https://www.youtube.com/embed/uVju5--RqtY"></button>
        </div>
    </div>
</section>
*/
?>

    <div class="container">
        <!-- Footer 1st Row -->
        <?php
        /*
        <div class="footer-first-row row">
            <div class="col-lg-6 col-md-6">
                <a href="{{ url('/') }}"><img src="{{asset('public/websitelogo')}}/{{ $theme_data->tenant_image }}" alt="" width="250" class=""></a>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
            <div class="col-lg-6 col-md-6">
                <h5 class="text-muted mb-3">Social Media</h5>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
        */
        ?>
        <!-- Footer 2nd Row -->
        <div class="footer-second-row row">
          <div class="col-lg-6 col-md-6">
          <div class="pull-left">
            <span class="">Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ $theme_data->tenant_title }}</a>. All rights reserved.</span>
          </div>
          </div>
          <div class="col-lg-6 col-md-6">
          <div class="pull-right">
            <a href="{{ url('/termscondition') }}">Terms & Policy</a> | <a href="{{ url('/disclaimer') }}">Disclaimer  &nbsp;</a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
            <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
          </div>
          </div>
        </div>
    </div>

    <!-- Back To Top -->
    <a href="#" id="back-to-top"><i class="ti ti-angle-up"></i></a>
