<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\ContentFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

use Illuminate\Http\Request;
class ContentsController extends BaseController {

	public function __construct(ContentRepository $content)
	{
		parent::__construct($content, 'Contents');
	}

 	//display all the contents
	public function getIndex(Request $request)
	{
		$this->hasPermission('show');
		$status       = $request->input('status') ?: 'all';
		$contentItems = $this->repository->getAllContents($status);

		$contentItems->setPath(url('content?status=' . $request->input('status')));
		return view('content::contentItems.viewcontent', compact('contentItems', 'status'));
	}

	//display the create form
	public function getCreate(Request $request)
	{
		$this->hasPermission('add');
		if($request->ajax()) 
		{
			return \GalleryRepository::getGalleries($request->input('ids'));
		}

		$sectionTypes             = $this->repository->getAllSectionTypes();
		$tags                     = $this->repository->getAllTags();
		
		$contentImageMediaLibrary = \GalleryRepository::getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary             = \GalleryRepository::getMediaLibrary();

		return view('content::contentItems.addcontent' ,compact('sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
	}

	//insert the content in the database
	public function postCreate(ContentFormRequest $request)
	{
		$this->hasPermission('add');
		$data['user_id'] = \Auth::user()->id;
		$contentItem     = $this->repository->createContent(array_merge($request->all(), $data));

		$this->repository->addSections($contentItem, $request->input('section_id'));
		$this->repository->addtags($contentItem, $request->get('tag_content'));

		return redirect()->back()->with('message', 'Content inserted in the database succssefuly');
	}

	//display the update form 
	public function getUpdate(Request $request, $id)
	{
		$this->hasPermission('edit');
		if($request->ajax()) 
		{
			$insertedGalleries = \GalleryRepository::getGalleries($request->input('ids'));
			return $insertedGalleries;
		}

		$contentItem               = $this->repository->getContentWithData($id);
		$contentItem->contentImage = \GalleryRepository::getGallery($contentItem->content_image);

		$sectionTypes              = $this->repository->getAllSectionTypes();
		$tags                      = $this->repository->getAllTags();

		$contentImageMediaLibrary  = \GalleryRepository::getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary              = \GalleryRepository::getMediaLibrary();

		return view('content::contentItems.updatecontent',
			compact('contentItem', 'sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
	}

	//update the content
	public function postUpdate(ContentFormRequest $request, $id)
	{
		$this->hasPermission('edit');
		$data['user_id'] = \Auth::user()->id;
		$contentItem     = $this->repository->updateContent($id, array_merge($request->all(), $data));

		$this->repository->addSections($contentItem, $request->input('section_id'));
		$this->repository->addtags($contentItem, $request->get('tag_content'));
		
		return redirect()->back()->with('message', 'Content updated succssefuly');
	}

	//Delete the content
	public function getDelete($id)
	{
		$this->hasPermission('delete');
		$this->repository->deleteContent($id);
		return redirect()->back()->with('message', 'Content Deleted succssefuly');
	}
}