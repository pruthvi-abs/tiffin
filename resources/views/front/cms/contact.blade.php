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
            <h4> Request a Event Consultation</h4>
              <hr>
            <!-- Form -->
            <form action="{{url('/submitgetintouch')}}" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="row">
                {{-- <div class="col-lg-6 col-md-6">
                    <div class="login-form"><!--login form-->
                        <div class="form-group {{$errors->has('name')?'has-error':''}}">
                            <lable>Name *</lable>
                            <input type="text" class="form-control" name="name" id="name" value="" required placeholder="Name">
                            <span class="text-danger">{{$errors->first('name')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('email')?'has-error':''}}">
                            <lable>Email *</lable>
                            <input type="text" class="form-control" value="" name="email" required id="email" placeholder="Email">
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('eventdate')?'has-error':''}}">
                            <lable>Event Date</lable>
                            <input type="text" class="form-control tomorrowdatepicker1" value="" name="eventdate" id="eventdate" placeholder="Event Date">
                            <span class="text-danger">{{$errors->first('eventdate')}}</span>
                        </div>

                    </div><!--/login form-->
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="signup-form"><!--sign up form-->
                        <div class="form-group {{$errors->has('phone')?'has-error':''}}">
                            <lable>Phone *</lable>
                            <input type="text" class="form-control required" name="phone" id="phone" value="" maxlength="15" data-mask="true" data-inputmask='"mask": "(999) 999-9999"' required placeholder="Phone">
                            <span class="text-danger">{{$errors->first('phone')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('consultationdate')?'has-error':''}}">
                            <lable>Consultation Date *</lable>
                            <input type="text" class="form-control tomorrowdatepicker1" value="" name="consultationdate" required id="consultationdate" placeholder="Consultation Date">
                            <span class="text-danger">{{$errors->first('consultationdate')}}</span>
                        </div>
                        <div class="form-group {{$errors->has('eventvenue')?'has-error':''}}">
                            <lable>Event Venue</lable>
                            <input type="text" class="form-control" value="" name="eventvenue" id="eventvenue" placeholder="Event Venue">
                            <span class="text-danger">{{$errors->first('eventvenue')}}</span>
                        </div>
                    </div><!--/sign up form-->
                </div> --}}
                <div class="col-lg-12 col-md-12">
                    <div class="row"><!--login form-->
                        <div class="form-group col-lg-6 col-md-6 {{$errors->has('name')?'has-error':''}}">
                            <lable>Name *</lable>
                            <input type="text" class="form-control" name="name" id="name" value="" required placeholder="Name">
                            <span class="text-danger">{{$errors->first('name')}}</span>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 {{$errors->has('email')?'has-error':''}}">
                            <lable>Phone *</lable>
                            <input type="text" class="form-control required" name="phone" id="phone" value="" maxlength="15" data-mask="true" data-inputmask='"mask": "(999) 999-9999"' required placeholder="Phone">
                            <span class="text-danger">{{$errors->first('phone')}}</span>
                        </div>
                    </div><!--/login form-->
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="row"><!--login form-->
                        <div class="form-group col-lg-6 col-md-6 {{$errors->has('name')?'has-error':''}}">
                            <lable>Email *</lable>
                            <input type="text" class="form-control" value="" name="email" required id="email" placeholder="Email">
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 {{$errors->has('email')?'has-error':''}}">
                            <lable>Consultation Date *</lable>
                            <input type="text" class="form-control tomorrowdatepicker1" value="" name="consultationdate" required id="consultationdate" placeholder="Consultation Date">
                            <span class="text-danger">{{$errors->first('consultationdate')}}</span>
                        </div>
                    </div><!--/login form-->
                </div>
                
                <div class="col-lg-12 col-md-12">
                    <div class="row"><!--login form-->
                        <div class="form-group col-lg-6 col-md-6 {{$errors->has('name')?'has-error':''}}">
                            <lable>Event Date</lable>
                            <input type="text" class="form-control tomorrowdatepicker1" value="" name="eventdate" id="eventdate" placeholder="Event Date">
                            <span class="text-danger">{{$errors->first('eventdate')}}</span>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 {{$errors->has('email')?'has-error':''}}">
                            <lable>Event Venue</lable>
                            <input type="text" class="form-control" value="" name="eventvenue" id="eventvenue" placeholder="Event Venue">
                            <span class="text-danger">{{$errors->first('eventvenue')}}</span>
                        </div>
                    </div><!--/login form-->
                </div>
              </div>
              <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class=" pt-4 text-center">
                      <button type="submit" class="btn btn-outline-secondary btn-sm mt-1" ><span>Submit</span></button>
                    </div>
                  </div>
              </div>
                <!--<button type="submit" class=""><span>Apply</span></button>-->
            </form>
            <!-- Form -->

            </div>


          <div class="col-lg-4 col-md-4">
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

<section class="section">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3304.378181926365!2d-84.00195028430771!3d34.085451080596904!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f5940df266ee89%3A0x16f63300abe5e68d!2s2397%20Satellite%20Blvd%2C%20Buford%2C%20GA%2030518%2C%20USA!5e0!3m2!1sen!2sin!4v1613986293488!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
</section>

@endsection
