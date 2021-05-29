@extends('admin.layout.dashboard')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','currency','tenant_title','tenant_favicon','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<style>
.custbtn form {
	position: relative;
	display: inline-block;
}
</style>
<div class="page-title">
		<div class="col-md-9 col-sm-9 form-group pull-right">
			<h3>{{ $action }}</h3>
		</div>
		<div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
        <div class="custbtn">
          <?php if($orders->order_status!="Canceled"){ ?>
            {!! Form::open(['route'=>'order.sendmail','method'=>'POST','role'=>'form','id'=>'formsubmit','style'=>'margin-right:10px;margin-left:10px;']) !!}
                <?php
                 $orders_data = json_encode($orders);
                 $orderproduct_data = json_encode($orderproduct);
                 $payment_data = json_encode($orderpayment);
                ?>
                <input type="hidden" name="orders" value="{{$orders_data}}"/>
                <input type="hidden" name="orderproduct" value="{{$orderproduct_data}}"/>
                <input type="hidden" name="orderpayment" value="{{$payment_data}}"/>
                {!! Form::submit('Send Mail',['class'=>'btn-sm btn bg-green']) !!}
            {!! Form::close() !!}
            {!! Form::open(['route'=>'order.datepdf','method'=>'POST','role'=>'form','id'=>'formsubmit','style'=>'margin-right:10px;margin-left:10px;','target'=>'_blank']) !!}
               <?php
                $orders_data = json_encode($orders);
                $orderproduct_data = json_encode($orderproduct);
                $payment_data = json_encode($orderpayment);
               ?>
               <input type="hidden" name="orders" value="{{$orders_data}}"/>
               <input type="hidden" name="orderproduct" value="{{$orderproduct_data}}"/>
               <input type="hidden" name="orderpayment" value="{{$payment_data}}"/>
               {!! Form::submit('Print',['class'=>'btn-sm btn bg-purple']) !!}
            <?php } ?>
                 &nbsp;&nbsp;
               {!! Html::linkRoute('order.index','Back',array(),['class'=>'btn-sm btn bg-maroon margin']) !!}
            {!! Form::close() !!}
        </div>

			</div>
		</div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12">
  <!-- /.box-header -->
    <div class="box-body">
      @if(Session::has('success'))
      	<div class="alert alert-success" role="alert">
      		{!! Session::get('success') !!}
      	</div>
      @elseif(Session::has('error'))
      	<div class="alert alert-danger" role="alert">
      		{!! Session::get('danger') !!}
      	</div>
      @endif
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="col-md-12">
  <?php $paid_amt=0; ?>
	   	 <strong>Order ID :</strong> {{$orders->id}} <br>
	   	 <strong>Order Status :</strong> {{$orders->order_status}}<br>
       <?php if($orders->order_status=="Canceled"){ ?>
         <strong>Cancel Status :</strong> {{$orders->cancel_notes}}<br>
       <?php } ?>
	     <strong>Order Date :</strong> <?php echo Carbon\Carbon::parse($orders->created_at)->format($theme_data->datetime_format); ?><br>
			 <?php if($orders->payment_method=="Paypal"){ ?>
		     <strong>Payment Mode :</strong> {{$orders->payment_method}} ({{$orders->payer_id}}) <br>
		   <?php }else{ ?>
		     <strong>Payment Mode :</strong> {{$orders->payment_method}} <br>
		    <?php } ?>
        <strong>Delivery Date :</strong> <?php echo Carbon\Carbon::parse($orders->delivery_date)->format($theme_data->datetime_format); ?><br>
        <?php if($orders->amount_received=="Yes"){ ?>
        <strong>Payment Received :</strong> Paid<br>
        <?php }else{ ?>
          <?php
          if(count($orderpayment)>=1){
            $check_paid_amt=0;
            $check_refund_amt=0;
            $max_refund=0;
            for($i=0,$j=1;$i<count($orderpayment);$i++,$j++){
              if($orderpayment[$i]->payment_status=="Paid"){
                $check_paid_amt = $check_paid_amt + $orderpayment[$i]->payment_amount;
              }else{
                $check_refund_amt = $check_refund_amt + $orderpayment[$i]->payment_amount;
              }
            }
            $trans_amt = $check_paid_amt-$check_refund_amt;
            //echo $orders->grand_total."==".$check_paid_amt;
            if($orders->grand_total == $trans_amt){
            ?>
              <strong>Payment Received :</strong> Paid<br>
            <?php
            }else{
            ?>
              <strong>Payment Received :</strong> Partial Paid<br>
            <?php
              //$max_refund = $check_paid_amt-$orders->grand_total-$check_refund_amt;
              //echo $max_refund;
            }
          }else{
            ?>
          <strong>Payment Received :</strong> Unpaid<br>
        <?php } } ?>

	  <div class="pb-5 pt-2">
      <style>
      .modal-body.custom-height {
        	height: 400px !important;
        	overflow: hidden;
        	margin-bottom: 25px;
        	overflow-y: auto;
        }
      </style>
      <!-- Product Add Logic -->
      <?php
        // Product Order Status Condition
        if($orders->order_status=="Accepted"){
          // Category Condition
          if($orders->main_categories_id==1){
      ?>
      <?php
          }elseif($orders->main_categories_id==2){
      ?>
      <button type="button" class="btn-sm btn btn-primary pull-right" data-original-title="Add" data-toggle="modal" data-target="#addcateringProductcatModal">Add</button>
      <div class="modal fade " id="addcateringProductcatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Catering Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php $product_url = url('/backaddcateringproduct'); ?>
            <div class="modal-body custom-height">
              <?php $catering_product = $mail = DB::table('products')->where('main_categories_id',2)->where('is_visible','yes')->orderBy('categories_id')->get(); ?>
              <div class="table-responsive">
          	  <table class="table jambo_table bulk_action">
          	    <thead>
                <tr>
                  <td width="33%">Name</td>
                  <td width="33%">Price</td>
                  <td width="34%">Quantity</td>
                </tr>
                </thead>
                <tbody>
              <?php for($mp=0;$mp<count($catering_product);$mp++){ ?>
                <?php
                  $found=0;
                  $qty=0;
                  for($cp=0;$cp<count($orderproduct);$cp++){
                    $qty = $orderproduct[$cp]->p_qty;
                    if($catering_product[$mp]->id==$orderproduct[$cp]->p_id){
                      $found=1;
                    }
                  }
                  if($found==0){
                 ?>
                <tr>
                  <td>{{$catering_product[$mp]->p_name}}</td>
                  <td>{{$theme_data->currency.$catering_product[$mp]->price}}</td>
                  <td>
                    <form action="<?php echo $product_url; ?>" method="post" id="addcateringproductform">
                        {{ csrf_field() }}
                      <input type="hidden" value="{{$orders->id}}" id="curr_order_id" name="curr_order_id" class="form-control required"/>
                      <input type="hidden" value="{{$catering_product[$mp]->id}}" id="product_id" name="product_id" class="form-control required"/>
                      <input type="hidden" value="{{$catering_product[$mp]->p_name}}" id="p_name" name="p_name" class="form-control required"/>
                      <input type="hidden" value="{{$catering_product[$mp]->price}}" id="p_price" name="p_price" class="form-control required"/>
                      <input type="hidden" value="{{$catering_product[$mp]->p_code}}" id="p_code" name="p_code" class="form-control required"/>
                      <input type="hidden" value="{{$qty}}" min="1" id="p_qty" name="p_qty" class="form-control required"/>
                      <div class="row">
                        <div class="col-sm-12">
                          <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                      </div>
                    </form>
                  </td>
                  </tr>
                <?php
                    }
                  }
                ?>
              </tbody>
              </table>
              </div>
             </div>
           <script>
           $(document).ready(function($) {
             $("#addcateringproductform").validate({
               rules: {
                 p_qty:  "required",
               },
               messages: {
                 p_qty:  "This field is required",
               },
               submitHandler: function(form) {
                 form.submit();
               }
             });
           });
           </script>
          </div>
        </div>
      </div>
      <?php
          }else{
      ?>
      <button type="button" class="btn-sm btn btn-primary pull-right" data-original-title="Add" data-toggle="modal" data-target="#addmenuProductcatModal">Add</button>
      <div class="modal fade " id="addmenuProductcatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Menu Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php $product_url = url('/backaddmenuproduct'); ?>
            <div class="modal-body custom-height">
              <?php $menu_product = $mail = DB::table('products')->where('main_categories_id',3)->where('is_visible','yes')->orderBy('categories_id')->get(); ?>
              <div class="table-responsive">
          	  <table class="table jambo_table bulk_action">
          	    <thead>
                <tr>
                  <td width="25%">Name</td>
                  <td width="25%">Price</td>
                  <td width="50%">Quantity</td>
                </tr>
                </thead>
                <tbody>
              <?php for($mp=0;$mp<count($menu_product);$mp++){ ?>
                <?php
                  $found=0;
                  for($cp=0;$cp<count($orderproduct);$cp++){
                    if($menu_product[$mp]->id==$orderproduct[$cp]->p_id){
                      $found=1;
                    }
                  }
                  if($found==0){
                 ?>
                <tr>
                  <td>{{$menu_product[$mp]->p_name}}</td>
                  <td>{{$theme_data->currency.$menu_product[$mp]->price}}</td>
                  <td>
                    <form action="<?php echo $product_url; ?>" method="post" id="addmenuproductform">
                        {{ csrf_field() }}
                      <input type="hidden" value="{{$orders->id}}" id="curr_order_id" name="curr_order_id" class="form-control required"/>
                      <input type="hidden" value="{{$menu_product[$mp]->id}}" id="product_id" name="product_id" class="form-control required"/>
                      <input type="hidden" value="{{$menu_product[$mp]->p_name}}" id="p_name" name="p_name" class="form-control required"/>
                      <input type="hidden" value="{{$menu_product[$mp]->price}}" id="p_price" name="p_price" class="form-control required"/>
                      <input type="hidden" value="{{$menu_product[$mp]->p_code}}" id="p_code" name="p_code" class="form-control required"/>
                      <div class="row">
                        <div class="col-sm-6">
                          <input type="number" value="1" min="1" id="p_qty" name="p_qty" class="form-control required"/>
                        </div>
                        <div class="col-sm-6">
                          <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                      </div>
                    </form>
                  </td>
                  </tr>
                <?php
                    }
                  }
                ?>
              </tbody>
              </table>
              </div>
             </div>
           <script>
           $(document).ready(function($) {
             $("#addmenuproductform").validate({
               rules: {
                 p_qty:  "required",
               },
               messages: {
                 p_qty:  "This field is required",
               },
               submitHandler: function(form) {
                 form.submit();
               }
             });
           });
           </script>
          </div>
        </div>
      </div>
      <?php
          }
      ?>
      <?php
        } // Product Order Status Condition
      ?>
      <!-- Product Add Logic -->


      <?php
        if($orders->order_status=="Accepted"){
          if($orders->main_categories_id==2){
        ?>
        <!-- Product Edit -->
        <button type="button" class="btn-sm btn btn-warning pull-right" data-original-title="Edit" data-toggle="modal" data-target="#editProductcatModal">Edit</button>
        <div class="modal fade" id="editProductcatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product Quantity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php $editcat_url = url('/editorderproductcatering'); ?>
             <form action="<?php echo $editcat_url; ?>" method="post" id="editproductcateringform">
              <div class="modal-body">
               {{ csrf_field() }}
                <input type="hidden" value="{{$orders->id}}" id="order_id" name="order_id" class="form-control required"/>
                  <div class="row">
                   <div class="col-md-12">
                      <div class="form-group">
                        {!! Form::label('p_qty','Quantity') !!}
                        <input type="number" value="" min="10" id="p_qty" name="p_qty" class="form-control required"/>
                        @if ($errors->has('p_qty'))
                          <p class='text-red'>{{ $errors->first('p_qty') }}</p>
                         @endif
                      </div>
                     </div>
                   </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
               </form>
             <script>
             $(document).ready(function($) {
               $("#editproductcateringform").validate({
                 rules: {
                   p_qty:  "required",
                 },
                 messages: {
                   p_qty:  "This field is required",
                 },
                 submitHandler: function(form) {
                   form.submit();
                 }
               });
             });
             </script>
            </div>
          </div>
        </div>
        <!-- Product Edit -->
      <?php
        }
      }
      ?>
	  <div class="table-responsive">
	  <table id="" class="table jambo_table bulk_action">
	        <thead>
	            <tr>
	                <th>Sr No</th>
	                <th>Name</th>
	                <th>Quantity</th>
                  <th>Price</th>
	                <th>Total</th>
                  <?php
                    if($orders->order_status=="Accepted"){
                  ?>
                  <th>Action</th>
                  <?php
                    }
                  ?>
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
	                <td>{{$theme_data->currency}}{{$orderproduct[$i]->p_price}}</td>
	                <td>{{$theme_data->currency}}<?php echo $orderproduct[$i]->p_qty*$orderproduct[$i]->p_price; ?></td>
                  <?php
                    if($orders->order_status=="Accepted"){
                  ?>
                  <td>
                    <?php
                      if($orders->main_categories_id==1 || $orders->main_categories_id==3){
                    ?>
                    <!-- Product Edit -->
                    <button type="button" class="btn-sm btn btn-warning" data-original-title="Edit" data-toggle="modal" data-target="#editProductModal{{$j}}">Edit</button>
                    <div class="modal fade" id="editProductModal{{$j}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Product Quantity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <?php $edit_url = url('/editorderproduct')."/".$orderproduct[$i]->id; ?>
                         <form action="<?php echo $edit_url; ?>" method="post" id="editproductform">
                          <div class="modal-body">
                           {{ csrf_field() }}
                            <input type="hidden" value="{{$orderproduct[$i]->order_id}}" id="order_id" name="order_id" class="form-control required"/>
                              <div class="row">
                               <div class="col-md-12">
                                  <div class="form-group">
                                    {!! Form::label('p_qty','Quantity') !!}
                                    <input type="number" value="{{$orderproduct[$i]->p_qty}}" id="p_qty" name="p_qty" class="form-control required"/>
                                    @if ($errors->has('p_qty'))
                                      <p class='text-red'>{{ $errors->first('p_qty') }}</p>
                                     @endif
                                  </div>
                                 </div>
                               </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                           </form>
                         <script>
                         $(document).ready(function($) {
                           $("#editproductform").validate({
                             rules: {
                               p_qty:  "required",
                             },
                             messages: {
                               p_qty:  "This field is required",
                             },
                             submitHandler: function(form) {
                               form.submit();
                             }
                           });
                         });
                         </script>
                        </div>
                      </div>
                    </div>
                    <!-- Product Edit -->
                  <?php } ?>
                    <!-- Product Delete -->
                    <?php if(count($orderproduct) >= 2 ){ ?>
                      <a data-type="confirm" href="javascript:void(0);" onclick="ProductshowConfirmMessage({{$orderproduct[$i]->id}},{{$orderproduct[$i]->order_id}});" data-toggle="tooltip" data-placement="top" title="" class="btn-sm btn btn-danger" >Delete</a>
                    <?php } ?>
                    <!-- Product Delete -->
                  </td>
                  <?php
                    }
                  ?>
	            </tr>
	            <?php
	            }
	            ?>
							<tr>
                <?php
                  if($orders->order_status=="Accepted"){
                ?>
									<td colspan="4">&nbsp;</td>
                <?php
                  }else{
                ?>
                	<td colspan="3">&nbsp;</td>
                <?php
                  }
                ?>
									<td colspan="2">
											<table class="table table-condensed total-result">
													<tr>
															<td>Cart Sub Total</td>
															<td>${{$orders->grand_total}}</td>
													</tr>
													@if($orders->coupon_amount > 0)
														<tr class="shipping-cost">
																<td>Coupon Discount</td>
																<td>{{$theme_data->currency}}{{$orders->coupon_amount}}</td>
														</tr>
														<tr>
																<td>Total</td>
																<td><span>{{$theme_data->currency}}{{$orders->grand_total-$orders->coupon_amount}}</span></td>
														</tr>
													@else
														<tr>
																<td>Total</td>
																<td><span>{{$theme_data->currency}}{{$orders->grand_total}}</span></td>
														</tr>
													@endif
											</table>
									</td>
							</tr>
	        </tbody>
	    </table>
	  	</div>
<?php $max_refund=0; ?>
      <div class="row">
        <div class="col-md-8">
          <?php if(count($orderpayment)>=1){ ?>
            <h4>Payment Details</h4>
          <?php }else{ ?>
            <?php if($orders->order_status=="Accepted"){ ?>
              <h4>Payment Details</h4>
            <?php } ?>
          <?php } ?>
        </div>
        <div class="col-md-4">
          <!-- Add Payment Model -->
          <?php if($orders->order_status=="Accepted"){ ?>
            <?php
              $check_paid_amt=0;
              $check_refund_amt=0;
              $max_refund=0;
              for($i=0,$j=1;$i<count($orderpayment);$i++,$j++){
                if($orderpayment[$i]->payment_status=="Paid"){
                  $check_paid_amt = $check_paid_amt + $orderpayment[$i]->payment_amount;
                }else{
                  $check_refund_amt = $check_refund_amt + $orderpayment[$i]->payment_amount;
                }
              }
              $trans_amt = $check_paid_amt-$check_refund_amt;
              //echo $orders->grand_total."==".$check_paid_amt;
              if($orders->grand_total == $trans_amt){

              }elseif($orders->grand_total < $trans_amt){
                $max_refund = $check_paid_amt-$orders->grand_total-$check_refund_amt;
                //echo $max_refund;
              ?>
              <button type="button" class="btn-sm btn btn-danger pull-right" data-original-title="Edit" data-toggle="modal" data-target="#refundpaymentModal">Refund</button>
              <?php
              }else{
              ?>
              <button type="button" class="btn-sm btnbtn-sm btn btn-primary pull-right" data-original-title="Edit" data-toggle="modal" data-target="#addpaymentModal">Add</button>
              <?php
              }
            ?>
          <?php } ?>
        </div>
      </div>

      <?php if(count($orderpayment)>=1){ ?>
      <div class="table-responsive">
     <table id="" class="table jambo_table bulk_action">
           <thead>
               <tr>
                   <th>Sr No</th>
                   <th>Type</th>
                   <th>Details</th>
                   <th>Payment Status</th>
                   <th>Amount</th>
                   <th>Date</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>
             <?php

                for($i=0,$j=1;$i<count($orderpayment);$i++,$j++){
                  if($orderpayment[$i]->payment_status=="Paid"){
                    $paid_amt = $paid_amt + $orderpayment[$i]->payment_amount;
                  }
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
                   <td>
                    <?php if($orders->order_status!="Canceled"){ ?>
                     <?php
                     if(Auth::user()->role_id==1){
                    ?>
                    <?php if($orders->order_status=="Accepted"){ ?>
                     <button type="button" class="btn-sm btn btn-warning" data-original-title="Edit" data-toggle="modal" data-target="#editModal{{$j}}">Edit</button>
                    <?php } ?>

                     <div class="modal fade" id="editModal{{$j}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog" role="document">
                         <div class="modal-content">
                           <div class="modal-header">
                             <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                             </button>
                           </div>
                           <?php $edit_url = url('/orderpaidedit')."/".$orderpayment[$i]->id; ?>
                     			<form action="<?php echo $edit_url; ?>" method="post" id="editform">
                            <style>
                            .radio > label {
                            	display: inline-block;
                            	margin-bottom: .5rem;
                            	position: relative;
                            	margin-right: 10px;
                            }
                            .radio > label input.report_date {
                            	position: relative;
                            	display: block;
                            	float: left;
                            	width: auto;
                            	margin-top: -9px;
                            	margin-right: 10px;
                            }
                            .radio > label > span {
                            	float: left;
                            	position: relative;
                            	display: inline-block;
                            	width: auto;
                            }
                            </style>
                           <div class="modal-body">
                     				{{ csrf_field() }}
                             <input type="hidden" value="{{$orderpayment[$i]->order_id}}" id="order_id" name="order_id" class="form-control required"/>
                               <div class="row">
                                 <div class="col-md-12">
                                   <div class="radio">
                                      <label><input type="radio" <?php if($orderpayment[$i]->payment_type=="Cash"){ echo "checked"; } ?> value="Cash" name="payment_type" class="report_date form-control required"/> <span>Cash</span></label>
                                      <label><input type="radio" <?php if($orderpayment[$i]->payment_type=="Check"){ echo "checked"; } ?> value="Check" name="payment_type" class="report_date form-control required"/>  <span>Check</span></label>
                                      <label><input type="radio" <?php if($orderpayment[$i]->payment_type=="Credit Card"){ echo "checked"; } ?> value="Credit Card" name="payment_type" class="report_date form-control required"/>  <span>Credit Card</span></label>
                                      <label><input type="radio" <?php if($orderpayment[$i]->payment_type=="Paypal"){ echo "checked"; } ?> value="Paypal"  name="payment_type" class="report_date form-control required"/>  <span>Paypal</span></label>
                                   </div>
                      						</div>
                               </div>

                               <div class="row">
                     					 	<div class="col-md-12">
                     							 <div class="form-group">
                     								 {!! Form::label('payment_details','Payment Details') !!}
                     								 <input type="text" value="{{$orderpayment[$i]->payment_details}}" id="payment_details" name="payment_details" class="form-control"/>
                     								 @if ($errors->has('payment_details'))
                     									 <p class='text-red'>{{ $errors->first('payment_details') }}</p>
                     									@endif
                     							 </div>
                     							</div>
                     					</div>
                               <div class="row">
                     					 <div class="col-md-6">
                     						 <div class="form-group">
                     							 {!! Form::label('payment_amount','Amount') !!}
                     							 <input type="number" value="{{$orderpayment[$i]->payment_amount}}" step='0.01' min="1" id="payment_amount" name="payment_amount" class="form-control required"/>
                     							 @if ($errors->has('payment_amount'))
                     								 <p class='text-red'>{{ $errors->first('payment_amount') }}</p>
                     								@endif
                     						 </div>
                     						</div>
                     						<div class="col-md-6">
                     							 <div class="form-group">
                     								 {!! Form::label('payment_date','Payment Date') !!}
                     								 <input type="text" value="<?php echo Carbon\Carbon::parse($orderpayment[$i]->payment_date)->format($theme_data->datetime_format); ?>" id="payment_date" name="payment_date" class="datetimepicker1 form-control"/>
                     								 @if ($errors->has('payment_date'))
                     									 <p class='text-red'>{{ $errors->first('payment_date') }}</p>
                     									@endif
                     							 </div>
                     							</div>
                     					</div>
                               <div class="row">
                     					 <div class="col-md-12">
                     						 <div class="form-group">
                     							 {!! Form::label('notes','Notes') !!}
                                    <textarea value="{{$orderpayment[$i]->notes}}" id="notes" name="notes" class="form-control"></textarea>
                     							 @if ($errors->has('notes'))
                     								 <p class='text-red'>{{ $errors->first('notes') }}</p>
                     								@endif
                     						 </div>
                     						</div>
                     					</div>
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                             <button type="submit" class="btn btn-primary">Edit Payment</button>
                           </div>
                     			</form>
                          <script>
                            $('input[type="radio"]').on('click change', function(e) {
                              if($(this).val()=="Cash"){
                                  $("#payment_details").removeClass('required');
                                }else{
                                  $("#payment_details").addClass('required');
                                }
                            });
                          $(document).ready(function($) {
                            $("#editform").validate({
                              rules: {
                                payment_type:  "required",
                              },
                              messages: {
                                payment_type:  "This field is required",
                              },
                              submitHandler: function(form) {
                                form.submit();
                              }
                            });
                          });
                          </script>
                         </div>
                       </div>
                     </div>
                     <?php if($orders->order_status=="Accepted"){ ?>
                       <a data-type="confirm" href="javascript:void(0);" onclick="showConfirmMessage({{$orderpayment[$i]->id}});" data-toggle="tooltip" data-placement="top" title="" class="btn-sm btn btn-danger" >Delete</a>
                     <?php } ?>
                   <?php
                 }elseif(Auth::user()->role_id==2){

                    $c_date = Carbon\Carbon::parse($orderpayment[$i]->payment_date)->format('Y-m-d');
                    if($c_date==date("Y-m-d")){
                  ?>
                    <?php if($orders->order_status=="Accepted"){ ?>
                      <button type="button" class="btn-sm btn btn-warning" data-original-title="Edit" data-toggle="modal" data-target="#editModal{{$j}}">Edit</button>
                    <?php } ?>
                      <div class="modal fade" id="editModal{{$j}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <?php $edit_url = url('/orderpaidedit')."/".$orderpayment[$i]->id; ?>
                           <form action="<?php echo $edit_url; ?>" method="post" id="editform">
                             <style>
                             .radio > label {
                               display: inline-block;
                               margin-bottom: .5rem;
                               position: relative;
                               margin-right: 10px;
                             }
                             .radio > label input.report_date {
                               position: relative;
                               display: block;
                               float: left;
                               width: auto;
                               margin-top: -9px;
                               margin-right: 10px;
                             }
                             .radio > label > span {
                               float: left;
                               position: relative;
                               display: inline-block;
                               width: auto;
                             }
                             </style>
                            <div class="modal-body">
                             {{ csrf_field() }}
                              <input type="hidden" value="{{$orderpayment[$i]->order_id}}" id="order_id" name="order_id" class="form-control required"/>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="radio">
                                       <label><input type="radio" <?php if($orderpayment[$i]->payment_type=="Cash"){ echo "checked"; } ?> value="Cash" name="payment_type" class="report_date form-control required"/> <span>Cash</span></label>
                                       <label><input type="radio" <?php if($orderpayment[$i]->payment_type=="Check"){ echo "checked"; } ?> value="Check" name="payment_type" class="report_date form-control required"/>  <span>Check</span></label>
                                       <label><input type="radio" <?php if($orderpayment[$i]->payment_type=="Credit Card"){ echo "checked"; } ?> value="Credit Card" name="payment_type" class="report_date form-control required"/>  <span>Credit Card</span></label>
                                       <label><input type="radio" <?php if($orderpayment[$i]->payment_type=="Paypal"){ echo "checked"; } ?> value="Paypal"  name="payment_type" class="report_date form-control required"/>  <span>Paypal</span></label>
                                    </div>
                                   </div>
                                </div>

                                <div class="row">
                                 <div class="col-md-12">
                                    <div class="form-group">
                                      {!! Form::label('payment_details','Payment Details') !!}
                                      <input type="text" value="{{$orderpayment[$i]->payment_details}}" id="payment_details" name="payment_details" class="form-control"/>
                                      @if ($errors->has('payment_details'))
                                        <p class='text-red'>{{ $errors->first('payment_details') }}</p>
                                       @endif
                                    </div>
                                   </div>
                               </div>
                                <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    {!! Form::label('payment_amount','Amount') !!}
                                    <input type="number" value="{{$orderpayment[$i]->payment_amount}}" step='0.01' min="1" id="payment_amount" name="payment_amount" class="form-control required"/>
                                    @if ($errors->has('payment_amount'))
                                      <p class='text-red'>{{ $errors->first('payment_amount') }}</p>
                                     @endif
                                  </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                      {!! Form::label('payment_date','Payment Date') !!}
                                      <input type="text" value="<?php echo Carbon\Carbon::parse($orderpayment[$i]->payment_date)->format($theme_data->datetime_format); ?>" id="payment_date" name="payment_date" class="datetimepicker1 form-control"/>
                                      @if ($errors->has('payment_date'))
                                        <p class='text-red'>{{ $errors->first('payment_date') }}</p>
                                       @endif
                                    </div>
                                   </div>
                               </div>
                                <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    {!! Form::label('notes','Notes') !!}
                                     <textarea value="{{$orderpayment[$i]->notes}}" id="notes" name="notes" class="form-control"></textarea>
                                    @if ($errors->has('notes'))
                                      <p class='text-red'>{{ $errors->first('notes') }}</p>
                                     @endif
                                  </div>
                                 </div>
                               </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Edit Payment</button>
                            </div>
                           </form>
                           <script>
                             $('input[type="radio"]').on('click change', function(e) {
                               if($(this).val()=="Cash"){
                                   $("#payment_details").removeClass('required');
                                 }else{
                                   $("#payment_details").addClass('required');
                                 }
                             });
                           $(document).ready(function($) {
                             $("#editform").validate({
                               rules: {
                                 payment_type:  "required",
                               },
                               messages: {
                                 payment_type:  "This field is required",
                               },
                               submitHandler: function(form) {
                                 form.submit();
                               }
                             });
                           });
                           </script>
                          </div>
                        </div>
                      </div>
                      <?php if($orders->order_status=="Accepted"){ ?>
                        <a data-type="confirm" href="javascript:void(0);" onclick="showConfirmMessage({{$orderpayment[$i]->id}});" data-toggle="tooltip" data-placement="top" title="" class="btn-sm btn btn-danger" >Delete</a>
                      <?php } ?>
                    </td>
                <?php
                    }
                 }else{

                 }
                  ?>
              <?php } //if not Canceled  ?>
                </td>
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

<!-- Add Payment Model -->
<?php $remaining_amount = $orders->grand_total - $paid_amt; ?>
<div class="modal fade" id="addpaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $addpayment_url = url('/orderpaidadd'); ?>
     <form action="<?php echo $addpayment_url; ?>" method="post" id="addpaymentform">
       <style>
       .radio > label {
         display: inline-block;
         margin-bottom: .5rem;
         position: relative;
         margin-right: 10px;
       }
       .radio > label input.report_date {
         position: relative;
         display: block;
         float: left;
         width: auto;
         margin-top: -9px;
         margin-right: 10px;
       }
       .radio > label > span {
         float: left;
         position: relative;
         display: inline-block;
         width: auto;
       }
       </style>
       <div class="modal-body">
        {{ csrf_field() }}
        <input type="hidden" value="{{$orders->id}}" id="order_id" name="add_order_id" class="form-control required"/>
        <input type="hidden" value="Paid" id="add_payment_status" name="add_payment_status" class="form-control"/>
           <div class="row">
            <div class="col-md-12">
              {!! Form::label('membername','Member Name : ') !!} {{$orders->name}}<br>
               {!! Form::label('grandtotal','Grand Total : ') !!} {{$theme_data->currency}}{{$orders->grand_total}}<br>
               {!! Form::label('grandtotal','Remaining Amount : ') !!} {{$theme_data->currency}}{{$remaining_amount}}<br>
            </div>
          </div>
           <div class="row">
             <div class="col-md-12">
               <div class="radio">
                  <label><input type="radio" value="Cash" name="add_payment_type" class="report_date form-control required"/> <span>Cash</span></label>
                  <label><input type="radio" value="Check" name="add_payment_type" class="report_date form-control required"/>  <span>Check</span></label>
                  <label><input type="radio" value="Credit Card" name="add_payment_type" class="report_date form-control required"/>  <span>Credit Card</span></label>
                  <label><input type="radio" value="Paypal"  name="add_payment_type" class="report_date form-control required"/>  <span>Paypal</span></label>
               </div>

              </div>
           </div>
           <div class="row">
            <div class="col-md-12">
               <div class="form-group">
                 {!! Form::label('payment_details','Payment Details') !!}
                 <input type="text" value="" id="add_payment_details" name="add_payment_details" class="form-control required"/>
                 @if ($errors->has('payment_details'))
                   <p class='text-red'>{{ $errors->first('payment_details') }}</p>
                  @endif
               </div>
              </div>
          </div>
           <div class="row">
           <div class="col-md-6">
             <div class="form-group">
               {!! Form::label('payment_amount','Amount') !!}
               <input type="number" value="{{$remaining_amount}}" step='0.01' min="0" max="{{$remaining_amount}}" id="payment_amount" name="add_payment_amount" class="form-control required"/>
               @if ($errors->has('payment_amount'))
                 <p class='text-red'>{{ $errors->first('payment_amount') }}</p>
                @endif
             </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                 {!! Form::label('payment_date','Payment Date') !!}
                 <input type="text" value="<?php echo date("m/d/Y H:i:s"); ?>" id="payment_date" name="add_payment_date" class="datetimepicker1 form-control"/>
                 @if ($errors->has('payment_date'))
                   <p class='text-red'>{{ $errors->first('payment_date') }}</p>
                  @endif
               </div>
              </div>
          </div>
           <div class="row">
           <div class="col-md-12">
             <div class="form-group">
               {!! Form::label('notes','Notes') !!}
                <textarea value="" id="notes" name="add_notes" class="form-control"></textarea>
               @if ($errors->has('notes'))
                 <p class='text-red'>{{ $errors->first('notes') }}</p>
                @endif
             </div>
            </div>
          </div>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Payment</button>
      </div>
     </form>
     <script>
       $('input[type="radio"]').on('click change', function(e) {
         if($(this).val()=="Cash"){
             $("#add_payment_details").removeClass('required');
           }else{
             $("#add_payment_details").addClass('required');
           }
       });
     $(document).ready(function($) {
       $("#addpaymentform").validate({
         rules: {
           add_payment_type:  "required",
         },
         messages: {
           add_payment_type:  "This field is required",
         },
         submitHandler: function(form) {
           form.submit();
         }
       });
     });
     </script>
    </div>
  </div>
</div>
<!-- //////////////////////////////////////////////////////// -->

<!-- Refund Payment Model -->
<?php $refund_amount = $max_refund; ?>
<div class="modal fade" id="refundpaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Refund Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $refundpayment_url = url('/refundorderpaid'); ?>
      <form action="<?php echo $refundpayment_url; ?>" method="post" id="refundpaymentform" novalidate>
      <div class="modal-body">
        {{ csrf_field() }}
        <input type="hidden" value="{{$orders->id}}" id="refund_order_id" name="refund_order_id" class="form-control required"/>
        <input type="hidden" value="Refund" id="refund_payment_status" name="refund_payment_status" class="form-control required"/>
          <div class="row">
            <div class="col-md-12">
               {!! Form::label('membername','Member Name : ') !!} {{$orders->name}}<br>
               {!! Form::label('grandtotal','Grand Total : ') !!} {{$theme_data->currency}}{{$orders->grand_total}}<br>
               {!! Form::label('grandtotal','Remaining Amount : ') !!} {{$theme_data->currency}}{{$refund_amount}}<br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="radio">
                 <label><input type="radio" value="Cash" checked name="refund_payment_type" class="report_date form-control required"/> <span>Cash</span></label>
                 <label><input type="radio" value="Check" name="refund_payment_type" class="report_date form-control required"/>  <span>Check</span></label>
                 <label><input type="radio" value="Credit Card" name="refund_payment_type" class="report_date form-control required"/>  <span>Credit Card</span></label>
                 <label><input type="radio" value="Paypal"  name="refund_payment_type" class="report_date form-control required"/>  <span>Paypal</span></label>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
               <div class="form-group">
                 {!! Form::label('refund_payment_details','Payment Payer ID') !!}
                 <input type="text" value="" id="refund_payment_details" name="refund_payment_details" class="form-control required"/>
                 @if ($errors->has('refund_payment_details'))
                   <p class='text-red'>{{ $errors->first('refund_payment_details') }}</p>
                  @endif
               </div>
              </div>
          </div>
          <div class="row">
           <div class="col-md-6">
             <div class="form-group">
               {!! Form::label('refund_payment_amount','Amount') !!}
               <input type="number" step='0.01' min="0.1" value="<?php echo $refund_amount;?>" max="<?php echo $refund_amount; ?>" id="refund_payment_amount" name="refund_payment_amount" class="form-control required"/>
               @if ($errors->has('refund_payment_amount'))
                 <p class='text-red'>{{ $errors->first('refund_payment_amount') }}</p>
                @endif
             </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                 {!! Form::label('refund_payment_date','Payment Date') !!}
                 <input type="text" value="<?php echo date("m/d/Y H:i:s"); ?>" id="refund_payment_date" name="refund_payment_date" class="datetimepicker1 form-control"/>
                 @if ($errors->has('refund_payment_date'))
                   <p class='text-red'>{{ $errors->first('refund_payment_date') }}</p>
                  @endif
               </div>
              </div>
          </div>
          <div class="row">
           <div class="col-md-12">
             <div class="form-group">
               {!! Form::label('refund_notes','Notes') !!}
               <textarea value="" id="refund_notes" name="refund_notes" class="form-control"></textarea>
               @if ($errors->has('refund_notes'))
                 <p class='text-red'>{{ $errors->first('refund_notes') }}</p>
                @endif
             </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Refund</button>
      </div>
      <script>
        $(document).ready(function($) {
          $("#refundpaymentform").validate({
            rules: {
              refund_payment_details:  "required",
              refund_payment_amount:  "required",
              refund_payment_date:  "required",
            },
            messages: {
              refund_payment_details:  "This field is required",
              refund_payment_amount:  "This field is required",
              refund_payment_date:  "This field is required",
            },
            submitHandler: function(form) {
              form.submit();
            }
          });
        });
      </script>
      </form>
    </div>
  </div>
</div>

<script>
// Delete Data
// Product - Delete
function ProductshowConfirmMessage(id,order_id) {
	swal({
  title: "Are you sure?",
  text: "Your will not be able to recover this data!",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-danger",
  confirmButtonText: "Yes, Remove it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/deleteorderproduct') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "POST", '_token' : "{{ Session::token() }}",'order_id':order_id},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Deleted!", "Information deleted successfully", "success");
							location.reload();
						}
					},
				});
			}
		});

}

// Payment Details - Delete
function showConfirmMessage(id) {
	swal({
  title: "Are you sure?",
  text: "Your will not be able to recover this data!",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-danger",
  confirmButtonText: "Yes, delete it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/deleteorderpayments') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "POST", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Deleted!", "Information deleted successfully", "success");
							location.reload();
						}
					},
				});
			}
		});
}
</script>
@endsection
