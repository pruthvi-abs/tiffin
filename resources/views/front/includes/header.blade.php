<header id="header" class="light">
<div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Logo -->
                    <div class="module module-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{asset('public/websitelogo')}}/{{ $theme_data->tenant_image }}" alt="" width="250">
                        </a>
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- Navigation -->
                    <nav class="module module-navigation left mr-4">
                        <ul id="nav-main" class="nav nav-main">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/about') }}">About</a></li>
                            <?php
                            /*
                            <li><a href="{{ url('/tiffin') }}">Tiffin</a></li>
                            */
                            ?>
                            <li><a href="{{ url('/letseat') }}">Let's Eat</a></li>
                            <li><a href="{{ url('/catering') }}">Catering</a></li>
                            <?php
                            /*
                            <li class="has-dropdown">
                                <a href="#">About</a>
                                <div class="dropdown-container">
                                    <ul class="dropdown-mega">
                                        <li><a href="page-about.html">About Us</a></li>
                                        <li><a href="page-services.html">Services</a></li>
                                        <li><a href="page-gallery.html">Gallery</a></li>
                                        <li><a href="page-reviews.html">Reviews</a></li>
                                        <li><a href="page-faq.html">FAQ</a></li>
                                    </ul>
                                    <div class="dropdown-image">
                                        <img src="assets\img\photos\dropdown-about.jpg" alt="">
                                    </div>
                                </div>
                            </li>
                            */
                            ?>
                            <li><a href="{{ url('/contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-4">
                  <div class="headercart">
                    <a href="{{url('/viewcart')}}" class="module module-cart">
                      <?php
                        //if(Auth::check()){
                          //$user_email = Auth::user()->email;
                          $session_id = Session::get('session_id');
                          //$cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" and user_email="'.$user_email.'" order by id desc' );
                          $cart_datas=DB::select('select * from carts where deleted_at is null and session_id="'.$session_id.'" order by id desc' );
                          $tot_price=0;
                          $tot_product=0;
                          foreach ($cart_datas as $cart_data){
                              $tot_price+=$cart_data->price*$cart_data->quantity;
                              $tot_product++;
                          }
                      ?>
                      <?php if($tot_product <= 0){ ?>
                        <span class="cart-icon">
                            <i class="gray fa fa-shopping-cart"></i> Cart
                        </span>
                        <span class="ajaxcounter"></span>
                      <?php }elseif($tot_product == 1){ ?>
                        <span class="cart-icon">
                            <i class="fa fa-shopping-cart"></i> Cart
                        </span>
                        <span class="notification"><span class="ajaxcounter">{{$tot_product}}</span> Item</span>
                      <?php }else{ ?>
                        <span class="cart-icon">
                            <i class="fa fa-shopping-cart"></i> Cart
                        </span>
                        <span class="notification"><span class="ajaxcounter">{{$tot_product}}</span> Items</span>
                      <?php } ?>
                    </a>
                    <?php if($tot_product >= 1){ ?>
                    <a class="btn btn-outline-secondary btn-sm mt-1 check_out" href="{{ url('/order-review') }}"><span>Check Out</span></a>
                  <?php } ?>
                  </div>
                </div>
            </div>
        </div>
</header>
<!-- Header -->
<header id="header-mobile" class="light">
    <div class="module module-nav-toggle">
        <a href="#" id="nav-toggle" data-toggle="panel-mobile"><span></span><span></span><span></span><span></span></a>
    </div>
    <div class="module module-logo">
        <a href="{{ url('/') }}">
            <img src="{{asset('public/websitelogo')}}/{{ $theme_data->tenant_image }}" alt="">
        </a>
    </div>
    <div class="headercart module module-cart">

    <a href="{{url('/viewcart')}}" class="">
      
      <?php if($tot_product <= 0){ ?>
        <span class="cart-icon">
            <i class="gray fa fa-shopping-cart"></i> Cart
        </span>
        <span class="ajaxcounter"></span>
      <?php }elseif($tot_product == 1){ ?>
        <span class="cart-icon">
            <i class="fa fa-shopping-cart"></i> Cart
        </span>
        <span class="notification"><span class="ajaxcounter">{{$tot_product}}</span> Item</span>
      <?php }elseif($tot_product>=1){ ?>
        <span class="cart-icon">
              <i class="fa fa-shopping-cart"></i> Cart
        </span>
        <span class="notification"><span class="ajaxcounter">{{$tot_product}}</span> Items</span>
        <?php } ?>
    </a>
    <!--
    <?php //if($tot_product >= 1){ ?>
      <a class="btn btn-outline-secondary btn-sm mt-1 check_out" href="{{ url('/order-review') }}"><span>Check Out</span></a>
    <?php //} ?>
    </div>
    -->
</header>
<!-- Header / End -->
