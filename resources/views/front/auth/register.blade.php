@extends('front.layout.main')
@section('content')
<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h4 class="mb-0 pull-left">Register</h4>
            </div>
            <div class="col-lg-6 col-md-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / Register</p>
            </div>
        </div>
    </div>
</div>
<section class="section section-bg-edge">
<div class="container">
<div class="row">
<div class="col-lg-3 col-md-3"></div>
<div class="col-lg-6 col-md-6">
  <div class="login-form"><!--login form-->
      <h4 class="pt-5 pb-5">Register to your account</h4>
      @if(Session::has('message'))
          <div class="alert alert-success text-center" role="alert">
              {{Session::get('message')}}
          </div>
      @endif
      <form action="{{url('/userregister')}}" method="post" class="form-horizontal">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        @if(!empty($name))
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $name }}" required="">
            <span class="text-danger">{{$errors->first('name')}}</span>
        </div>
        @else
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}" required="">
            <span class="text-danger">{{$errors->first('name')}}</span>
        </div>
        @endif

        @if(!empty($email))
        <div class="form-group">
          <label>Email</label>
          <input type="email" placeholder="Email" class="form-control" name="email" value="{{ $email }}"/>
          <span class="text-danger">{{$errors->first('email')}}</span>
        </div>
        @else
        <div class="form-group">
          <label>Email</label>
          <input type="email" placeholder="Email" class="form-control" name="email" value="{{old('email')}}"/>
          <span class="text-danger">{{$errors->first('email')}}</span>
        </div>
        @endif

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password" class="form-control" value="{{old('password')}}" required="">
            <span class="text-danger">{{$errors->first('password')}}</span>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" value="{{old('password_confirmation')}}" required="">
            <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
        </div>
          <button type="submit" class="btn btn-outline-secondary btn-sm"><span>Signup<span></button>
            <br><br> OR <br><br>
            <a href="{{ url('userlogin/facebook') }}" class="btn btn-outline-secondary btn-sm btn-default btn-social-icon btn-facebook"><span><i class="fa fa-facebook"></i> &nbsp;&nbsp; Continue with Facebook</span></a><br><br>
            <a href="{{ url('userlogin/google') }}" class="btn btn-outline-secondary btn-sm btn-default btn-social-icon btn-google"><span><i class="fa fa-google-plus"></i> &nbsp;&nbsp; Continue with Google Plus</span></a>
      </form>
  </div><!--/login form-->
  <div class="social-login mb25 pt-5 pb-5">

  </div>
</div>
<div class="col-lg-3 col-md-3"></div>
</div>
</div>
</section>
@endsection
