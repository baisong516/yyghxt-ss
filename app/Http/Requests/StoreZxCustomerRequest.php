<?php

namespace App\Http\Requests;

use App\Aiden;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreZxCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->id==1?true:false;
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
            'customer_condition_id'=>'required',
            'media_id'=>'required',
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
            'customer_condition_id.required'  => '状态必填',
            'media_id.required'  => '媒体必填',
        ];
    }
}
