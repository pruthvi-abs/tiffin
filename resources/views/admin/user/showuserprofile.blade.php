@extends('admin.layout.dashboard')
@section('content')

<div class="page-title">
		<div class="col-md-9 col-sm-9 form-group pull-right">
			<h3>{{ $action }}</h3>
		</div>
		<div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
			
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



			<!-- Main content -->
					<div class="col-md-12">
						<div class="nav-tabs-custom">
							<div class="tab-content">
								<div class="active tab-pane" id="activity">
										{!! Form::model($user,['route'=>['edituserprofile',$user->id],'method'=>'PUT','role'=>'form','id'=>'formsubmit','files'=>'true']) !!}
										@csrf
										{{ Form::hidden('_method', 'GET') }}
								 		<div class="box-body">
											 	<div class="row">
													 <div class="col-md-6">
														 <div class="form-group">
															 {!! Form::label('photo_id','Profile Image') !!}
															  @if(Auth::user()->photo!="")
																 <input type="file" id="input-file-now-custom-1" name="photo_id" class="dropify" data-default-file="{{ url('/') }}/public/userimages/{{$user->photo->file}}" />
							 									@else
							 									 <input type="file" id="input-file-now-custom-1" name="photo_id" class="dropify" data-default-file="{{asset('public/theme/img/placeholder.png')}}" />
																@endif
														 </div>
														</div>
												 		<div class="col-md-6">
															 <div class="form-group">
															 {!! Form::label('name','Name') !!}
															 {!! Form::text('name',null,['id'=>'name','class'=>'form-control required','placeholder'=>'Enter Full Name']) !!}
																@if ($errors->has('name'))
																 <p class='text-red'>{{ $errors->first('name') }}</p>
																@endif
													 		</div>
															<div class="form-group">
 															 {!! Form::label('email','Email') !!}
 								  					 	 {!! Form::text('email',null,['id'=>'email','class'=>'email form-control','readonly'=>'true']) !!}
 								 						   @if ($errors->has('email'))
 	                            	<p class='text-red'>{{ $errors->first('email') }}</p>
 	                        	 	 @endif
 								  				   </div>
														 <div class="form-group">
															 {!! Form::label('mobile','User Mobile Number') !!}
											 				{!! Form::text('mobile',null,['id'=>'mobile','class'=>'form-control required','maxlength'=>15,'data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'true']) !!}
											 				@if ($errors->has('mobile'))
											 					<p class='text-red'>{{ $errors->first('mobile') }}</p>
											 				@endif
														</div>
														</div>
												 			<div class="col-md-6">
												 				<div class="form-group">
												 					{!! Form::label('country','Country') !!}
												 					{!! Form::select('country',$country,null,['class'=>'form-control required','placeholder'=>'Select Country']) !!}
												 					@if ($errors->has('country'))
												 						<p class='text-red'>{{ $errors->first('country') }}</p>
												 					@endif
												 				</div>
												 			 </div>
												 			 <div class="col-md-6">
												  				<div class="form-group">
												  					{!! Form::label('state','State') !!}
												  					{!! Form::text('state',null,['id'=>'state','class'=>'form-control required']) !!}
												  					@if ($errors->has('state'))
												  						<p class='text-red'>{{ $errors->first('state') }}</p>
												  					@endif
												  				</div>
												  			 </div>
												 		 <div class="col-md-6">
												 			<div class="form-group">
												 				{!! Form::label('city','City') !!}
												 				{!! Form::text('city',null,['id'=>'city','class'=>'form-control required']) !!}
												 				@if ($errors->has('city'))
												 					<p class='text-red'>{{ $errors->first('city') }}</p>
												 				@endif
												 			</div>
												 		 </div>
												 			 <div class="col-md-6">
												  				<div class="form-group">
												  					{!! Form::label('pincode','Pincode') !!}
												  					{!! Form::text('pincode',null,['id'=>'pincode','class'=>'form-control required','minlength'=>6,'maxlength'=>6]) !!}
												 					<span id="errmsg"></span>
												  					@if ($errors->has('pincode'))
												  						<p class='text-red'>{{ $errors->first('pincode') }}</p>
												  					@endif
												  				</div>
												  			 </div>
												 		 <div class="col-md-12">
												 			<div class="form-group">
												 				{!! Form::label('address','Address') !!}
												 				{!! Form::textarea('address',null,['id'=>'address','class'=>'form-control required','rows'=>2]) !!}
												 				@if ($errors->has('address'))
												 					<p class='text-red'>{{ $errors->first('address') }}</p>
												 				@endif
												 			</div>
												 		 </div>
												 	</div>
											 	</div>
												<div class="row">
													 <div class="col-md-12">
															<div class="form-group">
												 				{!! Form::submit('Save',['class'=>'btn-sm btn btn-primary']) !!}
															</div>
														</div>
												</div>
								 	{!! Form::close() !!}
									</div>
								</div><!-- /.tab-pane -->
							</div><!-- /.tab-content -->
						</div><!-- /.nav-tabs-custom -->
					</div><!-- /.col -->
</div>

<script>
$("#pincode").keypress(function (e) {
 //if the letter is not digit then display error and don't type anything
 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //display error message
    $("#errmsg").html("Digits Only").show().fadeOut("slow");
           return false;
}
});
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
