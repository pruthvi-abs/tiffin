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
                <h4 class="mb-0 pull-left">Contact Us</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / Contact Us</p>
            </div>
        </div>
    </div>
</div>

<!-- Section -->
<section class="section page-content">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-8">
                <h4>Request a Event Consultation</h4>
                <hr class="hr-md">
                {!! Form::open(['route'=>'submitgetintouch','method'=>'POST','role'=>'form','id'=>'contactform','class'=>'form-horizontal']) !!}
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="login-form">
                            <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                {!! Form::label('name', 'Name *') !!}
                                {!! Form::text('name',null,['id'=>'name','class'=>'form-control required','placeholder'=>'Name']) !!}
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('email')?'has-error':''}}">
                                {!! Form::label('email', 'Email *') !!}
                                {!! Form::text('email',null,['id'=>'email','class'=>'form-control required','placeholder'=>'Email']) !!}
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('eventdate')?'has-error':''}}">
                                {!! Form::label('eventdate', 'Event Date') !!}
                                {!! Form::text('eventdate',null,['id'=>'eventdate','class'=>'form-control tomorrowdatepicker1','placeholder'=>'Event Date']) !!}
                                @if ($errors->has('eventdate'))
                                    <span class="text-danger">{{$errors->first('eventdate')}}</span>
                                @endif
                            </div>

                        </div>
                        <!--/login form-->
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="signup-form">
                            <!--sign up form-->
                            <div class="form-group {{$errors->has('phone')?'has-error':''}}">
                                {!! Form::label('phone', 'Phone *') !!}
                                {!! Form::text('phone',null,['id'=>'phone','class'=>'form-control required','placeholder'=>'Phone','maxlength'=>'15','data-mask'=>'true','data-inputmask'=>'"mask": "(999) 999-9999"']) !!}
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{$errors->first('phone')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('consultationdate')?'has-error':''}}">
                                {!! Form::label('consultationdate', 'Consultation Date *') !!}
                                {!! Form::text('consultationdate',null,['id'=>'consultationdate','class'=>'form-control tomorrowdatepicker1 required','placeholder'=>'Consultation Date']) !!}
                                @if ($errors->has('consultationdate'))
                                    <span class="text-danger">{{$errors->first('consultationdate')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('eventvenue')?'has-error':''}}">
                                {!! Form::label('eventvenue', 'Event Venue') !!}
                                {!! Form::text('eventvenue',null,['id'=>'eventvenue','class'=>'form-control','placeholder'=>'Event Venue']) !!}
                                @if ($errors->has('eventvenue'))
                                    <span class="text-danger">{{$errors->first('eventvenue')}}</span>
                                @endif
                            </div>
                        </div>
                        <!--/sign up form-->
                    </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class=" pt-4 text-center">
                      <button type="submit" class="btn btn-outline-secondary btn-sm mt-1" ><span>Submit</span></button>
                    </div>
                  </div>
              </div>
                {!! Form::close() !!}
            </div>
            <div class="col-lg-4 col-md-4">
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
            </div>
        </div>
    </div>
</section>
<div class="section">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3304.378181926365!2d-84.00195028430771!3d34.085451080596904!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f5940df266ee89%3A0x16f63300abe5e68d!2s2397%20Satellite%20Blvd%2C%20Buford%2C%20GA%2030518%2C%20USA!5e0!3m2!1sen!2sin!4v1613986293488!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>

@endsection