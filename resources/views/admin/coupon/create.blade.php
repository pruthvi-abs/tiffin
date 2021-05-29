@extends('admin.layout.dashboard')
@section('content')
<div class="page-title">
		<div class="col-md-9 col-sm-9 form-group pull-right">
			<h3>{{ $action }}</h3>
		</div>
		<div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
			{!! Html::linkRoute('coupon.index','Back',array(),['class'=>'btn-sm btn bg-purple margin']) !!}
			</div>
		</div>
</div>
        	<div class="col-md-12">
			            {!! Form::open(['route'=>'coupon.store','method'=>'POST','role'=>'form','id'=>'formsubmit']) !!}
			              <div class="box-body">
			                <div class="row">
												<div class="col-md-6">
									  			<div class="form-group">
														{!! Form::label('coupon_code','Coupon Code') !!}
									  				{!! Form::text('coupon_code',null,['id'=>'coupon_code','class'=>'form-control required','autocomplete'=>'off']) !!}
														@if ($errors->has('coupon_code'))
                            	<p class='text-red'>{{ $errors->first('coupon_code') }}</p>
                            @endif
									  			</div>
												 </div>
												 <div class="col-md-6">
 									  			<div class="form-group">
 														{!! Form::label('amount_type','Type') !!}
														{!! Form::select('amount_type',['Fixed'=>'Fixed','%'=>'%'],null,['class'=>'form-control required','placeholder'=>'Select Type']) !!}
 									 					@if ($errors->has('amount_type'))
                             	<p class='text-red'>{{ $errors->first('amount_type') }}</p>
                             @endif
 									  			</div>
 												 </div>
											 </div>
											 <div class="row">
 												<div class="col-md-6">
 									  			<div class="form-group">
 														{!! Form::label('amount','Price') !!}
 									  				{!! Form::text('amount',null,['id'=>'amount','class'=>'form-control numbersOnly required','autocomplete'=>'off']) !!}
 														@if ($errors->has('amount'))
                             	<p class='text-red'>{{ $errors->first('amount') }}</p>
                             @endif
 									  			</div>
 												 </div>
 												 <div class="col-md-6">
  									  			<div class="form-group">
  														{!! Form::label('expiry_date','Expiry Date') !!}
															<input type="text" value="" name="expiry_date" class="datepicker1 form-control required"/>
  									 					@if ($errors->has('expiry_date'))
                              	<p class='text-red'>{{ $errors->first('expiry_date') }}</p>
                              @endif
  									  			</div>
  												 </div>
 											 </div>
										 <div class="row">
											 	<div class="col-md-6">
											 	<div class="form-group">
												 {!! Form::label('min_amount','Minimum Cart Amount') !!}
												 {!! Form::text('min_amount',null,['id'=>'min_amount','class'=>'form-control numbersOnly required','autocomplete'=>'off']) !!}
												 @if ($errors->has('min_amount'))
													 <p class='text-red'>{{ $errors->first('min_amount') }}</p>
													@endif
											 	</div>
										 		</div>
												<div class="col-md-6">
												<div class="form-group">
													{!! Form::label('status','Select Status') !!}
													{!! Form::select('status',['1'=>'Enable','0'=>'Disable'],null,['class'=>'form-control required','placeholder'=>'Select Status']) !!}
													@if ($errors->has('status'))
														<p class='text-red'>{{ $errors->first('status') }}</p>
													@endif
												</div>
											 </div>
										 </div>
										</div>
			              <div class="box-footer">
											<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
											{!! Form::submit('Submit',['class'=>'btn-sm btn btn-primary']) !!}
			                {!! Html::linkRoute('coupon.index','cancel',[],['class'=>'btn-sm btn btn-default']) !!}
			              </div>
			            {!! Form::close() !!}
       		 </div>
<script>
$(document).ready(function(){
$('.numbersOnly').keyup(function () {
this.value = this.value.replace(/[^0-9\.]/g,'');
});
});
</script>
@endsection
