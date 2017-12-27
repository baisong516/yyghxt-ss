<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuctionRequest extends FormRequest
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
            'type'=>'required',
            'type_id'=>'required',
            'budget'=>'required',
            'cost'=>'required',
            'click'=>'required',
            'zixun'=>'required',
            'yuyue'=>'required',
            'arrive'=>'required',
            'date_tag'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'office_id.required' => '必填',
            'type.required' => '必填',
            'type_id.required' => '必填',
            'budget.required' => '必填',
            'cost.required'  => '必填',
            'click.required'  => '必填',
            'zixun.required'  => '必填',
            'yuyue.required'  => '必填',
            'arrive.required'  => '必填',
            'date_tag.required'  => '必填',
        ];
    }
}
