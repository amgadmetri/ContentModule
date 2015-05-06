<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\TagFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

class TagsController extends BaseController {
	
	public function __construct(ContentRepository $content)
	{
		parent::__construct($content, 'Tags');
	}

	public function getIndex()
	{
		$this->hasPermission('show');
		$tags = $this->repository->getAllTags();

		return view('content::contentTags.viewtags', array('tags'=>$tags));
	}

	public function getCreate()
	{
		$this->hasPermission('add');
		$items = $this->repository->getAllTags();

		return view('content::contentTags.addtags', compact('items'));
	}

	public function postCreate(TagFormRequest $request)
	{
		$this->hasPermission('add');
		$this->repository->createTag($request->all());

		return redirect()->back()->with('message', 'Tag inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$this->hasPermission('edit');
		$tags = $this->repository->getTag($id);

		return view('content::contentTags.updatetag', compact('tags'));
	}

	//update the content
	public function postUpdate(TagFormRequest $request, $id)
	{
		$this->hasPermission('edit');
		$this->repository->updateTag($id, $request->all());

		return redirect()->back()->with('message', 'Tags updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->hasPermission('delete');
		$this->repository->deleteTag($id);

		return redirect()->back()->with('message', 'Tag Deleted succssefuly');
	}
}