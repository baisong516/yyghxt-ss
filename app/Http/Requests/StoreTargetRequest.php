<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTargetRequest extends FormRequest
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
            'year'=>'required|digits:4',
            'month'=>'required|digits_between:1,2',
            'cost'=>'required',
            'show'=>'required',
            'click'=>'required',
            'achat'=>'required',
            'chat'=>'required',
            'yuyue'=>'required',
            'arrive'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'office_id.required'  => '科室必填',
            'year.required'  => '年度必填',
            'month.required'  => '月份必填',
            'cost.required'  => '消费必填',
            'show.required'  => '展现必填',
            'click.required'  => '点击必填',
            'achat.required'  => '总对话必填',
            'chat.required'  => '有效对话必填',
            'yuyue.required'  => '预约必填',
            'arrive.required'  => '到院必填',
        ];
    }
}
