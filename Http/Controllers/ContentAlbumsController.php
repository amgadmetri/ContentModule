<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ContentAlbumsController extends BaseController {

	public function __construct()
	{
		parent::__construct('ContentAlbums');
	}

	//Display the content albums
	public function getAlbums(Request $request, $id)
	{
		$this->hasPermission('show');
		if($request->ajax()) 
		{	
			$this->hasPermission('add');
			return \CMS::contentItems()->addContentAlbums(\CMS::contentItems()->find($id), $request->input('ids'));
		}
		
		$contentItem              = \CMS::contentItems()->getContentWithData($id);
		$contentAlbums            = \CMS::albums()->getAlbums(unserialize($contentItem->content_albums));
		$contentAlbumMediaLibrary = \CMS::galleries()->getMediaLibrary('album', false, 'contentAlbumMediaLibrary');

		return view('content::contentItems.contentalbums' ,compact('contentItem', 'contentAlbums', 'contentAlbumMediaLibrary'));
	}

	//Delete the content album
	public function getDeletealbum($id, $albumId)
	{
		$this->hasPermission('delete');
		\CMS::contentItems()->deleteContentAlbums(\CMS::contentItems()->find($id), $albumId);
		return redirect()->back()->with('message', 'Album deleted succssefuly');
	}
}