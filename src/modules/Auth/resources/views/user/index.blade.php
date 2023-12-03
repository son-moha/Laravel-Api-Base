@extends('auth::layout')
@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Users List</h1>
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
            <li class="breadcrumb-item text-muted">Users</li>
        </ul>
    </div>
    @can('update', \Modules\Auth\Entities\Models\User::class)
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('cp.users.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a>
        </div>
    @endcan
@endsection
@section('content')
    @include('core::_messages.flash')
    <!--begin::Toolbar-->
    <div class="card">
        <!--begin::Card header-->
        {!!
           html()->form('GET', route('cp.users.search'))
           ->class('form w-100')
           ->attribute('role', 'form')
           ->open();
        !!}
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title w-100">
                <!--begin::Search-->
                <div class="d-flex w-100 flex-wrap justify-content-between align-items-center position-relative my-1">
                    <div class="d-flex-column align-items-center position-relative my-1 mx-2">
                        <p class="ms-1 mb-1 fs-7 ">Name</p>
                        <input type="text" name="name" value="{{request()->get('name', null) ?? ""}}"
                               class="input-search h-30px form-control p-2 me-4 w-200px" placeholder="User name"/>
                    </div>
                    <div class="d-flex-column align-items-center position-relative my-1 mx-2">
                        <p class="ms-1 mb-1 fs-7 ">Email</p>
                        <input type="text" name="email" value="{{request()->get('email', null) ?? ""}}"
                               class="input-search h-30px form-control p-2 me-4 w-200px" placeholder="Email"/>
                    </div>
                    <div class="d-flex-column align-items-center position-relative my-1 mx-2">
                        <p class="ms-1 mb-1 fs-7 ">Role</p>
                        <select name="role"
                                class="input-search h-30px form-select border-dark border-opacity-25 form-select-sm py-0 me-4 w-200px"
                                data-placeholder="Select option">
                            <option value="" selected></option>
                            @foreach ($roles as $role)
                                <option {{request()->get('role', null) ? (request()->get('role') == array_flip(Modules\Auth\Constants\QuizConst::USER_ROLES)[$role->name] ? 'selected': '') : ''}} value="{{array_flip(Modules\Auth\Constants\QuizConst::USER_ROLES)[$role->name]}}">{{__("{$role->display_name}")}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex-column align-items-center position-relative my-1 mx-2">
                        <p class="ms-1 mb-1 fs-7 ">Status</p>
                        <select name="status"
                                class="input-search h-30px form-select border-dark border-opacity-25 form-select-sm py-0 me-4 w-200px"
                                data-placeholder="Select option">
                            <option value="" selected></option>
                            @foreach (Modules\Auth\Constants\AuthStatusConst::USER_STATUSES as $key => $value)
                                <option {{request()->get('status', null) ? (request()->get('status') == $key ? 'selected': '') : ''}} value="{{$key}}">{{Str::ucfirst($key)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Search-->
            </div>
            <div class="w-100 d-flex justify-content-center">
                <button type="submit" class="btn btn-sm py-1 btn-primary mx-2">Search</button>
                <button type="button" id="btn_reset" class="btn btn-sm btn-secondary mx-2">Reset</button>
            </div>
        </div>
        {{ html()->form()->close() }}
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class=" table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    {{--                <tr>--}}
                    {{--                    {!!  Html::renderHeader(--}}
                    {{--                     [--}}
                    {{--                     'id' => ['name' => trans('core::common.No'), 'style' => 'width: 80px'],--}}
                    {{--                     'name' => ['name' => trans('auth::user.name'), 'sortable' => true],--}}
                    {{--                     'email' => ['name' => trans('core::common.email'), 'sortable' => true],--}}
                    {{--                     'created_at' => ['name' => trans('core::common.created at'), 'sortable' => true],--}}
                    {{--                     'action' => ['name' => '', 'sortable' => false, 'style' => "width: 270px"],--}}
                    {{--                     ],'id', route(Route::currentRouteName()), false)  !!}--}}
                    {{--                </tr>--}}
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                       data-kt-check-target="#kt_table_users .form-check-input" value="1"/>
                            </div>
                        </th>
                        <th class="min-w-125px">User</th>
                        <th class="min-w-125px">Role</th>
                        <th class="min-w-125px">Phone number</th>
                        <th class="min-w-125px">Address</th>
                        <th class="min-w-125px">Status</th>
                        <th class="min-w-125px">Last login</th>
                        <th class="min-w-125px">Joined Date</th>
                        <th class="text-end min-w-150px">Action</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-semibold">
                    <!--begin::Table row-->
                    @foreach($users as $key => $user)
                        <tr>
                            <!--begin::Checkbox-->
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1"/>
                                </div>
                            </td>
                            <!--end::Checkbox-->
                            <!--begin::User=-->
                            <td class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a @can('update', $user) href="{{ route('cp.users.edit', [$user->id]) }}" @endcan>
                                        <div class="symbol-label">
                                            <img src="{{ Storage::url($user->avatar) }}" alt="Emma Smith"
                                                 style="object-fit: cover" class="w-100 min-h-100"/>
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <a @can('update', $user) href="{{ route('cp.users.edit', [$user->id]) }}"
                                       @endcan class="text-gray-800 text-hover-primary mb-1">{{ $user->name }}</a>
                                    <span>{{ $user->email }}</span>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <!--end::User=-->
                            <!--begin::Role=-->
                            <td>
                                @foreach ($user->roles as $role)
                                    <p>{{__("{$role->display_name}")}}</p>
                                @endforeach
                            </td>
                            <!--end::Role=-->
                            <!--begin::Two step=-->
                            <td>{{$user->phone_number}}</td>
                            <td>{{$user->address}}</td>
                            <!--end::Two step=-->
                            <td>
                                @can('update', $user)
                                    {{-- <form method="POST" action="{{route('cp.users.update-status', $user->id)}}" id="{{'status-'.$user->id}}"> --}}
                                    @method('PATCH')
                                    @csrf
                                    <span class="col-lg-8 d-flex align-items-center">
                                    <span class="form-check form-check-solid form-switch form-check-custom fv-row">
                                        <input name="status" id="{{'status-'.$user->id}}"
                                               onclick="changeStatus('{{$user->id}}')"
                                               class="form-check-input w-45px h-30px" type="checkbox"
                                               id="allowmarketing" {{$user->status == 1 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="allowmarketing"></label>
                                    </span>
                                </span>
                                    {{-- </form> --}}
                                @endcan
                            </td>
                            <!--begin::Last login=-->
                            <td>
                                {{$user->last_login}}
                            </td>
                            <!--end::Last login=-->
                            <!--begin::Joined-->
                            <td>{{ $user->created_at }}</td>
                            <!--begin::Joined-->
                            <!--begin::Action=-->
                            <td class="text-end">
                                @can('update', $user)
                                    <a href="{{ route('cp.users.edit', [$user->id]) }}"
                                       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                        <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                              d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                              fill="currentColor"></path>
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                              fill="currentColor"></path>
                                    </svg>
                                </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                @endcan
                                @can('delete', $user)
                                    <form action="{{route('cp.users.destroy', $user->id)}}" id="f-{{$user->id}}"
                                          class="d-inline" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        {{-- <a href="javascript:$('#f-{{$user->id}}').closest('form').submit()" class="menu-link px-3" data-kt-users-table-filter="delete_row">{{ trans('core::common.delete') }}</a> --}}
                                        <a href="javascript:$('#f-{{$user->id}}').closest('form').submit()"
                                           class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                            <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                              fill="currentColor"></path>
                                        <path opacity="0.5"
                                              d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                              fill="currentColor"></path>
                                        <path opacity="0.5"
                                              d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                              fill="currentColor"></path>
                                    </svg>
                                </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    </form>

                                @endcan
                            </td>
                            <!--end::Action=-->
                        </tr>
                    @endforeach
                    <!--end::Table row-->
                    </tbody>
                    <!--end::Table body-->
                </table>
            </div>
            <div class="row pt-3">
                <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                    @include('core::_pagination.counting', ['paginator' => $users])
                </div>
                <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                    <div class="dataTables_paginate paging_simple_numbers" id="kt_table_users_paginate">
                        @if(!empty($users))
                            {{ $users->appends(request()->input())->links('core::_pagination.template') }}
                        @endif
                    </div>
                </div>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
@endsection
@push('custom-scripts')
    <script>
        function changeStatus(id) {
            var status = Number($('#status-' + id).is(":checked"));
            var url = "{{route('cp.users.update-status', ":id")}}";
            url = url.replace(':id', id);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    status: status
                },
                success: function (result) {
                    console.log(result.message);
                    if (result.status == 'fail') {
                        $('#status-' + id).prop("checked", !$('#status-' + id).prop("checked"));
                    }
                    const toastElement = document.getElementById('kt_docs_toast_toggle');
                    const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
                    $('#icon-notify').addClass('svg-icon-' + result.status)
                    $('#ajax-toast-body').text(result.message);
                    toast.show();
                }
            });
        }
    </script>
    <script>
        $('#btn_reset').on('click', function () {
            $('.input-search').val('')
        })
    </script>
@endpush
