@extends('core::layout.auth.login')
@section('body-inside')
    <div class="login-container">
        <div class="w-100 px-3 px-md-5">
            <div class="text-center fs-3 fw-semibold mb-4 account-box-title">
                {{__('auth::text.Confirm Password Reset')}}
            </div>
            <div class="forgot-area fs-5 box_border_type_1 px-3 py-3 px-md-5 py-5">
                <div class="forgot-password">
                    <p class="notice pb-2 text-center">
                        {{__('auth::text.This is an invalid link')}}
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mx-auto text-center">
                            <a href="{{ route('auth.login') }}" class="btn btn-secondary text-info small text-primary">
                                {{trans('auth::text.Back to login')}}
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
