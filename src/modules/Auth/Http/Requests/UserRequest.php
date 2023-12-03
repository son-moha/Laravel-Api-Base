<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->route()->getName() == 'login') {
            $rule['email'] = 'bail|required|email|max:50';
            $rule['password'] = 'required|min:6|max:20|bail';
        } else {
            if ($this->route()->getName() == 'api.users.store') {
                $rule['password'] = 'required|min:6|max:20|bail';
            } else {
                $rule['password'] = 'min:6|max:20|bail';
            }

            $rule['name'] = 'required|max:50|bail';
            $rule['role_id'] = 'required|bail';
            $rule['phone_number'] = 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7|max:11|bail';
            $rule['company_id'] = 'required|bail';
            $rule['email'] = 'bail|required|email|max:50';
        }

        return $rule;
    }

    public function attributes()
    {
        return [
            'name' => trans('auth::user.name'),
            'email' => trans('core::common.email'),
            'password' => trans('core::common.password'),
            'role_id' => trans('core::common.role'),
            'phone_number' => trans('core::common.phone_number'),
            'address' => trans('core::common.address'),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name không được để trống',
            'name.max' => 'Name không được quá 50 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email không được quá 50 ký tự',
            'password.required' => 'Password không được để trống',
            'password.min' => 'Password tối thiểu 6 ký tự',
            'password.max' => 'Password không được quá 20 ký tự',
            'role_id.required' => 'Vị trí không được bỏ trống',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.regex' => 'Số điện thoại không đúng định dạng',
            'phone_number.min' => 'Số điện thoại tối thiểu 7 ký tự',
            'phone_number.max' => 'Số điện thoại không được quá 12 ký tự',
            'company_id' => 'Công ty trực thuộc không được để trống'
        ];
    }
}
