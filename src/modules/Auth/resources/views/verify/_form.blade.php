@extends('core::layout.auth.login')
@section('body-inside')
    <div class="login-container">
        <div class="w-100 px-3 px-md-5">
            <div class="text-center mb-4 account-box-title">
                {{ trans('auth::verify.title_form') }}
            </div>
            <div class="login-area box_border_type_1 px-3 py-3 px-md-5 py-5">
                {!!
                   html()->form('POST', route('verify.reset'))
                   ->attribute('role', 'form')
                   ->id('verify_form')
                   ->open();
                !!}
                <div class="form-group pt-2">
                    <div class="input-group transparent py-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text transparent"><i class="fa fa-key"></i>
                              </span>
                        </div>
                        <input type="text" maxlength="6" name="token"
                               placeholder="{{ trans('auth::verify.placeholder') }}" class="form-control" required>
                        <input type="hidden" name="secret" value="{{ $hash }}"/>
                    </div>
                    <p class="mt-1" style="font-size: 14px">残りは<span class="count-seconds" style="font-size: 16px; font-weight: bold; color: green;">
                            {{ $seconds >= 0 ? $seconds : 0 }}</span>秒です。
                    </p>
                    @if ($errors->any())
                        <label class="invalid-feedback error" role="alert">
                            <strong>{{ $errors->first() }}</strong>
                        </label>
                    @endif
                </div>

                <div class="row">
                    <div class="m-auto align-items-center pt-4">
                        <button class="btn btn-theme-default btn-theme-login btn-cons m-t-10" type="submit">
                            <span>{{ trans('auth::verify.submit') }}</span>
                        </button>
                    </div>
                </div>
                {{ html()->form()->close() }}
                <a class="text-center" style="display: block; margin:10px auto;" href="{{ route('login') }}">ログイン画面へ</a>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        let seconds = '{{ $seconds >= 0 ? $seconds : 0 }}';
        setInterval(function () {
            $('.count-seconds').text(seconds);

            if (seconds > 0) {
                seconds--;
            }
        }, 1000);
    </script>
@endpush

