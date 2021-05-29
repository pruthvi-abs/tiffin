@extends('front.layout.main')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','tenant_title','tenant_favicon','currency','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
@if(Session::has('message'))
<div class="page-content">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
              <div class="alert alert-success text-center" role="alert">
                 {{Session::get('message')}}
             </div>
       </div>
     </div>
   </div>
</div>
@endif
<!-- Section - Main -->
<section class="section section-main section-main-2 bg-dark dark">
    <div id="section-main-2-slider" class="section-slider inner-controls">
        <!-- Slide -->
        <?php
         if(count($tiffinproducts) > 0){
        ?>
        @foreach ($tiffinproducts as $tiffinproduct)
        <div class="slide box custsilder">
            <div class="bg-image zooming"><img src="{{asset('')}}/{{ $frontslider[0]->image }}" alt=""></div>
              <form action="{{route('addToCart')}}" method="post" role="form">
              <div class="container v-center">
                <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <input type="hidden" name="products_id" value="{{$tiffinproduct->id}}">
                  <input type="hidden" name="product_name" value="{{$tiffinproduct->p_name}}">
                  <input type="hidden" name="product_code" value="{{$tiffinproduct->p_code}}">
                  <input type="hidden" name="price" value="{{$tiffinproduct->price}}">
                  <input type="hidden" name="quantity" value="1" class="form-control required" required>
                  <h2 class="display-4 mb-4">{{$tiffinproduct->p_name}}</h2>
                  <h4><?php echo Carbon\Carbon::parse($tiffinproduct->tiffin_preparation_date)->format("m/d/Y"); ?></h4>
                  <button class="btn btn-outline-primary btn-lg mt-2 mb-5" data-target="#productModal" data-toggle="modal">
                    <span>Add to Cart</span>
                  </button>
                </div>
                <div class="col-md-3">
                  <div class="custom-home-slider-box">
                  <div class="box pull-left ">
                    <span >
                      <?php echo htmlspecialchars_decode($tiffinproduct->description); ?>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-1"></div>
                </div>
              </div>
              </form>
        </div>
        @endforeach
        <?php
         }else{
        ?>
        @foreach ($frontslider as $slider)
        <div class="slide box custsilder">
            <div class="bg-image zooming"><img src="{{asset('')}}/{{ $frontslider[0]->image }}" alt=""></div>
              <div class="container v-center">
                <div class="row">
                <div class="col-md-12">
                  <h2 class="display-4 mb-4">{{ $slider->title }}</h2>
                  <?php echo htmlspecialchars_decode($slider->description); ?>
                  <div class="clearfix"></div>
                  <a class="btn btn-outline-primary btn-lg mt-2 mb-5" href="{{ $slider->btnlink }}"><span>{{ $slider->btntitle }}</span></a>
                </div>
                </div>
              </div>
        </div>
        @endforeach
        <?php
         }
        ?>
    </div>
</section>


<?php if($products != null){ ?>
<!-- Section - Offers -->
<section class="section bg-light">
   <div class="container">
       <h3 class="pb-5 pt-5 text-center">Special offers</h3>
       <div class="product-carousel home-tiffins mb-5 mt-3"> <!-- data-slick='{"dots": true}' -->
         <?php
            $total = count($products);
          ?>
            <?php
               for($j=0;$j<$total;$j++){
             ?>
             <form id="addToCart" class="addToCart" action="#" method="post" role="form">
             <input type="hidden" class="_token" name="_token" value="{{csrf_token()}}">
             <input type="hidden" class="products_id" name="products_id" value="{{$products[$j]->id}}">
             <input type="hidden" class="product_name" name="product_name" value="{{$products[$j]->p_name}}">
             <input type="hidden" class="product_code" name="product_code" value="{{$products[$j]->p_code}}">
             <input type="hidden" class="price" name="price" value="{{$products[$j]->price}}">
               <div class="product block{{$products[$j]->id}}">
                 <div class="product-box">
                 <div class="product-top">
                   <img src="{{asset('')}}{{$products[$j]->small_image}}" alt=""  class="product-image">
                 </div>
                 <div class="product-bottom">
                   <div class="product-name">
                     <h5>{{$products[$j]->p_name}}</h5>
                   </div>
                   <p class="product-prices">
                     <span class="price-was">{{ $theme_data->currency }}{{$products[$j]->price}}</span>
                   </p>
                   <div class="row align-items-center">
                       <div class="col-sm-5">
                           <input type="number" name="quantity" min="1" max="100" value="1" class="form-control required quantity" required>
                       </div>
                       <div class="col-sm-7">
                         <button class="btn btn-outline-secondary btn-sm" data-target="#productModal" data-toggle="modal">
                           <span>Add to cart</span>
                         </button>
                       </div>
                   </div>
                 </div>
                </div>
               </div>
               <div class="{{$products[$j]->id}}ajaxresponse alert alert-success text-center mt-4" style="display:none;">
                 <span></span>
               </div>
              </form>
             <?php
                 }
             ?>
            <?php
            ?>
       </div>
   </div>
</section>
<?php } ?>

<!-- Section - Steps -->
<section class="section section-extended dark bg-dark">
 <div class="container bg-dark">
     <div class="row">
         <div class="col-md-4">
             <!-- Step -->
             <div class="feature feature-1 mb-md-0">
                 <div class="feature-icon icon icon-primary"><i class="ti ti-shopping-cart"></i></div>
                 <div class="feature-content">
                     <h4 class="mb-2">Pick a dish</h4>
                     <p class="text-muted mb-0"></p>
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <!-- Step -->
             <div class="feature feature-1 mb-md-0">
                 <div class="feature-icon icon icon-primary"><i class="ti ti-wallet"></i></div>
                 <div class="feature-content">
                     <h4 class="mb-2">Make a payment</h4>
                     <p class="text-muted mb-0"></p>
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <!-- Step -->
             <div class="feature feature-1 mb-md-0">
                 <div class="feature-icon icon icon-primary"><i class="ti ti-package"></i></div>
                 <div class="feature-content">
                     <h4 class="mb-2">Recieve your food!</h4>
                     <p class="text-muted mb-3"></p>
                 </div>
             </div>
         </div>
     </div>
 </div>
</section>
<!-- Section - Menu -->
<section class="section pb-0 protrude">
   <div class="container">
       <h3 class="mb-5 mt-5 text-center">Category</h3>
   </div>
   <div class="menu-sample-carousel carousel inner-controls" data-slick='{
       "dots": true,
       "slidesToShow": 3,
       "slidesToScroll": 1,
       "infinite": true,
       "responsive": [
           {
               "breakpoint": 991,
               "settings": {
                   "slidesToShow": 2,
                   "slidesToScroll": 1
               }
           },
           {
               "breakpoint": 690,
               "settings": {
                   "slidesToShow": 1,
                   "slidesToScroll": 1
               }
           }
       ]
   }'>
       <!-- Menu Sample -->
       <div class="menu-sample">
           <a href="{{ url('/letseat') }}">
               <img src="{{asset('public/frontend')}}/category/category_menu.png" alt="" class="image">
               <h3 class="title">Let's Eat</h3>
           </a>
       </div>
       <div class="menu-sample">
           <a href="{{ url('/catering') }}">
               <img src="{{asset('public/frontend')}}/category/category_catering.png" alt="" class="image">
               <h3 class="title">Catering</h3>
           </a>
       </div>
       <div class="menu-sample">
           <a href="#">
               <img src="{{asset('public/frontend')}}/category/category_tiffin.png" alt="" class="image">
               <h3 class="title">Tiffin</h3>
           </a>
       </div>
   </div>
</section>

<script type="text/javascript">

$('.addToCart').on('submit',function(event){
  event.preventDefault();
  var token = $(this).find('._token').val();
  var products_id = $(this).find('.products_id').val();
  var product_name = $(this).find('.product_name').val();
  var product_code = $(this).find('.product_code').val();
  var price = $(this).find('.price').val();
  var quantity = $(this).find('.quantity').val();

  $.ajax({
    url: '{!! url('/addToCartajax') !!}',
    type:"POST",
    dataType: 'json',
    data:{
      //"_token": "{{ csrf_token() }}",
      "_token": token,
      products_id:products_id,
      product_name:product_name,
      product_code:product_code,
      price:price,
      quantity:quantity,
    },
    success:function(response){
      $('div.'+response.products_id+'ajaxresponse').attr('style','display:block');
      $('div.'+response.products_id+'ajaxresponse span').text(response.success);
      $('.block'+response.products_id+' .quantity').val(1);
      //$('.block'+response.products_id+' .quantity').attr('value',1);
      $('span.ajaxcounter').text(response.totalcart);
      //$(this).find('.quantity').val(1);
      console.log(response);
      setTimeout(function () {
          $('div.'+response.products_id+'ajaxresponse').attr('style','display:none');
        }, 5000);
    },
   });
  });
</script>
@endsection
