<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $id = $this->route('user'); //获取当前需要排除的id
        if (empty($id)){//add
            return [
                'name' => 'required|unique:users,name|max:191',
                'realname' => 'required|max:191',
                'password' => 'required|max:191',
                'department_id' => 'required',
                'hospitals' => 'required',
                'offices' => 'required',
                'roles' => 'required',
            ];
        }else{//update
            return [
                'realname' => 'required|max:191',
                'department_id' => 'required',
                'hospitals' => 'required',
                'offices' => 'required',
                'roles' => 'required',
            ];
        }
    }
    public function messages()
    {
        return [
            'name.required' => '标识必填',
            'name.unique' => '标识唯一',
            'name.max' => '标识长度最大191',
            'realname.required'  => '名称必填',
            'realname.max'  => '名称长度最大191',
        ];
    }
}
