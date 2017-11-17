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
            'zixun_at'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '标识必填',
            'office_id.required'  => '科室必填',
            'zixun_at.required'  => '咨询时间必填',
        ];
    }
}
