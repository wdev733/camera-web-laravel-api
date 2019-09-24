@extends('layouts.cover')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-5 col-xl-4 my-5">

      <h1 class="display-4 text-center mb-3">
        {{ __('Login') }}
      </h1>

      <p class="text-muted text-center mb-5">
        Free access to our dashboard.
      </p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
          <label>Email Address</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus>

          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col">
              <label>Password</label>
            </div>
            <div class="col-auto">
              <a href="{{ route('password.request') }}" class="form-text small text-muted">
                {{ __('Forgotten Your Password?') }}
              </a>
            </div>
          </div>

          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="current-password">

          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror

        </div>

        <div class="form-group row">
          <div class="col-md-6 offset-md-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>

              <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
              </label>
            </div>
          </div>
        </div>

        <button class="btn btn-lg btn-block btn-primary mb-3">
          {{ __('Login') }}
        </button>

        <div class="text-center">
          <small class="text-muted text-center">
            Don't have an account yet? <a href="sign-up.html">Sign up</a>.
          </small>
        </div>

      </form>

    </div>
  </div>
</div>

@endsection
