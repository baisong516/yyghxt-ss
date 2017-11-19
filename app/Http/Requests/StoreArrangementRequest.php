<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArrangementRequest extends FormRequest
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
		$id = $this->route('arrangement'); //获取当前需要排除的id
		if (empty($id)){//add
			return [
				'user_id' => 'required',
				'rank' => 'required',
				'rank_date' => 'required',
			];
		}else{//update
			return [
				'rank' => 'required',
				'rank_date' => 'required',
			];
		}
	}
	public function messages()
	{
		return [
			'user_id.required'  => '必填',
			'rank.required'  => '必填',
			'rank_date.required'  => '必填',
		];
	}
}
