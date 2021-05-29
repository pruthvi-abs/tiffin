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

<section id="cart_items">
<div class="container">
@if(Session::has('message'))
<div class="alert alert-success text-center mt-5" role="alert">
{{Session::get('message')}}
</div>
@endif

<?php
if(count($cart_datas)==0){
?>
<div class="col-xl-12 col-lg-12">
  <div class="mt-5 mb-4">
    <p>You have no items in your shopping cart.</p>
  </div>
</div>
<?php
}else{
  $catering_product=0;
  $catering_qty=0;
?>
@foreach($cart_datas as $cart_data)
<?php
$check_product_catid = DB::select('select main_categories_id from products where deleted_at is null and is_visible="yes" and id='.$cart_data->products_id.' order by id desc');
if($check_product_catid[0]->main_categories_id==2){
  $catering_product++;
  $catering_qty=$cart_data->quantity;
}
?>
@endforeach
<div class="col-sm-12 col-xl-12 col-lg-12">
<?php
  if($catering_product>0){
?>
      @if(Session::has('message_catering_qty_succ'))
          <div class="alert alert-success text-center" role="alert">
              {{Session::get('message_catering_qty_succ')}}
          </div>
      @endif
      @if(Session::has('message_catering_qty_error'))
          <div class="alert alert-danger text-center" role="alert">
              {{Session::get('message_catering_qty_error')}}
          </div>
      @endif
      <div class="chose_area" style="padding: 20px;margin-top:20px;">
          <form action="{{url('/apply-cateringqty')}}" method="post" role="form">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="form-group">
                  <h5 style="margin-bottom:10px;">Please Enter Number of Person for Catering Product</h5>
                  <div class="row">
                  <div class="col-sm-8 col-xl-8 col-lg-8">
                  <div class="controls {{$errors->has('cateringqty')?'has-error':''}}">
                      <input type="number" min="10" class="form-control" name="cateringqty" value="{{$catering_qty}}" id="cateringqty" placeholder="Please Enter Number of Person">
                      <span class="text-danger">{{$errors->first('cateringqty')}}</span>
                  </div>
                  </div>
                  <div class="col-sm-4 col-xl-4 col-lg-4">
                  <button type="submit" class="btn btn-outline-secondary btn-sm mt-1"><span>Submit</span></button>
                  </div>
                </div>
              </div>
          </form>
      </div>
<?php
  }
?>
</div>

<div class="col-xl-12 col-lg-12">
  <div class="shadow bg-white mt-5 mb-4">
      <div class="bg-dark dark p-4"><h5 class="mb-0">You order</h5></div>
      <div class="table-responsive cart_info">
      <table class="table-cart">
        <thead>
        <tr class="cart_menu">
            <td class="image">Item</td>
            <td class="description"></td>
            <td class="price">Price</td>
            <td class="quantity">Quantity</td>
            <td class="total">Total</td>
            <td></td>
        </tr>
        </thead>
          <tbody>
            <tbody>
                @foreach($cart_datas as $cart_data)
                    <?php
                        $image_products=DB::table('products')->select('image','small_image')->where('id',$cart_data->products_id)->get();
                    ?>
                    <tr>
                        <td class="cart_product">
                            @foreach($image_products as $image_product)
                                <a href=""><img src="{{asset('')}}/{{$image_product->small_image}}" alt="" style="width: 100px;"></a>
                            @endforeach
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$cart_data->product_name}}</a></h4>
                            <p>({{$cart_data->product_code}})</p>
                        </td>
                        <td class="cart_price">
                            <p>${{$cart_data->price}}</p>
                        </td>
                        <td class="cart_quantity">
                          <?php
                              $check_product_catid = DB::select('select main_categories_id from products where deleted_at is null and is_visible="yes" and id='.$cart_data->products_id.' order by id desc');
                              if($check_product_catid[0]->main_categories_id==2){
                                $catering_product++;
                                $catering_qty=$cart_data->quantity;
                          ?>
                            <div class="cart_quantity_button">
                              <input class="cart_quantity_input" type="text" name="quantity" value="{{$cart_data->quantity}}" autocomplete="off" size="2" disabled>
                            </div>
                          <?php
                            }else{
                          ?>
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" data-id="{{$cart_data->id}}" href="#"> + </a>
                                <input class="cart_qty_input {{$cart_data->id}}" type="text" name="quantity" value="{{$cart_data->quantity}}" autocomplete="off" size="2">
                                @if($cart_data->quantity>1)
                                    <a class="cart_quantity_down" data-id="{{$cart_data->id}}" href="#"> - </a>
                                @endif
                            </div>
                          <?php
                            }
                          ?>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price {{$cart_data->id}}">{{ $theme_data->currency }}{{$cart_data->price*$cart_data->quantity}}</p>
                        </td>
                        <td class="cart_delete">
                          <a class="cart_quantity_delete action-icon" href="{{url('/cart/deleteItem',$cart_data->id)}}"><i class="ti ti-close"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
      </table>
      </div>

  </div>
</div>
</div>

<div class="container mt-5">
  <div class="row">

 <?php
  /*
  <div class="col-sm-6 col-xl-6 col-lg-6">
      @if(Session::has('message_coupon'))
          <div class="alert alert-danger text-center" role="alert">
              {{Session::get('message_coupon')}}
          </div>
      @endif
      <div class="chose_area" style="padding: 20px;">
          <form action="{{url('/apply-coupon')}}" method="post" role="form">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <input type="hidden" name="Total_amountPrice" value="{{$total_price}}">
              <div class="form-group">
                  <h4>Coupon Code</h4>
                  <div class="controls {{$errors->has('coupon_code')?'has-error':''}}">
                      <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Coupon Code">
                      <span class="text-danger">{{$errors->first('coupon_code')}}</span>
                  </div>
                  <button type="submit" class="btn btn-outline-secondary btn-sm mt-1"><span>Apply</span></button>
              </div>
          </form>
      </div>
  </div>
  */
  ?>
  <div class="col-sm-12 col-xl-12 col-lg-12">
      <div class="total_area mb-5">
        @if(Session::has('message_apply_sucess'))
            <div class="alert alert-success text-center" role="alert">
                {{Session::get('message_apply_sucess')}}
            </div>
        @endif

              @if(Session::has('discount_amount_price'))
              <div class="cart-summary">
                  <div class="row">
                      <div class="col-7 text-left text-muted">Order total:</div>
                      <div class="col-5"><strong>{{ $theme_data->currency }}{{$total_price}}</strong></div>
                  </div>
                  <div class="row">
                      <div class="col-7 text-left text-muted">Coupon Discount: (Code : {{Session::get('coupon_code')}})</div>
                      <div class="col-5"><strong>{{ $theme_data->currency }}{{Session::get('discount_amount_price')}}</strong></div>
                  </div>
                  <hr class="hr-sm">
                  <div class="row text-md">
                      <div class="col-7 text-left text-muted">Total:</div>
                      <div class="col-5"><strong>{{ $theme_data->currency }}{{$total_price-Session::get('discount_amount_price')}}</strong></div>
                  </div>
              </div>
              @else
              <div class="cart-summary">
                  <div class="row text-md">
                      <div class="col-8 text-left text-muted"><h4>Total:</h4></div>
                      <div class="col-4">
                        <strong class="cartTotal pull-right">{{ $theme_data->currency }}{{$total_price}}</strong>
                      </div>
                  </div>
              </div>
              @endif
            <?php
            /*
          <div style="margin-left: 20px;"><a class="btn btn-outline-secondary btn-sm mt-1 check_out" href="{{url('/check-out')}}"><span>Check Out</span></a></div>
            */
            ?>
            <div style="margin-left: 0px; margin-top:0px; padding-bottom:40px;"><a class="btn btn-outline-secondary btn-sm mt-1 check_out pull-right" href="{{url('/order-review')}}"><span>Check Out</span></a></div>

      </div>
  </div>
  </div>
</div>
<?php } ?>
</section>

<script type="text/javascript">
$(document).on('click','.cart_quantity_up', function () {
  event.preventDefault();
  var cart_id = $(this).attr('data-id');

  $.ajax({
    url: '{!! url('/cart/update-quantityajax/') !!}'+'/'+cart_id+'/1',
    type:"GET",
    dataType: 'json',
    data:{
      "_token": "{{ csrf_token() }}",
    },
    success:function(response){
      $('.cart_qty_input.'+response.cart_id).attr('value',response.updated_quantity);
      $('.cart_total_price.'+response.cart_id).html(response.updated_id_total);
      $('.cartTotal').html(response.updated_total);

    },
 });
});

$(document).on('click','.cart_quantity_down', function () {
  event.preventDefault();
  var cart_id = $(this).attr('data-id');

  $.ajax({
    url: '{!! url('/cart/update-quantityajax/') !!}'+'/'+cart_id+'/-1',
    type:"GET",
    dataType: 'json',
    data:{
      "_token": "{{ csrf_token() }}",
    },
    success:function(response){
      $('.cart_qty_input.'+response.cart_id).attr('value',response.updated_quantity);
      $('.cart_total_price.'+response.cart_id).html(response.updated_id_total);
      $('.cartTotal').html(response.updated_total);
    },
  });
});

/*
$(document).on('click','.cart_quantity_delete', function () {
  //event.preventDefault();
  var cart_id = $(this).attr("data-id");
  $.ajax({
    url: '{!! url('/cart/deleteItemajax') !!}'+'/'+cart_id,
    type:"GET",
    dataType: 'json',
    data:{
      "_token": "{{ csrf_token() }}",
    },
    success:function(response){
      //$('div.'+response.products_id+'ajaxresponse').attr('style','display:block');
      //$('div.'+response.products_id+'ajaxresponse span').text(response.success);
      $('span.ajaxcounter').text(response.totalcart);
      $('.stcatmenu').html(response.cat_data);
      //console.log(response);
    },
   });
});
*/
</script>
@endsection
