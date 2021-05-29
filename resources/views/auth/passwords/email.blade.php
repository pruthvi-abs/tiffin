@extends('admin.layout.login')
@section('content')

<div>
<a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>
<div class="login_wrapper">
    <div class="animate form login_form">
      <section class="login_content">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <h1>{{ __('Reset Password') }}</h1>
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
                </div>
            @endif
            <div>
                <input id="email" placeholder="Email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div>
                <button type="submit" class="btn btn-primary submit">{{ __('Send Password Reset Link') }}</button>
              <a class="reset_pass" href="{{ route('login') }}">{{ __('Login') }}</a>
            </div>
          </form>
    </div>
</div>
</div>
@endsection
