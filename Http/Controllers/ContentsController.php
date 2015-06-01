<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\ContentItemFormRequest;
use Illuminate\Http\Request;

class ContentsController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getShow' => 'show', 
	];

	/**
	 * Create new ContentsController instance.
	 */
	public function __construct()
	{
		parent::__construct('Contents');
	}

 	/**
 	 * Display a listing of the content items.
 	 * 
 	 * @param  integer $contentTypeId
 	 * @return response
 	 */
	public function getShow($contentTypeId, $status = 'all')
	{
		$contentType  = \CMS::contentTypes()->find($contentTypeId);
		$contentItems = \CMS::contentItems()->getAllContents($contentType->content_type_name, false, $status);
		$contentItems->setPath(url('admin/content/show', [$contentTypeId, $status]));

		return view('content::contentitems.viewcontent', compact('contentItems', 'status', 'contentType'));
	}

	/**
	 * Show the form for creating a new content item.
	 * 
	 * @return response
	 */
	public function getCreate()
	{
		$sectionTypes             = \CMS::sectionTypes()->all();
		$tags                     = \CMS::tags()->all();
		$contentImageMediaLibrary = \CMS::galleries()->getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary             = \CMS::galleries()->getMediaLibrary();

		return view('content::contentitems.addcontent' ,compact('sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
	}

	/**
	 * Store a newly created content item in storage.
	 * 
	 * @param  ContentItemFormRequest $request      
	 * @param  integer            $contentTypeId 
	 * @return response
	 */
	public function postCreate(ContentItemFormRequest $request, $contentTypeId)
	{
		$data['user_id']         = \Auth::user()->id;
		$data['content_type_id'] = $contentTypeId;
		$contentItem             = \CMS::contentItem()->createContent(array_merge($request->all(), $data));

		\CMS::sections()->addSections($contentItem, $request->input('section_id'));
		\CMS::tags()->addtags($contentItem, $request->get('tag_name'));

		return redirect()->back()->with('message', 'Content created succssefuly');
	}

	/**
	 * Show the form for editing the specified content item.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getEdit($id)
	{
		$contentItem               = \CMS::contentItems()->getContent($id);
		$sectionTypes              = \CMS::sectionTypes()->all();
		$tags                      = \CMS::tags()->all();
		$contentImageMediaLibrary  = \CMS::galleries()->getMediaLibrary('photo', true, 'contentImageMediaLibrary');
		$mediaLibrary              = \CMS::galleries()->getMediaLibrary();

		return view('content::contentitems.updatecontent', compact('contentItem', 'sectionTypes', 'tags', 'mediaLibrary', 'contentImageMediaLibrary'));
	}

	/**
	 * Update the specified content item in storage.
	 * 
	 * @param  ContentItemFormRequest $request
	 * @param  integer            $id
	 * @return response
	 */
	public function postEdit(ContentItemFormRequest $request, $id)
	{
		$contentItem = \CMS::contentItems()->updateContent($id, $request->all());
		\CMS::sections()->addSections($contentItem, $request->input('section_id'));
		\CMS::tags()->addtags($contentItem, $request->get('tag_name'));
		
		return redirect()->back()->with('message', 'Content updated succssefuly');
	}

	/**
	 * Remove the specified widget from storage.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getDelete($id)
	{
		\CMS::contentItems()->delete($id);
		return redirect()->back()->with('message', 'Content Deleted succssefuly');
	}

	/**
	 * Return a gallery array from the given ids,
	 * handle the ajax request for inserting galleries
	 * to the content.
	 * 
	 * @param  Request $request
	 * @return collection
	 */
	public function getContentgalleries(Request $request)
	{
		return \CMS::galleries()->getGalleries($request->input('ids'));
	}
}