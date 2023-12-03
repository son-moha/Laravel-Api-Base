@extends('core::layout.auth.login')
@section('title', trans('auth::message.Forgot your login password'))
@section('body-inside')
    <div class="login-container">
        <div class="w-100 px-3 px-md-5">
            <div class="text-center mb-10">
                <h1 class="text-dark fw-bolder mb-3">{{ trans('auth::message.Forgot your login password') }}</h1>
                <div class="text-gray-500 fw-semibold fs-6">{{ trans('auth::text.Enter your email to reset your password') }}.</div>
            </div>
            <div class="forgot-area box_border_type_1 px-3 py-3 px-md-5 py-5">
            {!!
               html()->form('POST', route('password.email.send'))
               ->class('form_validation form_submit_check')
               ->attribute('role', 'form')
               ->id('verify_form')
               ->open();
            !!}
                <div class="input-group transparent pb-1">
                    <input type="email" name="email" placeholder="{{ trans('auth::text.Email') }}" class="form-control" required>
                </div>
                @error('email')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <p class="text-danger">{{Session::get('status')  ?? ''}}</p>
                @if (isset($fail))
                    <label class="invalid-feedback error" role="alert">
                        <strong>{{ trans($fail) }}</strong>
                    </label>
                @endif
                <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                    <button class="btn btn-primary btn-theme-password btn-block btn-cons m-t-10 me-4" type="submit">
                        <span>{{ trans('auth::text.Send') }}</span>
                    </button>
                    <a href="{{ route('auth.login') }}" class="btn btn-secondary text-info small text-primary">
                        <span>{{ trans('auth::text.Back to login') }}</span>
                    </a>
                </div>
            {{ html()->form()->close() }}
            </div>
        </div>
    </div>
@endsection
