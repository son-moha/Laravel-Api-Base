@extends('core::layout.auth.login')
@section('body-inside')
    <div class="login-container">
        <div class="w-100 px-3 px-md-5">
            <div class="text-center mb-4 account-box-title">
                パスワードリセットの確認
            </div>
            <div class="forgot-area box_border_type_1 px-3 py-3 px-md-5 py-5">
                <div class="forgot-password">
                    <p class="notice pb-2">
                        パスワードリセット確認のメールを送信しました。
                    </p>
                    <p class="notice pb-2">
                        パスワードリセットのURLを{{old('email')}}にメールを送信しました。
                        ご確認ください。
                    </p>
                    <p class="notice pb-2">
                        送付されたメールの手順に従ってパスワードリセット処理を完了するまでは、実際のパスワードリセットは行なわれません。
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mx-auto text-center">
                            <a href="{{ route('auth.login') }}" class="text-info small text-primary">
                                {{trans('passwords.back to login')}}
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
