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
      <form action="{{url('/update-profile',$user_login->id)}}" method="post" class="form-horizontal">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          {{method_field('PUT')}}
          <div class="form-group {{$errors->has('name')?'has-error':''}}">
              <input type="text" class="form-control" name="name" id="name" value="{{$user_login->name}}" placeholder="Name" required>
              <span class="text-danger">{{$errors->first('name')}}</span>
          </div>
          <div class="form-group {{$errors->has('address')?'has-error':''}}">
              <input type="text" class="form-control" value="{{$user_login->address}}" name="address" id="address" placeholder="Address" required>
              <span class="text-danger">{{$errors->first('address')}}</span>
          </div>
          <div class="form-group {{$errors->has('city')?'has-error':''}}">
              <input type="text" class="form-control" name="city" value="{{$user_login->city}}" id="city" placeholder="City" required>
              <span class="text-danger">{{$errors->first('city')}}</span>
          </div>
          <div class="form-group {{$errors->has('state')?'has-error':''}}">
              <input type="text" class="form-control" name="state" value="{{$user_login->state}}" id="state" placeholder="State" required>
              <span class="text-danger">{{$errors->first('state')}}</span>
          </div>
          <div class="form-group">
              <select name="country" id="country" class="form-control" required>
                  @foreach($countries as $country)
                      <option value="{{$country->country_name}}" {{$user_login->country==$country->country_name?' selected':''}}>{{$country->country_name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group {{$errors->has('pincode')?'has-error':''}}">
            <input type="text" class="form-control required" name="pincode" value="{{$user_login->pincode}}" id="pincode" placeholder="Pincode" minlength="6" maxlength="6" required>
            <span class="text-danger">{{$errors->first('pincode')}}</span>
          </div>
          <div class="form-group {{$errors->has('mobile')?'has-error':''}}">
              <input type="text" class="form-control required" name="mobile" value="{{$user_login->mobile}}" id="mobile" placeholder="Mobile" maxlength="15" data-mask="true" data-inputmask='"mask": "(999) 999-9999"' required>
              <span class="text-danger">{{$errors->first('mobile')}}</span>
          </div>
          <button type="submit" class="btn btn-outline-secondary btn-sm"><span>Update Profile<span></button>
      </form>
  </div><!--/login form-->
</div>
</div>
</div>
</section>

<script>

$("#pincode").keypress(function (e) {
 //if the letter is not digit then display error and don't type anything
 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //display error message
    $("#errmsg").html("Digits Only").show().fadeOut("slow");
           return false;
}
});
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
</script>
@endsection
