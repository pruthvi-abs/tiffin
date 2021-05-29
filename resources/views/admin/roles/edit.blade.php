@extends('admin.layout.dashboard')
@section('content')
<div class="page-title">
		<div class="col-md-9 col-sm-9 form-group pull-right">
			<h3>{{ $action }}</h3>
		</div>
		<div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
			{!! Html::linkRoute('roles.index','Back',array(),['class'=>'btn-sm btn bg-purple margin']) !!}
			</div>
		</div>
</div>

        	<div class="col-md-12">
		                {!! Form::model($role,['route'=>['roles.update',$role->id],'method'=>'PUT','role'=>'form','id'=>'formsubmit']) !!}
			              <div class="box-body">
			                <div class="row">
											 <div class="col-md-6">
												  <div class="form-group">
														{!! Form::label('name','Role') !!}
												  	{!! Form::text('name',$role->name,['id'=>'role','class'=>'form-control','autocomplete'=>'off','maxlength'=>191]) !!}
												 		@if ($errors->has('name'))
			                       	<p class='text-red'>{{ $errors->first('name') }}</p>
			                      @endif
												   </div>
											  	</div>
											 	 </div>
						 				  </div>
			              <div class="box-footer">
											<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
			                {!! Form::submit('Save',['class'=>'btn-sm btn btn-primary']) !!}
			                {!! Html::linkRoute('roles.index','cancel',[],['class'=>'btn-sm btn btn-default']) !!}
			              </div>
			            {!! Form::close() !!}

       		 </div>

@endsection
