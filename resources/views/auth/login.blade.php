@extends('admin.layout.login')
@section('content')

<div>
<a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>
<div class="login_wrapper">
    <div class="animate form login_form">
      <section class="login_content">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <h1>Login Form</h1>
          <div>
            <input id="email" type="email" placeholder="Email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required="true" autofocus>
            @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
            @endif
          </div>
          <div>
            <input id="password" type="password" placeholder="Password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  required="true">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="mb-4 mt-20">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
          </div>
          <div class="">
            <button type="submit" class="btn btn-primary submit">{{ __('Login') }}</button>
            <?php
            /*
            @if (Route::has('password.request'))
                <a class="reset_pass" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
            @endif
            */
            ?>
          </div>
          <div class="clearfix"></div>
          <div class="separator">
            <?php
            /*
              <a href="{{ route('register') }}" class="to_register">{{ __('Register') }}</a>
            */
            ?>
            <div class="clearfix"></div>
            <br />
            <div>
              <p>©<?php echo date('Y'); ?> All Rights Reserved.</p>
            </div>
          </div>
        </form>
      </section>
    </div>
    <!--
    <div id="register" class="animate form registration_form">
      <section class="login_content">
        <form>
          <h1>Create Account</h1>
          <div>
            <input type="text" class="form-control" placeholder="Username" required="" />
          </div>
          <div>
            <input type="email" class="form-control" placeholder="Email" required="" />
          </div>
          <div>
            <input type="password" class="form-control" placeholder="Password" required="" />
          </div>
          <div>
            <a class="btn btn-default submit" href="index.html">Submit</a>
          </div>

          <div class="clearfix"></div>

          <div class="separator">
            <p class="change_link">Already a member ?
              <a href="#signin" class="to_register"> Log in </a>
            </p>

            <div class="clearfix"></div>
            <br />

            <div>
              <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
              <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
            </div>
          </div>
        </form>
      </section>
    </div>
    -->
  </div>
</div>

@endsection
