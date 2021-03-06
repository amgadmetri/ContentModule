<?php namespace App\Modules\Content\Http\Requests;

use App\Http\Requests\Request;


class SectionTypeFormRequest extends Request {

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
			'section_type_name' => 'required|max:255',
		];
	}

}
