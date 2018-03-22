<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreZxCustomerRequest extends FormRequest
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
        return [
            'name'=>'required',
            'office_id'=>'required',
            'disease_id'=>'required',
            'zixun_at'=>'required',
            'cause_id'=>'required',
            'jingjia_user_id'=>'required',
            'next_at'=>'required',
            'description'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '标识必填',
            'office_id.required'  => '科室必填',
            'disease_id.required'  => '病种必填',
            'zixun_at.required'  => '咨询时间必填',
            'cause_id.required'  => '原因必填',
            'jingjia_user_id.required'  => '当班竞价必填',
            'next_at.required'  => '下次回访时间必填',
            'description.required'  => '咨询内容必填',
        ];
    }
}
