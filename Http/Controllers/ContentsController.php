<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Content\Http\Requests\ContentFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

 class ContentsController extends Controller {

 	private $content;
 	public function __construct(ContentRepository $content)
 	{
 		$this->content = $content;
 	}

 	//display all the contents
	public function getIndex()
	{
		$contentItems = $this->content->getAllContents();
		return view('content::contentItems.viewcontent', compact('contentItems'));
	}

	//display the create form
	public function getCreate()
	{
		$sections = $this->content->getAllSections();
		$tags     = $this->content->getAllTags();

		return view('content::contentItems.addcontent' ,compact('sections', 'tags'));
	}

	//insert the content in the database
	public function postCreate(ContentFormRequest $request)
	{
		$data['user_id'] = 1;
		$contentItem     = $this->content->createContent(array_merge($request->all(), $data));

		$this->content->addSections($contentItem, $request->input('section_id'));
		$this->content->addtags($contentItem, $request->get('tag_content'));

		return redirect()->back()->with('message', 'Content inserted in the database succssefuly');
	}

	//display the update form 
	public function getUpdate($id)
	{
		$contentItem = $this->content->getContent($id);
		$sections    = $this->content->getSectionsWithNoContent($contentItem->id);
		$tags        = $this->content->getTagsWithNoContent($contentItem->id);

		return view('content::contentItems.updatecontent', 
			compact('contentItem', 'sections', 'tags'));
	}

	//update the content
	public function postUpdate(ContentFormRequest $request, $id)
	{
		$data['user_id'] = 1;
		$contentItem     = $this->content->updateContent($id, array_merge($request->all(), $data));

		$this->content->addSections($contentItem, $request->input('section_id'));
		$this->content->addtags($contentItem, $request->get('tag_content'));
		
		return redirect()->back()->with('message', 'Content updated succssefuly');
	}

	//Delete the content
	public function getDelete($id)
	{
		$this->content->deleteContent($id);
		return redirect()->back()->with('message', 'Content Deleted succssefuly');
	}
}