@extends('auth::layout')
@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">New User</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('cp') }}" class="text-muted text-hover-primary">Home</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">User Management</li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">{{ trans('core::common.edit') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-body py-4">
            <form action="{{route('cp.users.update', $user->id)}}" method="post" class="form-horizontal form-label-left form_validation form_submit_check" autocomplete="off" enctype="multipart/form-data">
                <div class="form">
                    <div class="form_content">
                        @method('PUT')
                        @csrf
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="required fw-semibold fs-6 mb-2">{{ trans('auth::user.name') }}</label>
                            <input class="form-control form-control-solid mb-2 mb-lg-0" value="{{ old('name', $user->name) }}" name="name" type="text" />
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="required fs-6 fw-semibold mb-3">
                                <span>{{ trans('auth::user.avatar') }}</span>
                            </label>
                            <div class="mt-1">
                                <style>
                                    .image-input-placeholder {
                                        background-image: url({{asset('dist/media/svg/avatars/blank.svg')}});
                                    }
                                
                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url({{asset('dist/media/svg/avatars/blank.svg')}});
                                    }
                                </style>
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{asset('dist/media/svg/avatars/blank.svg')}})">
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ Storage::url($user->avatar) }})"></div>
                                    <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change"
                                    data-bs-toggle="tooltip"
                                    data-bs-dismiss="click"
                                    title="Change avatar">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <input type="file" name="avatar"/>
                                        <input type="hidden" name="avatar_remove" />
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel"
                                    data-bs-toggle="tooltip"
                                    data-bs-dismiss="click"
                                    title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                </div>
                                @error('avatar')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="fw-semibold fs-6 mb-2">{{ trans('auth::user.phone_number') }}</label>
                            <input class="form-control form-control-solid mb-2 mb-lg-0" value="{{ old('phone_number', $user->phone_number) }}" name="phone_number" type="tel"/>
                            @error('phone_number')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="fw-semibold fs-6 mb-2">{{ trans('auth::user.address') }}</label>
                            <input class="form-control form-control-solid mb-2 mb-lg-0" value="{{ old('address', $user->address) }}" name="address" type="text" />
                            @error('address')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="required fw-semibold fs-6 mb-2">{{ trans('auth::user.login ID') }}（{{trans('core::common.email')}}）</label>
                            <input class="form-control form-control-solid mb-2 mb-lg-0"  type="text" id="email" name="email" value="{{ old('email', $user->email) }}" />
                        </div>
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="fw-semibold fs-6 mb-2">{{trans('core::common.password')}}</label>
                            <input class="form-control form-control-solid mb-2 mb-lg-0"  type="password" id="password" name="password" data-rule-validPassword="true" autocomplete="new-password" />
                            @error('password')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="fw-semibold fs-6 mb-2">{{trans('core::common.password repeat')}}</label>
                            <input class="form-control form-control-solid mb-2 mb-lg-0"
                                   type="password" id="password_confirmation" name="password_confirmation"
                                   data-rule-validPassword="true" data-rule-equalTo="input[name=password]" autocomplete="new-password"
                            />
                        </div>
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="required fw-semibold fs-6 mb-2">{{trans('core::common.role')}}</label>
                            <div class="row ps-3">
                                @foreach($roles as $role)
                                    <div class="col-5 form-check form-check-custom form-check-solid mb-4">
                                        <input class="form-check-input" name="role_id[]" type="checkbox" value="{{$role->id}}" @if(in_array($role->id, $user->roles->pluck('id')->toArray())) checked @endif id="flexCheckDefault role_id"/>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{ trans($role->display_name) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('role_id')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="fv-row mb-8 col-md-6 col-sm-6 col-xs-12">
                            <label class="required fw-semibold fs-6 mb-2">{{trans('core::common.status')}}</label>
                            <div class="row ps-3">
                                <div class="form-check form-check-custom form-check-solid mb-5">
                                    <input class="form-check-input me-3" name="status" type="radio" value="1" id="kt_docs_formvalidation_radio_option_1" @if ($user->status == 1) checked @endif/>
                                    <label class="form-check-label" for="kt_docs_formvalidation_radio_option_1">
                                        <div class="fw-semibold text-gray-800">Enable</div>
                                    </label>
                                </div>
                            </div>
                            <div class="row ps-3">
                                <div class="form-check form-check-custom form-check-solid mb-5">
                                    <input class="form-check-input me-3" name="status" type="radio" value="0" id="kt_docs_formvalidation_radio_option_1" @if ($user->status == 0) checked @endif/>
                                    <label class="form-check-label" for="kt_docs_formvalidation_radio_option_1">
                                        <div class="fw-semibold text-gray-800">Disable</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="fv-row mt-5 mb-8 col-md-6 col-sm-6 col-xs-12">
                            <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                                <span class="indicator-label">
                                    {{trans('core::common.save')}}
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <a href="{{ back_link() }}" class="btn btn-default pull-right mr-2">
                                {{trans('core::common.back')}}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom-scripts')

@endpush
