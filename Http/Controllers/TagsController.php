<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Content\Http\Requests\TagFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

class TagsController extends Controller {
	
	private $content;
	public function __construct(ContentRepository $content)
	{
		$this->content = $content;
		$this->middleware('AclAuthenticate');
	}


	public function getIndex()
	{
		$tags = $this->content->getAllTags();
		return view('content::contentTags.viewtags', array('tags'=>$tags));
	}

	public function getCreate()
	{
		$items = $this->content->getAllTags();
		return view('content::contentTags.addtags', compact('items'));
	}

	public function postCreate(TagFormRequest $request)
	{
		$this->content->createTag($request->all());
		return redirect()->back()->with('message', 'Tag inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$tags = $this->content->getTag($id);
		return view('content::contentTags.updatetag', compact('tags'));
	}

	//update the content
	public function postUpdate(TagFormRequest $request, $id)
	{
		$this->content->updateTag($id, $request->all());
		return redirect()->back()->with('message', 'Tags updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->content->deleteTag($id);
		return redirect()->back()->with('message', 'Tag Deleted succssefuly');
	}
}