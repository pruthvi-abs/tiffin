@extends('front.layout.main')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','tenant_title','tenant_favicon','currency','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-6">
                <h4 class="mb-0 pull-left">{{ $pagetitle }}</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / {{ $pagetitle }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="page-content">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         @if(Session::has('message'))
             <div class="alert alert-success text-center" role="alert">
                 {{Session::get('message')}}
             </div>
         @endif
       </div>
     </div>
       <div class="row no-gutters">
            <div class="col-md-3">
               <!-- Menu Navigation -->
               <nav id="menu-navigation" class="stick-to-content" data-local-scroll="">
                   <ul class="nav nav-menu bg-dark dark">
                     @foreach ($categories as $category)
                       <li><a href="#<?php echo str_replace(' ', '', $category->name); ?>">{{ $category->name }}</a></li>
                      @endforeach
                   </ul>
               </nav>
           </div>
           <div class="col-md-9">
                <!--START Menu Category / Burgers -->
               @foreach ($categories as $category)
               <div id="<?php echo str_replace(' ', '', $category->name); ?>" class="menu-category">
                   <div class="menu-category-title">
                       <h2 class="title">{{ $category->name }}</h2>
                   </div>
                   <div class="menu-category-content padded">
                       <div class="row gutters-sm">
                         @php
												    DB::enableQueryLog();
												    $cat_id = $category->id;
                            $product_data = DB::select('select * from products where deleted_at is null and is_visible="yes" and categories_id='.$cat_id.' order by p_name');
                            $product_count = count($product_data);
											   @endphp
                         @for($f=0;$f<$product_count;$f++)
                         <!--START Product -->
                         <div class="col-lg-4 col-6">
                         <!--<form id="addToCart" action="{{route('addToCart')}}" method="post" role="form">-->
                         <form id="addToCart" class="addToCart" action="#" method="post" role="form">
                         <input type="hidden" class="_token" name="_token" value="{{csrf_token()}}">
                         <input type="hidden" class="products_id" name="products_id" value="{{$product_data[$f]->id}}">
                         <input type="hidden" class="product_name" name="product_name" value="{{$product_data[$f]->p_name}}">
                         <input type="hidden" class="product_code" name="product_code" value="{{$product_data[$f]->p_code}}">
                         <input type="hidden" class="price" name="price" value="{{$product_data[$f]->price}}">
                                <!-- Menu Item -->
                               <div class="menu-item menu-grid-item block{{$product_data[$f]->id}}">
                                   <img class="mb-4" src="{{asset('')}}/{{$product_data[$f]->small_image}}" alt="">
                                   <h6 class="mb-0">{{$product_data[$f]->p_name}}</h6>
                                   <span class="text-muted text-sm">{{$product_data[$f]->description}}</span>
                                   <div class="row align-items-center mt-4">
                                     <div class="col-sm-12">
                                       <span class="text-md mr-4">{{ $theme_data->currency }}{{ $product_data[$f]->price }}</span>
                                     </div>
                                   </div>
                                   <div class="row align-items-center mt-4">
                                       <div class="col-sm-6">
                                           <input type="number" name="quantity" min="1" max="100" value="1" class="form-control required quantity" required>
                                        </div>
                                       <div class="col-sm-6 text-sm-right mt-2 mt-sm-0">
                                         <button class="btn btn-outline-secondary btn-sm" data-target="#productModal" data-toggle="modal">
                                           <span>Add to cart</span>
                                         </button>
                                       </div>
                                   </div>
                                   <div class="{{$product_data[$f]->id}}ajaxresponse alert alert-success text-center mt-4" style="display:none;">
                                     <span></span>
                                   </div>
                               </div>
                           </form>
                           </div>
                           <!--END Product -->
                          @endfor
                       </div>
                   </div>
               </div>

               @endforeach
               <!--END Menu Category / Burgers -->
           </div>
       </div>
   </div>
</div>

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
      setTimeout(function () {
          $('div.'+response.products_id+'ajaxresponse').attr('style','display:none');
        }, 5000);
      //$(this).find('.quantity').val(1);
      //console.log(response);
    },
   });
  });
</script>


@endsection
