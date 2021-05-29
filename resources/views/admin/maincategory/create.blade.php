@extends('admin.layout.dashboard')
@section('content')
<div class="page-title">
		<div class="col-md-9 col-sm-9 form-group pull-right">
			<h3>{{ $action }}</h3>
		</div>
		<div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
			{!! Html::linkRoute('maincategory.index','Back',array(),['class'=>'btn-sm btn bg-purple margin']) !!}
			</div>
		</div>
</div>
        	<div class="col-md-12">
			            {!! Form::open(['route'=>'maincategory.store','method'=>'POST','role'=>'form','id'=>'formsubmit']) !!}
			              <div class="box-body">
			                <div class="row">
												<div class="col-md-6">
									  			<div class="form-group">
														{!! Form::label('name','Name') !!}
									  				{!! Form::text('name',null,['id'=>'name','class'=>'form-control required','autocomplete'=>'off']) !!}
									 					@if ($errors->has('name'))
                            	<p class='text-red'>{{ $errors->first('name') }}</p>
                            @endif
									  			</div>
												 </div>
												 <div class="col-md-6">
 									  			<div class="form-group">
 														{!! Form::label('status','Status') !!}
														{!! Form::select('status',['1'=>'Enable','0'=>'Disable'],null,['class'=>'form-control required','placeholder'=>'Select Status']) !!}
 									 					@if ($errors->has('status'))
                             	<p class='text-red'>{{ $errors->first('status') }}</p>
                             @endif
 									  			</div>
 												 </div>
											 </div>
											 <div class="row">
 												<div class="col-md-12">
 									  			<div class="form-group">
 														{!! Form::label('description','Description') !!}
 									  				{!! Form::textarea('description',null,['id'=>'description','class'=>'form-control required','autocomplete'=>'off','rows'=>'3']) !!}
 									 					@if ($errors->has('description'))
                             	<p class='text-red'>{{ $errors->first('description') }}</p>
                             @endif
 									  			</div>
 												 </div>
											 </div>
										 </div>
			              <div class="box-footer">
											<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
											{!! Form::submit('Submit',['class'=>'btn-sm btn btn-primary']) !!}
			                {!! Html::linkRoute('maincategory.index','cancel',[],['class'=>'btn-sm btn btn-default']) !!}
			              </div>
			            {!! Form::close() !!}

       		 </div>

@endsection
