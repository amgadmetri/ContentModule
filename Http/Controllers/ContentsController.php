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
	public function getIndex(Request $request)
	{
		$status       = $request->input('status') ?: 'all';
		$contentItems = $this->content->getAllContents($status);

		$contentItems->setPath(url('content?status=' . $request->input('status')));
		return view('content::contentItems.viewcontent', compact('contentItems', 'status'));
	}

	//display the create form
	public function getCreate(Request $request)
	{
		if($request->ajax()) 
		{
			return GalleryRepository::getGalleries($request->input('ids'));
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
	public function getUpdate(Request $request, $id)
	{
		if($request->ajax()) 
		{
			$insertedGalleries = GalleryRepository::getGalleries($request->input('ids'));
			return $insertedGalleries;
		}

		$contentItem               = $this->content->getContentWithData($id);
		$contentItem->contentImage = GalleryRepository::getGallery($contentItem->content_image);

		$sectionTypes              = $this->content->getAllSectionTypes();
		$tags                      = $this->content->getAllTags();

		$contentImageMediaLibrary  = GalleryRepository::getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary              = GalleryRepository::getMediaLibrary();

		return view('content::contentItems.updatecontent',
			compact('contentItem', 'sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
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

	//Display the content albums
	public function getAlbums(Request $request, $id)
	{
		if($request->ajax()) 
		{	
			return $this->content->addContentAlbums($this->content->getContent($id), $request->input('ids'));
		}
		
		$contentItem              = $this->content->getContentWithData($id);
		$contentAlbums            = GalleryRepository::getAlbums(unserialize($contentItem->content_albums));
		$contentAlbumMediaLibrary = GalleryRepository::getMediaLibrary('album', false, 'contentAlbumMediaLibrary');

		return view('content::contentItems.contentalbums' ,compact('contentItem', 'contentAlbums', 'contentAlbumMediaLibrary'));
	}

	//Delete the content album
	public function getDeletealbum($id, $albumId)
	{
		$this->content->deleteContentAlbums($this->content->getContent($id), $albumId);
		return redirect()->back()->with('message', 'Album deleted succssefuly');
	}
}