<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Content\Http\Requests\ContentFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

use GalleryRepository;
use Illuminate\Http\Request;
class ContentsController extends Controller {

	private $content;
	public function __construct(ContentRepository $content)
	{
		$this->content = $content;
		$this->middleware('AclAuthenticate');
	}

 	//display all the contents
	public function getIndex()
	{
		$contentItems = $this->content->getAllContents();
		return view('content::contentItems.viewcontent', compact('contentItems'));
	}

	//display the create form
	public function getCreate(Request $request)
	{
		if($request->ajax()) 
		{
			$insertedGalleries = GalleryRepository::getGalleries($request->input('ids'));
			return $insertedGalleries;
		}

		$sectionTypes             = $this->content->getAllSectionTypes();
		$tags                     = $this->content->getAllTags();
		$contentImageMediaLibrary = GalleryRepository::getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary             = GalleryRepository::getMediaLibrary();

		return view('content::contentItems.addcontent' ,compact('sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
	}

	//insert the content in the database
	public function postCreate(ContentFormRequest $request)
	{
		$data['user_id'] = \Auth::user()->id;
		$contentItem     = $this->content->createContent(array_merge($request->all(), $data));

		$this->content->addSections($contentItem, $request->input('section_id'));
		$this->content->addtags($contentItem, $request->get('tag_content'));

		return redirect()->back()->with('message', 'Content inserted in the database succssefuly');
	}

	//display the update form 
	public function getUpdate($id, Request $request)
	{

		if($request->ajax()) 
		{
			$insertedGalleries = GalleryRepository::getGalleries($request->input('ids'));
			return $insertedGalleries;
		}

		$contentItem  = $this->content->getContent($id);
		$contentData  = $this->content->getContentData($contentItem);
		$sectionTypes = $this->content->getAllSectionTypes();
		$tags         = $this->content->getAllTags();
		$contentImageMediaLibrary = GalleryRepository::getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary             = GalleryRepository::getMediaLibrary();

		return view('content::contentItems.updatecontent', 
			compact('contentItem', 'contentData', 'sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
	}

	//update the content
	public function postUpdate(ContentFormRequest $request, $id)
	{
		$data['user_id'] = \Auth::user()->id;
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