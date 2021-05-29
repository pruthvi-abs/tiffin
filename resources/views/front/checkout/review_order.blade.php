@extends('front.layout.main')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','catering_min_date','tenant_title','tenant_favicon','datetime_format','currency','order_cutoff_time','pickup_start_time','pickup_end_time','pickup_catering_start_time','pickup_catering_end_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h4 class="mb-0 pull-left">{{ $pagetitle }}</h4>
            </div>
            <div class="col-lg-6 col-md-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / {{ $pagetitle }}</p>
            </div>
        </div>
    </div>
</div>

<section id="cart_items">
<div class="mt-5 mb-5">
  <div class="container">
    @if(Session::has('message'))
      <div class="alert alert-success text-center" role="alert">
        {{Session::get('message')}}
      </div>
    @endif
    <div class="row">

    <div class="col-lg-12 col-md-12">
    <form action="{{url('/submit-order')}}" method="post" class="form-horizontal">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        @guest
          <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control" required="">
          </div>
          <div class="form-group">
              <label>Email</label>
              <input type="text" name="users_email" class="form-control" required="">
          </div>
          <div class="form-group">
              <label>Mobile</label>
              <input type="text" name="mobile" class="form-control required" id="mobile" maxlength="15" data-mask="true" data-inputmask='"mask": "(999) 999-9999"' required>
          </div>
          <div class="form-group">
            <span>
                <input type="checkbox" name="creataccount" class="checkbox" id="creataccount">
                Create an account?
            </span>
          </div>
          <div id="createacc" class="form-group" style="display:none;">
              <label>Password</label>
              <input id="createaccpass" type="password" name="password" class="form-control createaccpass">
          </div>
        @else
          <input type="hidden" name="users_id" value="{{$users_details->id}}">
          <input type="hidden" name="users_email" value="{{$users_details->email}}">
          <input type="hidden" name="name" value="{{$users_details->name}}">
          <input type="hidden" name="mobile" value="{{$users_details->mobile}}">
        @endguest

        <?php
        /*
        <input type="hidden" name="address" value="{{$shipping_address->address}}">
        <input type="hidden" name="city" value="{{$shipping_address->city}}">
        <input type="hidden" name="state" value="{{$shipping_address->state}}">
        <input type="hidden" name="pincode" value="{{$shipping_address->pincode}}">
        <input type="hidden" name="country" value="{{$shipping_address->country}}">
        <input type="hidden" name="shipping_charges" value="0">
        */
        ?>

        @if(Session::has('discount_amount_price'))
            <input type="hidden" name="coupon_code" value="{{Session::get('coupon_code')}}">
            <input type="hidden" name="coupon_amount" value="{{Session::get('discount_amount_price')}}">
            <input type="hidden" name="grand_total" value="{{$total_price-Session::get('discount_amount_price')}}">
        @else
            <input type="hidden" name="coupon_code" value="NO Coupon">
            <input type="hidden" name="coupon_amount" value="0">
            <input type="hidden" name="grand_total" value="{{$total_price}}">
        @endif

            <div class="review-payment pt-5">
                <h4>Delivery Date</h4>
            </div>
            <?php $tiffin_found=0;$catering_found=0;$menu_found=0;$tiffin_pro_only=0;$tiffin_preparation_date=""; ?>
            @foreach($cart_datas as $cart_data)
            <?php
                $image_products=DB::table('products')->select('main_categories_id','tiffin_preparation_date')->where('id',$cart_data->products_id)->first();
                if($image_products->main_categories_id==1){
                  $tiffin_found=1;
                  $tiffin_pro_only=1;
                  $tiffin_preparation_date=$image_products->tiffin_preparation_date;
                }
                if($image_products->main_categories_id==2){
                  $catering_found=1;
                }
                if($image_products->main_categories_id==3){
                  $menu_found=1;
                }

            ?>
            @endforeach
            <?php
              $date_condition=0;
              if($tiffin_found==1 && $catering_found==1 && $menu_found==1){
                $date_condition=1;
              }elseif($tiffin_found==1 && $catering_found==1 && $menu_found==0){
                $date_condition=1;
              }elseif($tiffin_found==1 && $catering_found==0 && $menu_found==1){
                $date_condition=1;
              }elseif($tiffin_found==1 && $catering_found==0 && $menu_found==0){
                $date_condition=1;
              }elseif($tiffin_found==0 && $catering_found==1 && $menu_found==1){
                $date_condition=0;
              }elseif($tiffin_found==0 && $catering_found==0 && $menu_found==1){
                $date_condition=0;
              }elseif($tiffin_found==0 && $catering_found==1 && $menu_found==0){
                $date_condition=0;
              }else{
                $date_condition=0;
              }
            ?>
            <?php
            if($tiffin_pro_only==0){ // If not tiffin product
            if($catering_found==0){ // not catering
                if($date_condition==1){
                  //echo $theme_data->order_cutoff_time.">=".date("H:i:s");
                 if($theme_data->order_cutoff_time >= date("H:i:s")){
                   $todaydate = date('m/d/Y');
                   //echo "1";
                ?>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    Date
                    <input type="text" value="<?php echo $todaydate; ?>" name="delivery_date" required class="todaydatepicker1 form-control required"/>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    Time
                    <?php /*<input type="text" value="" name="delivery_time" required class="todaytimepicker1 form-control required"/> */ ?>
                    <select class=" form-control required" required name="delivery_time">
                      <option value="">Select Time</option>
                      <?php
                        $start_time_data = explode(":",$theme_data->pickup_start_time);
                        $end_time_data = explode(":",$theme_data->pickup_end_time);
                        $count = 2*($end_time_data[0]-$start_time_data[0]);
                        $hours = $start_time_data[0];
                        $minute = $start_time_data[1];
                        $sec = $start_time_data[2];
                        for($g=0,$k=1;$g<=$count;$g++){
                      ?>
                        <option value="<?php echo $hours.":".$minute.":".$sec ?>"><?php echo $hours.":".$minute ?></option>
                      <?php
                          if($k % 2 == 0){
                            $hours = $hours + 1;
                            $minute = $start_time_data[1];
                          }else{
                            $minute = $minute + 30;
                          }
                          $k++;
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <?php
                }else{
                  $tomorrwdate = date('m/d/Y', strtotime(' +1 day'));
                  //echo $tomorrwdate;
                  //echo "2";
                ?>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    Date
                    <input type="text" value="<?php echo $tomorrwdate; ?>" name="delivery_date" required class="tomorrowdatepicker1 form-control required"/>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    Time
                    <select class=" form-control required" required name="delivery_time">
                      <option value="">Select Time</option>
                      <?php
                        $start_time_data = explode(":",$theme_data->pickup_start_time);
                        $end_time_data = explode(":",$theme_data->pickup_end_time);
                        $count = 2*($end_time_data[0]-$start_time_data[0]);
                        $hours = $start_time_data[0];
                        $minute = $start_time_data[1];
                        $sec = $start_time_data[2];
                        for($g=0,$k=1;$g<=$count;$g++){
                          if($hours >= $end_time_data[0]){
                            if($minute <= $end_time_data[1]){
                          ?>
                            <option value="<?php echo $hours.":".$minute.":".$sec ?>"><?php echo $hours.":".$minute ?></option>
                          <?php
                            }
                          }else{
                            ?>
                              <option value="<?php echo $hours.":".$minute.":".$sec ?>"><?php echo $hours.":".$minute ?></option>
                            <?php
                          }
                          if($k % 2 == 0){
                            $hours = $hours + 1;
                            $minute = $start_time_data[1];
                          }else{
                            $minute = $minute + 30;
                          }
                          $k++;
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <?php
                }
               }else{
                 $todaydate = date('m/d/Y');
              ?>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  Date
                  <input type="text" value="<?php echo $todaydate; ?>" name="delivery_date" required class="todaydatepicker1 form-control required"/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  Time
                  <select class=" form-control required" required name="delivery_time">
                    <option value="">Select Time</option>
                    <?php
                      $start_time_data = explode(":",$theme_data->pickup_start_time);
                      $end_time_data = explode(":",$theme_data->pickup_end_time);
                      $count = 2*($end_time_data[0]-$start_time_data[0]);
                      $hours = $start_time_data[0];
                      $minute = $start_time_data[1];
                      $sec = $start_time_data[2];
                      for($g=0,$k=1;$g<=$count;$g++){
                    ?>
                      <option value="<?php echo $hours.":".$minute.":".$sec ?>"><?php echo $hours.":".$minute ?></option>
                    <?php
                        if($k % 2 == 0){
                          $hours = $hours + 1;
                          $minute = $start_time_data[1];
                        }else{
                          $minute = $minute + 30;
                        }
                        $k++;
                      }
                    ?>
                  </select>
                </div>
              </div>
              <?php
              }
            }else{ // if catering found

              $cat_date = " +".$theme_data->catering_min_date." day";
            ?>
              <input type='hidden' class='catd' name='catd' value='<?php echo $theme_data->catering_min_date; ?>'>
            <?php
              $cateringdate = date('m/d/Y', strtotime($cat_date));
            ?>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                Date
                <input type="text" value="<?php echo $cateringdate; ?>" name="delivery_date" required class="cateringdatepicker1 form-control required"/>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                Time
                <select class=" form-control required" required name="delivery_time">
                  <option value="">Select Time</option>
                  <?php
                    $start_time_data = explode(":",$theme_data->pickup_catering_start_time);
                    $end_time_data = explode(":",$theme_data->pickup_catering_end_time);
                    $count = 2*($end_time_data[0]-$start_time_data[0]);
                    $hours = $start_time_data[0];
                    $minute = $start_time_data[1];
                    $sec = $start_time_data[2];
                    for($g=0,$k=1;$g<=$count;$g++){
                  ?>
                    <?php
                      if(strlen($hours)==1){
                    ?>
                    <option value="<?php echo "0".$hours.":".$minute.":".$sec ?>"><?php echo "0".$hours.":".$minute ?></option>
                    <?php
                      }else{
                    ?>
                    <option value="<?php echo $hours.":".$minute.":".$sec ?>"><?php echo $hours.":".$minute ?></option>
                    <?php
                      }
                    ?>
                  <?php
                      if($k % 2 == 0){
                        $hours = $hours + 1;
                        $minute = $start_time_data[1];
                      }else{
                        $minute = $minute + 30;
                      }
                      $k++;
                    }
                  ?>
                </select>
              </div>
            </div>
            <?php
             }
           }else{  // Only tiffin
            ?>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                Date
                <input type="text" value="<?php echo Carbon\Carbon::parse($tiffin_preparation_date)->format("m/d/Y"); ?>" name="delivery_date" required class="todaydatepicker1 form-control required"/>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12">
                Time
                <?php /*<input type="text" value="" name="delivery_time" required class="todaytimepicker1 form-control required"/> */ ?>
                <select class=" form-control required" required name="delivery_time">
                  <option value="">Select Time</option>
                  <?php
                    $start_time_data = explode(":",$theme_data->pickup_start_time);
                    $end_time_data = explode(":",$theme_data->pickup_end_time);
                    $count = 2*($end_time_data[0]-$start_time_data[0]);
                    $hours = $start_time_data[0];
                    $minute = $start_time_data[1];
                    $sec = $start_time_data[2];
                    for($g=0,$k=1;$g<=$count;$g++){
                  ?>
                    <option value="<?php echo $hours.":".$minute.":".$sec ?>"><?php echo $hours.":".$minute ?></option>
                  <?php
                      if($k % 2 == 0){
                        $hours = $hours + 1;
                        $minute = $start_time_data[1];
                      }else{
                        $minute = $minute + 30;
                      }
                      $k++;
                    }
                  ?>
                </select>
              </div>
            </div>
            <?php
           }
             ?>
            <div class="review-payment pt-5">
                <h4>Review & Payment</h4>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td class="ftotal"></td>
                    </tr>
                    </thead>
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
                            <p>{{$cart_data->product_name}} ({{$cart_data->product_code}})</p>
                        </td>
                        <td class="cart_price">
                            <p>{{ $theme_data->currency }}{{$cart_data->price}}</p>
                        </td>
                        <td class="cart_quantity">
                            <p>{{$cart_data->quantity}}</p>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{ $theme_data->currency }}{{$cart_data->price*$cart_data->quantity}}</p>
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Order total:</td>
                                    <td>{{ $theme_data->currency }}{{$total_price}}</td>
                                </tr>
                                @if(Session::has('discount_amount_price'))
                                    <tr class="shipping-cost">
                                        <td>Coupon Discount:</td>
                                        <td>{{ $theme_data->currency }}{{Session::get('discount_amount_price')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td><span>{{ $theme_data->currency }}{{$total_price-Session::get('discount_amount_price')}}</span></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>Total:</td>
                                        <td><span>{{ $theme_data->currency }}{{$total_price}}</span></td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
              </div>
              <div class="payment-options">
                  <span>Select Payment Method : </span><br/>
              <span>
                  <label><input type="radio" name="payment_method" value="Paypal" checked> Pay Online - Full Payment</label>
              </span>
              <br>
              <?php if($catering_found==1){ ?>
              <span>
                  <label><input type="radio" name="payment_method" value="PaypalPartial"> Pay Online - 50% Partial Payment</label>
              </span>
              <br>
            <?php } ?>
              <span>
                  <label><input type="radio" name="payment_method" value="POP"> Pay on Pickup</label>
              </span>
                <button type="submit" class="btn btn-outline-secondary btn-sm mt-1" style="float: right;"><span>Order Now</span></button>
              </div>
    </form>
    </div>
  </div>
 </div>
</div>
</section>
<script>
$(document).ready(function(){
  $('input[type="checkbox"]').click(function(){
    if($(this).prop("checked") == true){
        $("#createacc").attr('style','display:block');
        $("#createaccpass").attr('required', 'required');
    }else if($(this).prop("checked") == false){
        $("#createacc").attr('style','display:none');
        $("#createaccpass").removeAttr('required');
    }
  });
});
</script>
@endsection
