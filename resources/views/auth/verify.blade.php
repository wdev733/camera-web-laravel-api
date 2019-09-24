@extends('layouts.cover')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">

            <h1 class="display-4 text-center mb-3">
                {{ __('Verify Your Email Address') }}
            </h1>

            @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}, <a
                href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.

        </div>
    </div>
</div>
@endsection
