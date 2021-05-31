@extends('front.layout.main')
@section('content')
@php
$theme_settings_data = DB::select('select * from theme_settings where deleted_at is null and id=1');
@endphp
<!-- Page Title -->
<div class="page-title bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-6">
        <h4 class="mb-0 pull-left">Career</h4>
      </div>
      <div class="col-lg-6 col-md-6 col-6">
        <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / Career</p>
      </div>
    </div>
  </div>
</div>

<!-- Section -->
<section class="section page-content">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-12 col-md-12">
        <!-- <h4>Request a Event Consultation</h4>
                <hr class="hr-md"> -->
        {!! Form::open(['route'=>'getcareerinfo','method'=>'POST','role'=>'form','id'=>'careerform','class'=>'form-horizontal']) !!}
        @csrf
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="">
              <div class="form-group {{$errors->has('name')?'has-error':''}}">
                {!! Form::label('name', 'Name *') !!}
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="">
              <div class="form-group {{$errors->has('fname')?'has-error':''}}">
                {!! Form::text('fname',null,['id'=>'fname','class'=>'form-control required','placeholder'=>'First Name']) !!}
                @if ($errors->has('name'))
                <span class="text-danger">{{$errors->first('fname')}}</span>
                @endif
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-6">
            <div class="">
              <div class="form-group {{$errors->has('lname')?'has-error':''}}">
                {!! Form::text('lname',null,['id'=>'lname','class'=>'form-control required','placeholder'=>'Last Name']) !!}
                @if ($errors->has('name'))
                <span class="text-danger">{{$errors->first('lname')}}</span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="">
              <div class="form-group {{$errors->has('phone')?'has-error':''}}">
                {!! Form::label('email', 'Email *') !!}
                {!! Form::text('email',null,['id'=>'email','class'=>'form-control required','placeholder'=>'Email']) !!}
                @if ($errors->has('email'))
                <span class="text-danger">{{$errors->first('email')}}</span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12">
            <div class="">
              <div class="form-group {{$errors->has('phone')?'has-error':''}}">
                {!! Form::label('phone', 'Phone *') !!}
                {!! Form::text('phone',null,['id'=>'phone','class'=>'form-control required','placeholder'=>'Phone','maxlength'=>'15','data-mask'=>'true','data-inputmask'=>'"mask": "(999) 999-9999"']) !!}
                @if ($errors->has('phone'))
                <span class="text-danger">{{$errors->first('phone')}}</span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class=" pt-4 text-center">
              <button type="submit" class="btn btn-outline-secondary btn-sm mt-1"><span>Submit</span></button>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- <div class="col-lg-4 col-md-4">
                <img src="assets\img\logo-horizontal-dark.svg" alt="" class="mb-5" width="130">
                <h4 class="mb-0">Address</h4>
                <span>{{$theme_settings_data[0]->tenant_description}}</span>
                <hr class="hr-md">
                <div class="row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <h6 class="mb-1 text-muted">Phone:</h6>
                        {{$theme_settings_data[0]->front_mobile}}
                    </div>
                    <div class="col-sm-6">
                        <h6 class="mb-1 text-muted">E-mail:</h6>
                        <a href="mailto:{{$theme_settings_data[0]->front_email}}">{{$theme_settings_data[0]->front_email}}</a>
                    </div>
                </div>
                <hr class="hr-md">
            </div> -->
    </div>
  </div>
</section>

@endsection