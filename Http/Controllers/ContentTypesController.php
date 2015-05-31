<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\ContentTypeFormRequest;

class ContentTypesController extends BaseController {

	/**
	 * Create new ContentTypesController instance.
	 */
	public function __construct()
	{
		parent::__construct('ContentTypes');
	}

	/**
	 * Display a listing of the content types.
	 * 
	 * @return respnonse
	 */
	public function getIndex()
	{
		$contentTypes = \CMS::contentTypes()->getAllContentTypes();
		return view('content::contenttypes.viewcontenttypes', compact('contentTypes'));
	}
}