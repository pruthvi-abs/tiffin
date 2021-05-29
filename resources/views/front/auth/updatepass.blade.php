@extends('front.layout.main')
@section('content')
<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h4 class="mb-0 pull-left">My Account</h4>
            </div>
            <div class="col-lg-6 col-md-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / My Account</p>
            </div>
        </div>
    </div>
</div>
<section class="section section-bg-edge">
<div class="container">
<div class="row">
<div class="col-lg-3 col-md-3">
  @include('front.includes.usersidebar')
</div>
<div class="col-lg-9 col-md-9">
  <div class="login-form pb-5"><!--login form-->
      <h4 class="pt-5 pb-2">Account Profile</h4>
      @if(Session::has('message'))
          <div class="alert alert-success text-center" role="alert">
              {{Session::get('message')}}
          </div>
      @endif
      <form action="{{url('/update-password',$user_login->id)}}" method="post" class="form-horizontal">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          {{method_field('PUT')}}
          <div class="row">
          <div class="col-md-12 col-sm-12">
          <div class="form-group {{$errors->has('password')?'has-error':''}}">
              <input type="password" class="form-control" name="password" id="password" placeholder="Old Password">
              <span style="position: absolute;right:25px;top:15px;" onclick="hideshow()" >
                  <i id="slash" style="display:none;" class="fa fa-eye-slash"></i>
                  <i id="eye" class="fa fa-eye"></i>
              </span>
              @if(Session::has('oldpassword'))
                  <span class="text-danger">{{Session::get('oldpassword')}}</span>
              @endif
          </div>
          </div>
          <div class="col-md-12 col-sm-12">
          <div class="form-group {{$errors->has('newPassword')?'has-error':''}}">
              <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New Password">
              <span style="position: absolute;right:25px;top:15px;" onclick="hideshow1()" >
                  <i id="slash1" style="display:none;" class="fa fa-eye-slash"></i>
                  <i id="eye1" class="fa fa-eye"></i>
              </span>
              <span class="text-danger">{{$errors->first('newPassword')}}</span>
          </div>
          </div>
          <div class="col-md-12 col-sm-12">
          <div class="form-group {{$errors->has('newPassword_confirmation')?'has-error':''}}">
              <input type="password" class="form-control" name="newPassword_confirmation" id="newPassword_confirmation" placeholder="Confirm Password">
              <span style="position: absolute;right:25px;top:15px;" onclick="hideshow2()" >
                  <i id="slash2" style="display:none;" class="fa fa-eye-slash"></i>
                  <i id="eye2" class="fa fa-eye"></i>
              </span>
              <span class="text-danger">{{$errors->first('newPassword_confirmation')}}</span>
          </div>
          </div>
          <div class="col-md-12 col-sm-12">
          <button type="submit" class="btn btn-outline-secondary btn-sm"><span>Update Password<span></button>
          </div>
          </div>
      </form>
  </div><!--/login form-->
</div>
</div>
</div>
</section>

<script>
function hideshow(){
	var password = document.getElementById("password");
	var slash = document.getElementById("slash");
	var eye = document.getElementById("eye");

	if(password.type === 'password'){
		password.type = "text";
		slash.style.display = "block";
		eye.style.display = "none";
	}else{
		password.type = "password";
		slash.style.display = "none";
		eye.style.display = "block";
	}
}
function hideshow1(){
	var password1 = document.getElementById("newPassword");
	var slash1 = document.getElementById("slash1");
	var eye1 = document.getElementById("eye1");

	if(password1.type === 'password'){
		password1.type = "text";
		slash1.style.display = "block";
		eye1.style.display = "none";
	}else{
		password1.type = "password";
		slash1.style.display = "none";
		eye1.style.display = "block";
	}
}
function hideshow2(){
	var password2 = document.getElementById("newPassword_confirmation");
	var slash2 = document.getElementById("slash2");
	var eye2 = document.getElementById("eye2");

	if(password2.type === 'password'){
		password2.type = "text";
		slash2.style.display = "block";
		eye2.style.display = "none";
	}else{
		password2.type = "password";
		slash2.style.display = "none";
		eye2.style.display = "block";
	}
}
</script>
@endsection
