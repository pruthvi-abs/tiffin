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
    <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="step-one">
        <h3 class="text-center">YOUR ORDER HAS BEEN PLACED</h3>
        <p class="text-center">Thanks for your Order that use Options on Paypal</p>
        <p class="text-center">
          Confirmation : #
        <?php
          for($p=0;$p<count($session_paypal_order_id);$p++){
            if($p==0){
              echo $session_paypal_order_id[$p];
            }else{
              echo $session_paypal_order_id[$p];
            }
          }
        ?>
        </p>
        <p class="text-center">We will contact you by Your Email (<b>{{$user_order->users_email}}</b>) or Your Phone Number (<b>{{$user_order->mobile}}</b>)</p>
      </div>
    </div>
    </div>
  </div>
  </div>
</section>
@endsection
