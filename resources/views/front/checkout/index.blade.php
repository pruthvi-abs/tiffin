@extends('front.layout.main')
@section('content')
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

    <form action="{{url('/submit-checkout')}}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="login-form"><!--login form-->
                <legend class="pb-4">Billing To</legend>
                <div class="form-group {{$errors->has('billing_name')?'has-error':''}}">
                    <input type="text" class="form-control" name="billing_name" id="billing_name" value="{{$user_login->name}}" required placeholder="Billing Name">
                    <span class="text-danger">{{$errors->first('billing_name')}}</span>
                </div>
                <div class="form-group {{$errors->has('billing_address')?'has-error':''}}">
                    <input type="text" class="form-control" value="{{$user_login->address}}" name="billing_address" required id="billing_address" placeholder="Billing Address">
                    <span class="text-danger">{{$errors->first('billing_address')}}</span>
                </div>
                <div class="form-group {{$errors->has('billing_city')?'has-error':''}}">
                    <input type="text" class="form-control" name="billing_city" value="{{$user_login->city}}" required id="billing_city" placeholder="Billing City">
                    <span class="text-danger">{{$errors->first('billing_city')}}</span>
                </div>
                <div class="form-group {{$errors->has('billing_state')?'has-error':''}}">
                    <input type="text" class="form-control" name="billing_state" value="{{$user_login->state}}" required id="billing_state" placeholder=" Billing State">
                    <span class="text-danger">{{$errors->first('billing_state')}}</span>
                </div>
                <div class="form-group">
                    <select name="billing_country" id="billing_country"  required class="form-control">
                        @foreach($countries as $country)
                            <option value="{{$country->country_name}}" {{$user_login->country==$country->country_name?' selected':''}}>{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group {{$errors->has('billing_pincode')?'has-error':''}}">
                    <input type="text" class="form-control" name="billing_pincode" value="{{$user_login->pincode}}" required id="billing_pincode" placeholder=" Billing Pincode">
                    <span class="text-danger">{{$errors->first('billing_pincode')}}</span>
                </div>
                <div class="form-group {{$errors->has('billing_mobile')?'has-error':''}}">
                    <input type="text" class="form-control" name="billing_mobile" value="{{$user_login->mobile}}" required id="billing_mobile" placeholder="Billing Mobile">
                    <span class="text-danger">{{$errors->first('billing_mobile')}}</span>
                </div>
            </div><!--/login form-->
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="signup-form"><!--sign up form-->
                <legend>Shipping To</legend>
                <span>
                    <input type="checkbox" class="checkbox" name="checkme" id="checkme"> &nbsp; Shipping Address same as Billing Address
                </span>
                <div class="form-group {{$errors->has('shipping_name')?'has-error':''}}">
                    <input type="text" class="form-control" name="shipping_name" id="shipping_name" required value="" placeholder="Shipping Name">
                    <span class="text-danger">{{$errors->first('shipping_name')}}</span>
                </div>
                <div class="form-group {{$errors->has('shipping_address')?'has-error':''}}">
                    <input type="text" class="form-control" value="" name="shipping_address" required id="shipping_address" placeholder="Shipping Address">
                    <span class="text-danger">{{$errors->first('shipping_address')}}</span>
                </div>
                <div class="form-group {{$errors->has('shipping_city')?'has-error':''}}">
                    <input type="text" class="form-control" name="shipping_city" value="" required id="shipping_city" placeholder="Shipping City">
                    <span class="text-danger">{{$errors->first('shipping_city')}}</span>
                </div>
                <div class="form-group {{$errors->has('shipping_state')?'has-error':''}}">
                    <input type="text" class="form-control" name="shipping_state" value="" required id="shipping_state" placeholder="Shipping State">
                    <span class="text-danger">{{$errors->first('shipping_state')}}</span>
                </div>
                <div class="form-group">
                    <select name="shipping_country" id="shipping_country" required class="form-control">
                        @foreach($countries as $country)
                            <option value="{{$country->country_name}}">{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group {{$errors->has('shipping_pincode')?'has-error':''}}">
                    <input type="text" class="form-control" name="shipping_pincode" value="" required id="shipping_pincode" placeholder="Shipping Pincode">
                    <span class="text-danger">{{$errors->first('shipping_pincode')}}</span>
                </div>
                <div class="form-group {{$errors->has('shipping_mobile')?'has-error':''}}">
                    <input type="text" class="form-control" name="shipping_mobile" value="" required id="shipping_mobile" placeholder="Shipping Mobile">
                    <span class="text-danger">{{$errors->first('shipping_mobile')}}</span>
                </div>
                <button type="submit" class="btn btn-outline-secondary btn-sm mt-1" style="float: right;"><span>CheckOut</span></button>
                <!--<button type="submit" class=""><span>Apply</span></button>-->
            </div><!--/sign up form-->
        </div>
      </div>
    </form>
  </div>
</div>  
</section>
<script>
///// Copy Billing address to Shipping Address
$(document).ready(function(){
  $("#checkme").click(function () {
    if(this.checked){
  	   $("#shipping_name").val($("#billing_name").val());
       $("#shipping_address").val($("#billing_address").val());
       $("#shipping_city").val($("#billing_city").val());
       $("#shipping_state").val($("#billing_state").val());
       $("#shipping_country").val($("#billing_country").val());
       $("#shipping_pincode").val($("#billing_pincode").val());
       $("#shipping_mobile").val($("#billing_mobile").val());
    }else{
       $("#shipping_name").val("");
       $("#shipping_address").val("");
       $("#shipping_city").val("");
       $("#shipping_state").val("");
       $("#shipping_country").val("Albania");
       $("#shipping_pincode").val("");
       $("#shipping_mobile").val("");
    }
  });
});
</script>
@endsection
