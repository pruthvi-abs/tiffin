@extends('admin.layout.login')
@section('content')
<div>
<a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>
<div class="login_wrapper">
    <div class="animate form login_form">
      <section class="login_content">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>{{ __('Register') }}</h1>
            <div class="row">
            <div class="col-md-12 col-sm-12">
              <input id="name" placeholder="Name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
              @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
            </div>
            <div class="col-md-12 col-sm-12">
              <input id="email" type="email" placeholder="Email Address" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
            <div class="col-md-12 col-sm-12">
              <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
              @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
              <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()" >
									<i id="slash" class="fa fa-eye-slash"></i>
									<i id="eye" class="fa fa-eye"></i>
								</span>
            </div>
            <div class="col-md-12 col-sm-12">
              <input id="passwordconfirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required>
              <span style="position: absolute;right:15px;top:7px;" onclick="hideshow1()" >
								<i id="slash1" style="display:none;" class="fa fa-eye-slash"></i>
								<i id="eye1" class="fa fa-eye"></i>
							</span>
            </div>
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
            </div>
          </div>
        </form>
      </section>
      </div>
    </div>
</div>
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
	var password1 = document.getElementById("passwordconfirm");
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

// initialize a validator instance from the "FormValidator" constructor.
// A "<form>" element is optionally passed as an argument, but is not a must
/*
var validator = new FormValidator({
    "events": ['blur', 'input', 'change']
}, document.forms[0]);
// on form "submit" event
document.forms[0].onsubmit = function(e) {
    var submit = true,
        validatorResult = validator.checkAll(this);
    console.log(validatorResult);
    return !!validatorResult.valid;
};
// on form "reset" event
document.forms[0].onreset = function(e) {
    validator.reset();
};
// stuff related ONLY for this demo page:
$('.toggleValidationTooltips').change(function() {
    validator.settings.alerts = !this.checked;
    if (this.checked)
        $('form .alert').remove();
}).prop('checked', false);
*/
</script>
@endsection
