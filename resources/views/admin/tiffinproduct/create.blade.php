@extends('admin.layout.dashboard')
@section('content')
<div class="page-title">
		<div class="col-md-9 col-sm-9 form-group pull-right">
			<h3>{{ $action }}</h3>
		</div>
		<div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
			{!! Html::linkRoute('tiffinproduct.index','Back',array(),['class'=>'btn-sm btn bg-purple margin']) !!}
			</div>
		</div>
</div>
        	<div class="col-md-12">
			            {!! Form::open(['route'=>'tiffinproduct.store','method'=>'POST','role'=>'form','id'=>'formsubmit','files'=>'true']) !!}
			              <div class="box-body">
											<div class="row">
												<div class="col-md-6">
												<div class="form-group">
													{!! Form::label('tiffin_preparation_date','Tiffin Date') !!}
													<input type="text" value="{{$lastproducts->tiffin_preparation_date}}" name="tiffin_preparation_date" class="datepicker1 form-control required"/>
													@if ($errors->has('tiffin_preparation_date'))
														<p class='text-red'>{{ $errors->first('tiffin_preparation_date') }}</p>
													@endif
												</div>
											 </div>
											 <div class="col-md-6">
 											 <div class="form-group">
 												 {!! Form::label('is_visible','Visibility') !!}
 												 {!! Form::select('is_visible',['yes'=>'Yes','no'=>'No'],$lastproducts->is_visible,['class'=>'form-control required','placeholder'=>'Select Option']) !!}
 												 @if ($errors->has('is_visible'))
 													 <p class='text-red'>{{ $errors->first('is_visible') }}</p>
 												 @endif
 											 </div>
 											</div>
										 </div>
										 <div class="row">
												<div class="col-md-12">
													<div class="form-group">
														{!! Form::label('description','Descriptions') !!}
														{!! Form::textarea('description',null,['id'=>'code_preview0','class'=>'form-control required','autocomplete'=>'off','rows'=>'3']) !!}
 									 					@if ($errors->has('description'))
                             	<p class='text-red'>{{ $errors->first('description') }}</p>
                             @endif
													</div>
												 </div>
										 </div>
										 <div class="row">
											 <div class="col-md-6">
												<div class="form-group">
													{!! Form::label('price','Price') !!}
													{!! Form::text('price',$lastproducts->price,['id'=>'price','class'=>'form-control required','autocomplete'=>'off']) !!}
													@if ($errors->has('price'))
														<p class='text-red'>{{ $errors->first('price') }}</p>
													 @endif
												</div>
											 </div>
											<div class="col-md-6">
												<div class="form-group">
													{!! Form::label('categories_id','Category') !!}
													{!! Form::select('categories_id',$category,$lastproducts->categories_id,['class'=>'form-control required','placeholder'=>'Select Category']) !!}
													@if ($errors->has('categories_id'))
														<p class='text-red'>{{ $errors->first('categories_id') }}</p>
													 @endif
												</div>
											 </div>
										 </div>



										 <?php
										 /*
											<div class="row">
												<div class="col-md-6">
									  			<div class="form-group">
														{!! Form::label('p_name','Product Name') !!}
									  				{!! Form::text('p_name',null,['id'=>'p_name','class'=>'form-control required','autocomplete'=>'off']) !!}
									 					@if ($errors->has('p_name'))
                            	<p class='text-red'>{{ $errors->first('p_name') }}</p>
                            @endif
									  			</div>
												 </div>
												 <div class="col-md-6">
 									  			<div class="form-group">
 														{!! Form::label('p_code','Product Code') !!}
														{!! Form::text('p_code',null,['id'=>'p_code','class'=>'form-control required','autocomplete'=>'off']) !!}
 									 					@if ($errors->has('p_code'))
                             	<p class='text-red'>{{ $errors->first('p_code') }}</p>
                             @endif
 									  			</div>
 												 </div>
											 </div>

											 <div class="row">
 												<div class="col-md-12">
 													<div class="form-group">
 															{!! Form::label('image','Product Image') !!}
															<input type="file" id="input-file-now-custom-1" name="product_image" class="dropify" data-default-file="" />
 													 </div>
 												</div>
 											</div>

											 <div class="row">
 												<div class="col-md-12">
 									  			<div class="form-group">
 														{!! Form::label('description','Descriptions') !!}
 									  				{!! Form::textarea('description',null,['id'=>'description','class'=>'form-control required','autocomplete'=>'off','rows'=>'3']) !!}
 									 					@if ($errors->has('description'))
                             	<p class='text-red'>{{ $errors->first('description') }}</p>
                             @endif
 									  			</div>
 												 </div>
											 </div>
											*/
											?>
										 </div>
			              <div class="box-footer">
											<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
											{!! Form::submit('Submit',['class'=>'btn-sm btn btn-primary']) !!}
			                {!! Html::linkRoute('tiffinproduct.index','cancel',[],['class'=>'btn-sm btn btn-default']) !!}
			              </div>
			            {!! Form::close() !!}

       		 </div>
 <script>
 $(document).ready(function(){
   $('#code_preview0').summernote({height: 300});
 });
 </script>
@endsection
