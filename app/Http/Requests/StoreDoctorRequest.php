<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
        $id = $this->route('doctor'); //获取当前需要排除的id
        if (empty($id)){//add
            return [
                'name' => 'required|unique:doctors,name|max:191',
                'display_name' => 'required|max:191',
                'hospital_id' => 'required',
                'office_id' => 'required',
            ];
        }else{//update
            return [
                'display_name' => 'required|max:191',
                'hospital_id' => 'required',
                'office_id' => 'required',
            ];
        }
    }
    public function messages()
    {
        return [
            'name.required' => '标识必填',
            'name.unique' => '标识唯一',
            'name.max' => '标识长度最大191',
            'display_name.required'  => '名称必填',
            'display_name.max'  => '名称长度最大191',
            'hospital_id.required'  => '必填',
            'office_id.required'  => '必填',
        ];
    }
}
