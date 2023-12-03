@extends('auth::layout')
@section('content')
    <div class="container-fluid bg-white">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="{{route('cp.users.update', $user->id)}}" method="post" class="form-horizontal form-label-left form_validation form_submit_check" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="form">
                        <div class="form_title">
                            <span>{{ trans('core::common.edit') }}</span>
                        </div>
                        <div class="form_content">
                            @include('core::_messages.flash')
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('auth::user.name') }}<span
                                                class="required">*</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="name" class="form-control" value="{{ old('name', $user->name) }}"
                                               data-validate-length-range="6" data-validate-words="2" name="name"
                                               placeholder="Your name" required="required" type="text" maxlength="50">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('auth::user.login ID') }}（{{trans('core::common.email')}}）<span
                                                class="required">*</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" id="email" name="email" disabled value="{{ old('email', $user->email) }}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">{{trans('core::common.password')}}
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password" id="password" name="password" class="form-control"
                                               data-rule-validPassword="true">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_confirmation">{{trans('core::common.password repeat')}}
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               data-rule-validPassword="true" data-rule-equalTo="input[name=password]" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_id">{{trans('core::common.role')}}
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="role_id" id="role_id" class="form-control" data-toggle=select2-multi disabled>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}" @if(in_array($role->id, $user->roles->pluck('id')->toArray())) selected @endif>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success pull-right">
                                            {{trans('core::common.save')}}
                                        </button>
                                        <a href="{{ back_link() }}" class="btn btn-default pull-right mr-2">
                                            {{trans('core::common.back')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
