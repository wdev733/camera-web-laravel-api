@extends('layouts.cover')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">

            <h1 class="display-4 text-center mb-3">
                {{ __('Reset Password') }}
            </h1>

            <p class="text-muted text-center mb-5">
                {{ __('Enter your email to get a password reset link.') }}
            </p>

            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>


                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif


                <button type="submit" class="btn btn-lg btn-block btn-primary mb-3">
                    {{ __('Send Password Reset Link') }}
                </button>

                <div class="text-center">
                    <small class="text-muted text-center">
                        Remember your password? <a href="sign-up.html">Sign In</a>.
                    </small>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
