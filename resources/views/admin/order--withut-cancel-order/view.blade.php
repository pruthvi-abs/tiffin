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
	   	 <strong>Order ID :</strong> {{$orders->id}} <br>
	   	 <strong>Order Status :</strong> {{$orders->order_status}}<br>
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
        <strong>Payment Received :</strong> Unpaid<br>
        <?php } ?>

	  <div class="pb-5 pt-2">
	  <div class="table-responsive">
	  <table id="" class="table jambo_table bulk_action">
	        <thead>
	            <tr>
	                <th>Sr No</th>
	                <th>Name</th>
	                <th>Price</th>
	                <th>Quantity</th>
	                <th>Total</th>
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
																<td>{{$theme_data->currency}}{{$orders->coupon_amount}}</td>
														</tr>
														<tr>
																<td>Total</td>
																<td><span>{{$theme_data->currency}}{{$total_price-$orders->coupon_amount}}</span></td>
														</tr>
													@else
														<tr>
																<td>Total</td>
																<td><span>{{$theme_data->currency}}{{$total_price}}</span></td>
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
     <table id="" class="table jambo_table bulk_action">
           <thead>
               <tr>
                   <th>Sr No</th>
                   <th>Type</th>
                   <th>Details</th>
                   <th>Amount</th>
                   <th>Date</th>
                   <th>Action</th>
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
                   <td>{{$theme_data->currency}}{{$orderpayment[$i]->payment_amount}}</td>
                   <td><?php echo Carbon\Carbon::parse($orderpayment[$i]->payment_date)->format($theme_data->datetime_format); ?></td>
                   <td>
                     <?php
                     if(Auth::user()->role_id==1){
                    ?>
                     <button type="button" class="btn-sm btn btn-warning" data-original-title="Edit" data-toggle="modal" data-target="#editModal{{$j}}">Edit</button>

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
                                    <textarea value="{{$orderpayment[$i]->notes}}" id="notes" name="notes" class="form-control required"></textarea>
                     							 @if ($errors->has('notes'))
                     								 <p class='text-red'>{{ $errors->first('notes') }}</p>
                     								@endif
                     						 </div>
                     						</div>
                     					</div>
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                             <button type="submit" class="btn btn-primary">Payment</button>
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
                     <a data-type="confirm" href="javascript:void(0);" onclick="showConfirmMessage({{$orderpayment[$i]->id}});" data-toggle="tooltip" data-placement="top" title="" class="btn-sm btn btn-danger" data-original-title="Delete">Delete</a>
                   <?php
                 }elseif(Auth::user()->role_id==2){

                    $c_date = Carbon\Carbon::parse($orderpayment[$i]->payment_date)->format('Y-m-d');
                    if($c_date==date("Y-m-d")){
                  ?>
                      <button type="button" class="btn-sm btn btn-warning" data-original-title="Edit" data-toggle="modal" data-target="#editModal{{$j}}">Edit</button>

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
                                     <textarea value="{{$orderpayment[$i]->notes}}" id="notes" name="notes" class="form-control required"></textarea>
                                    @if ($errors->has('notes'))
                                      <p class='text-red'>{{ $errors->first('notes') }}</p>
                                     @endif
                                  </div>
                                 </div>
                               </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Payment</button>
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
                      <a data-type="confirm" href="javascript:void(0);" onclick="showConfirmMessage({{$orderpayment[$i]->id}});" data-toggle="tooltip" data-placement="top" title="" class="btn-sm btn btn-danger" data-original-title="Delete">Delete</a>
                    </td>
                <?php
                    }
                 }else{

                 }
                  ?>
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
<script>
// Delete Data
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
