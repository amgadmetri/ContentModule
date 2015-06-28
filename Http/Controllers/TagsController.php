<?php namespace App\Modules\Content\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\TagFormRequest;

class TagsController extends BaseController {
	
	/**
	 * Create new TagsController instance.
	 */
	public function __construct()
	{
		parent::__construct('Tags');
	}

	/**
	 * Display a listing of the tags.
	 * 
	 * @return respnonse
	 */
	public function getIndex()
	{
		return view('content::tags.viewtags');
	}

	/**
	 * Show the form for creating a new tag.
	 * 
	 * @return response
	 */
	public function getCreate()
	{
		$tags = \CMS::tags()->all();
		return view('content::tags.addtags', compact('tags'));
	}

	/**
	 * Store a newly created tag in storage.
	 * 
	 * @param  TagFormRequest $request       
	 * @return response
	 */
	public function postCreate(TagFormRequest $request)
	{
		\CMS::tags()->createTag($request->all());
		return redirect()->back()->with('message', 'Tag created succssefuly');
	}

	/**
	 * Show the form for editing the specified tag.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getEdit($id)
	{
		$tag = \CMS::tags()->find($id);
		return view('content::tags.updatetag', compact('tag'));
	}

	/**
	 * Update the specified tag in storage.
	 * 
	 * @param  TagFormRequest $request 
	 * @param  integer        $id
	 * @return response
	 */
	public function postEdit(TagFormRequest $request, $id)
	{
		\CMS::tags()->update($id, $request->all());
		return redirect()->back()->with('message', 'Tag updated succssefuly');
	}

	/**
	 * Remove the specified tag from storage.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getDelete($id)
	{
		\CMS::tags()->delete($id);
		return redirect()->back()->with('message', 'Tag deleted succssefuly');
	}
}