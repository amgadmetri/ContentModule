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
		$contentTypes = \CMS::contentTypes()->all();
		return view('content::contenttypes.viewcontenttypes', compact('contentTypes'));
	}

	/**
	 * Show the form for creating a new content type.
	 * 
	 * @return response
	 */
	public function getCreate()
	{
		return view('content::contenttypes.addcontenttype');
	}

	/**
	 * Store a newly created content type in storage.
	 * 
	 * @param  ContentTypeFormRequest $request
	 * @return response
	 */
	public function postCreate(ContentTypeFormRequest $request)
	{
		\CMS::contentTypes()->create($request->all());
		return redirect()->back()->with('message', 'Content Type created succssefuly');
	}

	/**
	 * Show the form for editing the specified content type.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getEdit($id)
	{
		$contentType  = \CMS::contentTypes()->find($id);
		return view('content::contenttypes.updatecontenttype', compact('contentType'));
	}

	/**
	 * Update the specified content type in storage.
	 * 
	 * @param  ContentTypeFormRequest $request
	 * @param  integer                $id
	 * @return response
	 */
	public function postEdit(ContentTypeFormRequest $request, $id)
	{
		\CMS::contentTypes()->update($id, $request->all());
		return redirect()->back()->with('message', 'Content Type updated succssefuly');
	}

	/**
	 * Remove the specified content type from storage.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getDelete($id)
	{
		\CMS::contentTypes()->delete($id);
		return redirect()->back()->with('message', 'Content Type Deleted succssefuly');
	}
}