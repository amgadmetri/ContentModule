<?php namespace App\Modules\Content\Http\Requests;

use App\Http\Requests\Request;


class ContentFormRequest extends Request {

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
		'alias'       => 'required|unique:content_items,id,' . $this->get('id'),
		'title'       => 'required|max:255',
		'description' => 'required|max:255',
		'content'     => 'required'

		];
	}

}
