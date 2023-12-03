@extends('core::layout.auth.login')
@section('body-inside')
    <!--begin::Signin Form-->
    {!!
        html()->form('POST', route('login'))->class('form w-100')->attribute('role', 'form')->open();
    !!}
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
            <!--end::Subtitle=-->
        </div>
        <!--begin::Heading-->
        <!--begin::Separator-->
        <div class="my-14">
            @if ($errors->has('message'))
                <label class="invalid-feedback error" role="alert">
                    <strong>{{ $errors->first('message') }}</strong>
                </label>
            @endif
            @include('core::_messages.flash')

        </div>
        <!--end::Separator-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
            <!--begin::Email-->
            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" value="{{ old('email', 'super@mail.io') }}" required autofocus>
            <!--end::Email-->
            @if ($errors->has('email'))
                <label class="invalid-feedback error" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </label>
            @endif
        </div>
        <!--end::Input group=-->
        <div class="fv-row mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
            <!--begin::Password-->
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" value="123456">
            <!--end::Password-->
        </div>
        <!--end::Input group=-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            @if (Route::has('password.email'))
                <!--begin::Link-->
                <a href="{{ route('password.email') }}" class="link-primary">Forgot Password ?</a>
                <!--end::Link-->
            @endif
        </div>
        <!--end::Wrapper-->
        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" class="btn btn-primary">
                @include('partials.general._button-indicator', ['label' => __('Continue')])
            </button>
        </div>
        <!--end::Submit button-->
        <div></div>
    {{ html()->form()->close() }}
    <!--end::Signin Form-->
@endsection
