<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ContentAlbumsController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getShow' => 'show',
	];

	/**
	 * Create new ContentAlbumsController instance.
	 */
	public function __construct()
	{
		parent::__construct('ContentAlbums');
	}

	/**
	 * Display a listing of the content albums.
	 * 
	 * @param  integer  $id
	 * @return respnonse
	 */
	public function getShow($id)
	{			
		$contentItem              = \CMS::contentItems()->getContent($id);
		$contentAlbums            = \CMS::albums()->getAlbums(unserialize($contentItem->content_albums));
		$contentAlbumMediaLibrary = \CMS::galleries()->getMediaLibrary('album', false, 'contentAlbumMediaLibrary');

		return view('content::contentitems.contentalbums' ,compact('contentItem', 'contentAlbums', 'contentAlbumMediaLibrary'));
	}

	/**
	 * Store a newly created comment in storage.
	 *
	 * @param  Request  $request
	 * @param  integer  $id
	 * @return respnonse
	 */
	public function getCreate(Request $request, $id)
	{	
		 \CMS::contentItems()->addContentAlbums(\CMS::contentItems()->find($id), $request->input('ids'));
		 return redirect()->back()->with('message', 'Album created succssefuly');
	}

	/**
	 * Remove the specified content album from storage.
	 * 
	 * @param  integer $id
	 * @param  integer $albumId
	 * @return response
	 */
	public function getDelete($id, $albumId)
	{
		\CMS::contentItems()->deleteContentAlbums(\CMS::contentItems()->find($id), $albumId);
		return redirect()->back()->with('message', 'Album deleted succssefuly');
	}
}