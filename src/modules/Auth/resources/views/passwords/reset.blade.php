@extends('core::layout.auth.login')
@section('title', trans('passwords.reset password title page'))
@section('body-inside')
    <div class="login-container">
        <div class="w-100 px-3 px-md-5">
            <div class="text-center mb-4 fs-2 fw-bolder account-box-title">
                {{__('Reset Password')}}
            </div>
            <div class="text-center text-gray-500 fw-semibold fs-6 mb-3">
                {{__('auth::text.Have you already reset the password ?')}}
                <a href="{{ route('auth.login') }}" class="link-primary fw-bold">{{__('auth::text.Sign In')}}</a>
            </div>
            <div class="forgot-area box_border_type_1 px-3 py-3 px-md-5 py-5">
                {{
                   html()->form('POST', route('password.reset'))
                   ->class('form_validation form_submit_check')
                   ->attribute('role', 'form')->id('resetPasswordForm')
                   ->open()
               }}
                <input type="hidden" name="token" value="{{ request('token', '') }}">
                <input type="hidden" name="email" value="{{ request('email', '') }}">

                @foreach ($errors->all() as $error)
                    <label class="invalid-feedback error" role="alert">
                        <strong>{{ $error }}</strong>
                    </label>
                @endforeach

                <div class="form-group pt-2">
                    <div class="input-group transparent py-1">
                        <input type="password" name="password" placeholder="{{__("auth::text.Password")}}" class="form-control" required
                             data-rule-validPassword="true">
                    </div>
                    @error('password')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group pt-2">
                    <div class="input-group transparent py-1">
                        <input type="password" name="password_confirmation" placeholder="{{__('auth::text.Repeat Password')}}"
                               class="form-control" required data-rule-equalTo="input[name=password]" data-rule-validPassword="true"
                               minlength="8" maxlength="20">
                    </div>
                </div>

                <div class="row">
                    <div class="m-auto align-items-center pt-2 d-grid">
                        <button class="btn btn-primary btn-theme-password btn-block btn-cons m-t-10" type="submit">
                            <span>{{__('auth::text.Submit')}}</span>
                        </button>
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
@endsection
