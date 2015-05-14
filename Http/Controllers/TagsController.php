<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\TagFormRequest;

class TagsController extends BaseController {
	
	public function __construct()
	{
		parent::__construct('Tags');
	}

	public function getIndex()
	{
		$this->hasPermission('show');
		$tags = \CMS::tags()->all();

		return view('content::contentTags.viewtags', array('tags'=>$tags));
	}

	public function getCreate()
	{
		$this->hasPermission('add');
		$items = \CMS::tags()->all();

		return view('content::contentTags.addtags', compact('items'));
	}

	public function postCreate(TagFormRequest $request)
	{
		$this->hasPermission('add');
		\CMS::tags()->createTag($request->all());

		return redirect()->back()->with('message', 'Tag inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$this->hasPermission('edit');
		$tags = \CMS::tags()->find($id);

		return view('content::contentTags.updatetag', compact('tags'));
	}

	//update the content
	public function postUpdate(TagFormRequest $request, $id)
	{
		$this->hasPermission('edit');
		\CMS::tags()->update($id, $request->all());

		return redirect()->back()->with('message', 'Tags updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->hasPermission('delete');
		\CMS::tags()->delete($id);

		return redirect()->back()->with('message', 'Tag Deleted succssefuly');
	}
}