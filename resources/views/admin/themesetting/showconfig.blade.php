@extends('admin.layout.dashboard')
@section('content')
<div class="page-title">
  	<div class="col-md-9 col-sm-9 form-group pull-right">
    	<h3>{{ $action }}</h3>
		</div>
    <div class="col-md-3 col-sm-3 form-group ">

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

                <div class="custform">
										{!! Form::model($systemconfig,['route'=>['editconfig',$systemconfig->id],'method'=>'PATCH','role'=>'form','id'=>'formsubmit','files'=>'true']) !!}
										@csrf
										{{ Form::hidden('_method', 'GET') }}
										<div class="box-body">
											<div class="row">
												<div class="col-md-12">
												 <div class="form-group">
													 {!! Form::label('tenant_title','Tenant Application Name') !!}
													 {!! Form::text('tenant_title',null,['id'=>'tenant_title','class'=>'form-control required']) !!}
													 @if ($errors->has('tenant_title'))
														 <p class='text-red'>{{ $errors->first('tenant_title') }}</p>
													 @endif
												 </div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
															{!! Form::label('tenant_image','Tenant Site Logo') !!}
															@if($systemconfig->tenant_image!="")
															 <input type="file" id="input-file-now-custom-1" name="tenant_image" class="dropify" data-default-file="{{ url('/') }}/public/websitelogo/{{$systemconfig->tenant_image}}" />
															@else
															 <input type="file" id="input-file-now-custom-1" name="tenant_image" class="dropify" data-default-file="{{asset('public/theme/img/placeholder.png')}}" />
															@endif

													 </div>
												</div>
											</div>
                      <div class="row">
												<div class="col-md-12">
													<div class="form-group">
															{!! Form::label('tenant_favicon','Tenant Favicon') !!}
															@if($systemconfig->tenant_favicon!="")
															 <input type="file" id="input-file-now-custom-1" name="tenant_favicon" class="dropify" data-default-file="{{ url('/') }}/public/websitelogo/{{$systemconfig->tenant_favicon}}" />
															@else
															 <input type="file" id="input-file-now-custom-1" name="tenant_favicon" class="dropify" data-default-file="{{asset('public/theme/img/placeholder.png')}}" />
															@endif

													 </div>
												</div>
											</div>
                      <div class="row">
											 <div class="col-md-12">
												 <div class="form-group">
													 {!! Form::label('tenant_description','Address') !!}
													 {!! Form::textarea('tenant_description',null,['id'=>'tenant_description','class'=>'form-control required',"rows"=>"2"]) !!}
													 @if ($errors->has('tenant_description'))
														 <p class='text-red'>{{ $errors->first('tenant_description') }}</p>
													 @endif
												 </div>
												</div>
											</div>
                      <div class="row">
												<div class="col-md-6">
												 <div class="form-group">
													 {!! Form::label('front_email','Front Email') !!}
                           {!! Form::text('front_email',null,['id'=>'email','class'=>'form-control required email']) !!}
													 @if ($errors->has('front_email'))
														 <p class='text-red'>{{ $errors->first('front_email') }}</p>
													 @endif
												 </div>
												</div>
											 <div class="col-md-6">
												 <div class="form-group">
													 {!! Form::label('front_mobile','Front Mobile') !!}
                           {!! Form::text('front_mobile',null,['id'=>'front_mobile','class'=>'form-control required','maxlength'=>15,'data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'true']) !!}
													 @if ($errors->has('front_mobile'))
														 <p class='text-red'>{{ $errors->first('front_mobile') }}</p>
													 @endif
												 </div>
												</div>
											</div>

                      <div class="row">
												<div class="col-md-6">
												 <div class="form-group">
													 {!! Form::label('currency','Select Currency') !!}
                           {!! Form::select('currency',['$'=>'$'],null,['class'=>'form-control required','placeholder'=>'Select Currency']) !!}
													 @if ($errors->has('currency'))
														 <p class='text-red'>{{ $errors->first('currency') }}</p>
													 @endif
												 </div>
												</div>
												<div class="col-md-6">
												 <div class="form-group">
													 {!! Form::label('order_cutoff_time','Order Cut off Time') !!}
                           <input type="text" value="<?php echo $systemconfig->order_cutoff_time;?>" name="order_cutoff_time" class="timepicker2 form-control required"/>
													 @if ($errors->has('order_cutoff_time'))
														 <p class='text-red'>{{ $errors->first('order_cutoff_time') }}</p>
													 @endif
												 </div>
												</div>
											</div>

                      <div class="row">
												<div class="col-md-6">
                          <div class="form-group">
 													 {!! Form::label('pickup_start_time','Pickup Start Time') !!}
                            <input type="text" value="<?php echo $systemconfig->pickup_start_time;?>" name="pickup_start_time" class="timepicker2 form-control required"/>
 													 @if ($errors->has('pickup_start_time'))
 														 <p class='text-red'>{{ $errors->first('pickup_start_time') }}</p>
 													 @endif
 												 </div>
												</div>
												<div class="col-md-6">
												 <div class="form-group">
													 {!! Form::label('pickup_end_time','Pickup End Time') !!}
                           <input type="text" value="<?php echo $systemconfig->pickup_end_time;?>" name="pickup_end_time" class="timepicker2 form-control required"/>
													 @if ($errors->has('pickup_end_time'))
														 <p class='text-red'>{{ $errors->first('pickup_end_time') }}</p>
													 @endif
												 </div>
												</div>
											</div>

                      <div class="row">
												<div class="col-md-6">
                          <div class="form-group">
 													 {!! Form::label('pickup_catering_start_time','Catering - Pickup Start Time') !!}
                            <input type="text" value="<?php echo $systemconfig->pickup_catering_start_time;?>" name="pickup_catering_start_time" class="timepicker2 form-control required"/>
 													 @if ($errors->has('pickup_catering_start_time'))
 														 <p class='text-red'>{{ $errors->first('pickup_catering_start_time') }}</p>
 													 @endif
 												 </div>
												</div>
												<div class="col-md-6">
												 <div class="form-group">
													 {!! Form::label('pickup_catering_end_time','Catering - Pickup End Time') !!}
                           <input type="text" value="<?php echo $systemconfig->pickup_catering_end_time;?>" name="pickup_catering_end_time" class="timepicker2 form-control required"/>
													 @if ($errors->has('pickup_catering_end_time'))
														 <p class='text-red'>{{ $errors->first('pickup_catering_end_time') }}</p>
													 @endif
												 </div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
												 <div class="form-group">
													 {!! Form::label('datetime_format','Date Time Format') !!}
													 {!! Form::select('datetime_format',['m/d/Y H:i:s'=>'m/d/Y H:i:s'],null,['class'=>'form-control required','placeholder'=>'Select Format']) !!}
													 @if ($errors->has('datetime_format'))
														 <p class='text-red'>{{ $errors->first('datetime_format') }}</p>
													 @endif
												 </div>
												</div>
											 <div class="col-md-6">
												 <div class="form-group">
													 {!! Form::label('phone_format','Mobile Format') !!}
													 {!! Form::select('phone_format',['(888) 888-8888'=>'(888) 888-8888'],null,['class'=>'form-control required','placeholder'=>'Select Format']) !!}
													 @if ($errors->has('phone_format'))
														 <p class='text-red'>{{ $errors->first('phone_format') }}</p>
													 @endif
												 </div>
												</div>
											</div>

                      <div class="row">
												<div class="col-md-12">
												 <div class="form-group">
													 {!! Form::label('catering_cancel_cutoff_time','Cancel Order Reasons') !!}
                           {!! Form::number('catering_cancel_cutoff_time',null,['id'=>'catering_cancel_cutoff_time','class'=>'form-control required','min'=>1]) !!}
													 @if ($errors->has('catering_cancel_cutoff_time'))
														 <p class='text-red'>{{ $errors->first('catering_cancel_cutoff_time') }}</p>
													 @endif
												 </div>
												</div>
											</div>
                      <div class="row">
												<div class="col-md-12">
												 <div class="form-group">
													 {!! Form::label('cancel_reasons','Cancel Order Reasons') !!}
                           {!! Form::textarea('cancel_reasons',null,['id'=>'cancel_reasons','class'=>'form-control required',"rows"=>"2"]) !!}
													 @if ($errors->has('cancel_reasons'))
														 <p class='text-red'>{{ $errors->first('cancel_reasons') }}</p>
													 @endif
												 </div>
												</div>
											</div>
											<div class="row">
                        <div class="col-md-6">
													<div class="form-group">
														{!! Form::label('catering_min_date','Catering Product Minimum Day before Order') !!}
														{!! Form::number('catering_min_date',null,['id'=>'catering_min_date','class'=>'form-control required','min'=>1]) !!}
														@if ($errors->has('catering_min_date'))
															<p class='text-red'>{{ $errors->first('catering_min_date') }}</p>
														@endif
													</div>
												 </div>
												<div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_website_name','SMTP Website Name') !!}
														{!! Form::text('smtp_website_name',null,['id'=>'smtp_website_name','class'=>'form-control required']) !!}
														@if ($errors->has('smtp_website_name'))
															<p class='text-red'>{{ $errors->first('smtp_website_name') }}</p>
														@endif
													</div>
												 </div>
                       </div>
                       <div class="row">
												 <div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_server','SMTP Server') !!}
														{!! Form::text('smtp_server',null,['id'=>'smtp_server','class'=>'form-control required']) !!}
														@if ($errors->has('smtp_server'))
															<p class='text-red'>{{ $errors->first('smtp_server') }}</p>
														@endif
													</div>
												 </div>
											 	<div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_port','SMTP Port') !!}
														{!! Form::text('smtp_port',null,['id'=>'smtp_port','class'=>'form-control required']) !!}
														@if ($errors->has('smtp_port'))
															<p class='text-red'>{{ $errors->first('smtp_port') }}</p>
														@endif
													</div>
												 </div>
                       </div>
                       <div class="row">
												 <div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_email','SMTP Email') !!}
														{!! Form::text('smtp_email',null,['id'=>'smtp_server','class'=>'form-control required email']) !!}
														@if ($errors->has('smtp_email'))
															<p class='text-red'>{{ $errors->first('smtp_email') }}</p>
														@endif
													</div>
												 </div>
											 	<div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_email_pass','SMTP Password') !!}
														<input type="password" name="smtp_email_pass" class="form-control required" id="password" value="{{$systemconfig->smtp_email_pass}}" />
														<span style="position: absolute;right:15px;top:35px;" onclick="hideshow()" >
									 					 <i id="slash" style="display:none;" class="fa fa-eye-slash"></i>
									 					 <i id="eye" class="fa fa-eye"></i>
									 				 </span>
														@if ($errors->has('smtp_email_pass'))
															<p class='text-red'>{{ $errors->first('smtp_email_pass') }}</p>
														@endif
													</div>
												 </div>
                       </div>
                       <div class="row">
												 <div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_from_name','SMTP From Name') !!}
														{!! Form::text('smtp_from_name',null,['id'=>'smtp_from_name','class'=>'form-control required']) !!}
														@if ($errors->has('smtp_from_name'))
															<p class='text-red'>{{ $errors->first('smtp_from_name') }}</p>
														@endif
													</div>
												 </div>
											 	<div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_from_email','SMTP From Email') !!}
														{!! Form::text('smtp_from_email',null,['id'=>'smtp_from_email','class'=>'form-control required email']) !!}
														@if ($errors->has('smtp_from_email'))
															<p class='text-red'>{{ $errors->first('smtp_from_email') }}</p>
														@endif
													</div>
												 </div>
                       </div>
                       <div class="row">
												 <div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_transport_exp',' SMTP Driver') !!}
														{!! Form::text('smtp_transport_exp',null,['id'=>'smtp_transport_exp','class'=>'form-control required']) !!}
														@if ($errors->has('smtp_transport_exp'))
															<p class='text-red'>{{ $errors->first('smtp_transport_exp') }}</p>
														@endif
													</div>
												 </div>
											 	<div class="col-md-6">
													<div class="form-group">
														{!! Form::label('smtp_encryption','SMTP Encryption') !!}
														{!! Form::select('smtp_encryption',['ssl'=>'ssl','tls'=>'tls'],null,['class'=>'form-control required','placeholder'=>'Select SMTP Encryption']) !!}
														@if ($errors->has('smtp_encryption'))
															<p class='text-red'>{{ $errors->first('smtp_encryption') }}</p>
														@endif
													</div>
												 </div>
                       </div>
											 </div>
										 </div>
			              <div class="box-footer">
			                {!! Form::submit('Save',['class'=>'btn-sm btn btn-primary']) !!}
											{!! Html::linkRoute('testmail','Send Test Mail',array(),['class'=>'btn-sm btn bg-purple margin','files'=>'true']) !!}
			              </div>

			            {!! Form::close() !!}
                </div>
		          </div>

<script>

function hideshow(){
	var password = document.getElementById("password");
	var slash = document.getElementById("slash");
	var eye = document.getElementById("eye");

	if(password.type === 'password'){
		password.type = "text";
		slash.style.display = "block";
		eye.style.display = "none";
	}else{
		password.type = "password";
		slash.style.display = "none";
		eye.style.display = "block";
	}
}
</script>
@endsection
