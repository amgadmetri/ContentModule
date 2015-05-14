<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\ContentFormRequest;
use Illuminate\Http\Request;

class ContentsController extends BaseController {

	public function __construct()
	{
		parent::__construct('Contents');
	}

 	//display all the contents
	public function getIndex(Request $request)
	{
		$this->hasPermission('show');
		$status       = $request->input('status') ?: 'all';
		$contentItems = \CMS::contentItems()->getAllContents($status);
		$contentItems->setPath(url('admin/content?status=' . $request->input('status')));

		return view('content::contentItems.viewcontent', compact('contentItems', 'status'));
	}

	//display the create form
	public function getCreate(Request $request)
	{
		$this->hasPermission('add');
		if($request->ajax()) 
		{
			return \CMS::galleries()->getGalleries($request->input('ids'));
		}

		$sectionTypes             = \CMS::sectionTypes()->all();
		$tags                     = \CMS::tags()->all();
		
		$contentImageMediaLibrary = \CMS::galleries()->getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary             = \CMS::galleries()->getMediaLibrary();

		return view('content::contentItems.addcontent' ,compact('sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
	}

	//insert the content in the database
	public function postCreate(ContentFormRequest $request)
	{
		$this->hasPermission('add');
		$data['user_id'] = \Auth::user()->id;
		$contentItem     = \CMS::contentItem()->createContent(array_merge($request->all(), $data));

		\CMS::sections()->addSections($contentItem, $request->input('section_id'));
		\CMS::tags()->addtags($contentItem, $request->get('tag_content'));

		return redirect()->back()->with('message', 'Content inserted in the database succssefuly');
	}

	//display the update form 
	public function getUpdate(Request $request, $id)
	{
		$this->hasPermission('edit');
		if($request->ajax()) 
		{
			$insertedGalleries = \CMS::galleries()->getGalleries($request->input('ids'));
			return $insertedGalleries;
		}

		$contentItem               = \CMS::contentItems()->getContentWithData($id);
		$contentItem->contentImage = \CMS::galleries()->find($contentItem->content_image);

		$sectionTypes              = \CMS::sectionTypes()->all();
		$tags                      = \CMS::tags()->all();

		$contentImageMediaLibrary  = \CMS::galleries()->getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary              = \CMS::galleries()->getMediaLibrary();

		return view('content::contentItems.updatecontent',
			compact('contentItem', 'sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
	}

	//update the content
	public function postUpdate(ContentFormRequest $request, $id)
	{
		$this->hasPermission('edit');
		$data['user_id'] = \Auth::user()->id;
		$contentItem     = \CMS::contentItems()->updateContent($id, array_merge($request->all(), $data));

		\CMS::sections()->addSections($contentItem, $request->input('section_id'));
		\CMS::tags()->addtags($contentItem, $request->get('tag_content'));
		
		return redirect()->back()->with('message', 'Content updated succssefuly');
	}

	//Delete the content
	public function getDelete($id)
	{
		$this->hasPermission('delete');
		\CMS::contentItems()->delete($id);
		return redirect()->back()->with('message', 'Content Deleted succssefuly');
	}
}