@extends('front.layout.main')
@section('content')
<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h4 class="mb-0 pull-left">Login</h4>
            </div>
            <div class="col-lg-6 col-md-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / Login</p>
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
      <h4 class="pt-5 pb-5">Login to your account</h4>
      @if(Session::has('message'))
          <div class="alert alert-success text-center" role="alert">
              {{Session::get('message')}}
          </div>
      @endif
      <form action="{{url('/userlogin')}}" method="post" class="form-horizontal">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" required="">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required="">
        </div>
        <div class="form-group">
          <span>
              <input type="checkbox" class="checkbox">
              Keep me signed in
          </span>
        </div>
          <button type="submit" class="btn btn-outline-secondary btn-sm"><span>Login<span></button>
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
