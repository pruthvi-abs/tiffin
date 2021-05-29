@extends('admin.layout.dashboard')
@section('content')
<div class="page-title">
		<div class="col-md-9 col-sm-9 form-group pull-right">
			<h3>{{ $action }}</h3>
		</div>
		<div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
			{!! Html::linkRoute('frontslider.index','Back',array(),['class'=>'btn-sm btn bg-maroon margin']) !!}
			</div>
		</div>
</div>

        	<div class="col-md-12">
		                {!! Form::model($frontslider,['route'=>['frontslider.update',$frontslider->id],'method'=>'PUT','role'=>'form','id'=>'formsubmit','files'=>'true']) !!}
										<div class="box-body">
											<div class="row">
 						 					<div class="col-md-6">
 						 		  			<div class="form-group">
 						 							{!! Form::label('title','Title') !!}
 						 		  				{!! Form::text('title',null,['id'=>'title','class'=>'form-control required','autocomplete'=>'off']) !!}
 						 		 					@if ($errors->has('title'))
 						               	<p class='text-red'>{{ $errors->first('title') }}</p>
 						               @endif
 						 		  			</div>
 						 					 </div>
 						 					 <div class="col-md-6">
 						 			  			<div class="form-group">
 						 								{!! Form::label('btntitle','Button Title') !!}
 						 							{!! Form::text('btntitle',null,['id'=>'btntitle','class'=>'form-control required','autocomplete'=>'off']) !!}
 						 			 					@if ($errors->has('btntitle'))
 						                	<p class='text-red'>{{ $errors->first('btntitle') }}</p>
 						                @endif
 						 			  			</div>
 						 						 </div>
 						 				 </div>
 						 				 <div class="row">
 						 						<div class="col-md-12">
 						 							<div class="form-group">
 						 									{!! Form::label('btnlink','Button Link') !!}
 						 								{!! Form::text('btnlink',null,['id'=>'btnlink','class'=>'form-control required','autocomplete'=>'off']) !!}
 						 				 					@if ($errors->has('btnlink'))
 						                  	<p class='text-red'>{{ $errors->first('btnlink') }}</p>
 						                  @endif
 						 							 </div>
 						 						</div>
 						 					</div>
											<div class="row">
											 <div class="col-md-12">
												 <div class="form-group">
														 {!! Form::label('image','Slider Image') !!}
														 @if($frontslider->image!="")
															<input type="file" id="input-file-now-custom-1" name="image" class="dropify" data-default-file="{{ url('/') }}/{{$frontslider->image}}" />
														 @else
															<input type="file" id="input-file-now-custom-1" name="image" class="dropify" data-default-file="{{asset('public/productplaceholder.png')}}" />
														 @endif
													</div>
											 </div>
										 </div>
 						 				 <div class="row">
 						 						<div class="col-md-12">
 						 			  			<div class="form-group">
 						 								{!! Form::label('description','Description') !!}
 						 			  				{!! Form::textarea('description',null,['id'=>'code_preview0','class'=>'form-control required','autocomplete'=>'off','rows'=>'3']) !!}
 						 			 					@if ($errors->has('description'))
 						                	<p class='text-red'>{{ $errors->first('description') }}</p>
 						                @endif
 						 			  			</div>
 						 						 </div>
 						 				 </div>
										</div>
			              <div class="box-footer">
											<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
			                {!! Form::submit('Save',['class'=>'btn-sm btn btn-primary']) !!}
			                {!! Html::linkRoute('frontslider.index','cancel',[],['class'=>'btn-sm btn btn-default']) !!}
			              </div>
			            {!! Form::close() !!}

       		 </div>
<script>
$(document).ready(function(){
 $('#code_preview0').summernote({height: 300});
});
</script>
@endsection
