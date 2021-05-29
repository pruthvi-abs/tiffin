@extends('front.layout.main')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','tenant_title','tenant_favicon','currency','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h4 class="mb-0 pull-left">View Order</h4>
            </div>
            <div class="col-lg-6 col-md-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / View Order</p>
            </div>
        </div>
    </div>
</div>
<section class="section section-bg-edge">
<div class="container">
<div class="row">
<div class="col-lg-3 col-md-3">
  @include('front.includes.usersidebar')
</div>
<div class="col-lg-9 col-md-9">
  <div class="row">
    <div class="col-lg-8 col-md-8">
      <h4 class="pt-5 pb-2">View Order</h4>
    </div>
    <div class="col-lg-4 col-md-4">
      <div class="pt-5 pb-2 pull-right">
        {!! Form::open(['route'=>'myvieworderdatepdf','method'=>'POST','role'=>'form','id'=>'formsubmit','style'=>'margin-right:10px;margin-left:10px;','target'=>'_blank']) !!}
            <?php
             $orders_data = json_encode($orders);
             $orderproduct_data = json_encode($orderproduct);
             $payment_data = json_encode($orderpayment);
            ?>
            <input type="hidden" name="orders" value="{{$orders_data}}"/>
            <input type="hidden" name="orderproduct" value="{{$orderproduct_data}}"/>
            <input type="hidden" name="orderpayment" value="{{$payment_data}}"/>
            <?php if($orders->order_status!="Canceled"){ ?>
            @if($orders->amount_received=="Yes")
            <button class="btn btn-outline-secondary btn-sm mt-1 check_out">
             <span>Print</span>
            </button>
            @endif
             &nbsp;&nbsp;
           <?php } ?>
            <a class="btn btn-outline-secondary btn-sm mt-1 check_out" href="{{ url('/myorder') }}"><span>Back</span></a>
        {!! Form::close() !!}

      </div>
    </div>
  </div>
  <p> <strong>Order ID :</strong> {{$orders->id}} <br>
   <strong>Order Status :</strong> {{$orders->order_status}} <br>
   <strong>Order Date :</strong> <?php echo Carbon\Carbon::parse($orders->created_at)->format($theme_data->datetime_format) ?><br>
   <?php if($orders->payment_method=="Paypal"){ ?>
     <strong>Payment Mode :</strong> {{$orders->payment_method}} ({{$orders->payer_id}}) <br>
   <?php }else{ ?>
     <strong>Payment Mode :</strong> {{$orders->payment_method}} <br>
    <?php } ?>
    <strong>Delivery Date :</strong> <?php echo Carbon\Carbon::parse($orders->delivery_date)->format($theme_data->datetime_format) ?><br>
  </p>
  <div class="pb-5">
  <div class="table-responsive">
  <table id="example" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th width="20%">Sr No</th>
                <th width="30%">Name</th>
                <th width="15%">Quantity</th>
                <th width="15%">Price</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $total_price=0;
            for($i=0,$j=1;$i<count($orderproduct);$i++,$j++){
              $total_price = $total_price + ($orderproduct[$i]->p_qty*$orderproduct[$i]->p_price);
          ?>
            <tr>
                <td>{{$j}}</td>
                <td>{{$orderproduct[$i]->p_name}}</td>
                <td>{{$orderproduct[$i]->p_qty}}</td>
                <td>{{ $theme_data->currency }}{{$orderproduct[$i]->p_price}}</td>
                <td>{{ $theme_data->currency }}<?php echo $orderproduct[$i]->p_qty*$orderproduct[$i]->p_price; ?></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="2">
                    <table class="table table-condensed total-result">
                        <tr>
                            <td>Cart Sub Total</td>
                            <td>${{$total_price}}</td>
                        </tr>
                        @if($orders->coupon_amount > 0)
                          <tr class="shipping-cost">
                              <td>Coupon Discount</td>
                              <td>{{ $theme_data->currency }}{{$orders->coupon_amount}}</td>
                          </tr>
                          <tr>
                              <td>Total</td>
                              <td><span>{{ $theme_data->currency }}{{$total_price-$orders->coupon_amount}}</span></td>
                          </tr>
                        @else
                          <tr>
                              <td>Total</td>
                              <td><span>{{ $theme_data->currency }}{{$total_price}}</span></td>
                          </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
  </div>
  <?php if(count($orderpayment)>=1){ ?>
  <h4>Payment Details</h4>
  <div class="table-responsive">
 <table id="example" class="table table-bordered" style="width:100%">
       <thead>
           <tr>
               <th>Sr No</th>
               <th>Type</th>
               <th>Details</th>
               <th>Payment Status</th>
               <th>Amount</th>
               <th>Date</th>
           </tr>
       </thead>
       <tbody>
         <?php
            for($i=0,$j=1;$i<count($orderpayment);$i++,$j++){
         ?>
           <tr>
               <td>{{$j}}</td>
               <td>{{$orderpayment[$i]->payment_type}}</td>
               <td>{{$orderpayment[$i]->payment_details}}</td>
               <td>{{$orderpayment[$i]->payment_status}}</td>
               <td>
                 <?php if($orderpayment[$i]->payment_status=="Refund"){ ?>
                   {{$theme_data->currency}}{{$orderpayment[$i]->payment_amount}}
                <?php }else{ ?>
                   {{$theme_data->currency}}{{$orderpayment[$i]->payment_amount}}
                <?php } ?>
               </td>
               <td><?php echo Carbon\Carbon::parse($orderpayment[$i]->payment_date)->format($theme_data->datetime_format); ?></td>
           </tr>
           <?php
           }
           ?>
       </tbody>
   </table>
   </div>
  <?php } ?>
  </div>
</div>
</div>
</div>
</section>
<script>
$(document).ready(function() {
    $('#example').DataTable({
      "pagingType": "full_numbers",
      searching: false,
      //ordering:  false,
      paging: false,
      //scrollY: 300,

    });
} );
</script>
@endsection
