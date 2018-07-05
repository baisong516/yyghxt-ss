<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonTargetRequest extends FormRequest
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
            'office_id'=>'required',
            'user_id'=>'required',
            'year'=>'required|digits:4',
            'month'=>'required|digits_between:1,2',
            'chat'=>'required',
            'contact'=>'required',
            'yuyue'=>'required',
            'arrive'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'office_id.required'  => '科室必填',
            'user_id.required'  => '咨询员必填',
            'year.required'  => '年度必填',
            'month.required'  => '月份必填',
            'chat.required'  => '有效对话必填',
            'contact.required'  => '留联量必填',
            'yuyue.required'  => '预约必填',
            'arrive.required'  => '到院必填',
        ];
    }
}
