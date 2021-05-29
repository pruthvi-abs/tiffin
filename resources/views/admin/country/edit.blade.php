@extends('admin.layout.dashboard')
@section('content')
<div class="page-title">
		<div class="col-md-9 col-sm-9 form-group pull-right">
			<h3>{{ $action }}</h3>
		</div>
		<div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
			{!! Html::linkRoute('country.index','Back',array(),['class'=>'btn-sm btn -sm btnbg-purple margin']) !!}
			</div>
		</div>
</div>

        	<div class="col-md-12">
		                {!! Form::model($country,['route'=>['country.update',$country->id],'method'=>'PUT','role'=>'form','id'=>'formsubmit']) !!}
			              <div class="box-body">
			                <div class="row">
												<div class="col-md-6">
 												<div class="form-group">
 													{!! Form::label('country_code','Country Code') !!}
 													{!! Form::text('country_code',$country->country_code,['id'=>'country_code','class'=>'form-control required','autocomplete'=>'off','maxlength'=>2]) !!}
 													@if ($errors->has('country_code'))
 														<p class='text-red'>{{ $errors->first('country_code') }}</p>
 													@endif
 												</div>
 											 </div>
 											 <div class="col-md-6">
 												<div class="form-group">
 													{!! Form::label('country_name','Country Name') !!}
 													{!! Form::text('country_name',$country->country_name,['id'=>'country_name','class'=>'form-control required','autocomplete'=>'off','maxlength'=>100]) !!}
 													@if ($errors->has('country_name'))
 														<p class='text-red'>{{ $errors->first('country_name') }}</p>
 													 @endif
 												</div>
 											 </div>
											 	 </div>
						 				  </div>
			              <div class="box-footer">
											<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
			                {!! Form::submit('Save',['class'=>'btn-sm btn btn-primary']) !!}
			                {!! Html::linkRoute('country.index','cancel',[],['class'=>'btn-sm btn btn-default']) !!}
			              </div>
			            {!! Form::close() !!}

       		 </div>

@endsection
