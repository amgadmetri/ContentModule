<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Repositories\ContentRepository;

use Illuminate\Http\Request;

class ContentAlbumsController extends BaseController {

	public function __construct(ContentRepository $content)
	{
		parent::__construct($content, 'Contents');
	}

	//Display the content albums
	public function getAlbums(Request $request, $id)
	{
		$this->hasPermission('show');
		if($request->ajax()) 
		{	
			$this->hasPermission('add');
			return $this->repository->addContentAlbums($this->repository->getContent($id), $request->input('ids'));
		}
		
		$contentItem              = $this->repository->getContentWithData($id);
		$contentAlbums            = \GalleryRepository::getAlbums(unserialize($contentItem->content_albums));
		$contentAlbumMediaLibrary = \GalleryRepository::getMediaLibrary('album', false, 'contentAlbumMediaLibrary');

		return view('content::contentItems.contentalbums' ,compact('contentItem', 'contentAlbums', 'contentAlbumMediaLibrary'));
	}

	//Delete the content album
	public function getDeletealbum($id, $albumId)
	{
		$this->hasPermission('delete');
		$this->repository->deleteContentAlbums($this->repository->getContent($id), $albumId);
		return redirect()->back()->with('message', 'Album deleted succssefuly');
	}
}