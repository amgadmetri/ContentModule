<?php namespace App\Modules\Content\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class ContentItemRepository extends AbstractRepository
{	
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Content\ContentItems';
	}

	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['sections', 'tags', 'user', 'contentType'];
	}

	/**
	 * Get a listing of content items when section name, tag name,
	 * user data or content item data match the given query.
	 * 
	 * @param  string $query
	 * @return collection
	 */
	public function search($query, $language = false)
	{	
		$contents = $this->model->whereIn('id', \CMS::languageContents()->search($query, 'content'))->
		                          orWhereIn('user_id', \CMS::users()->search($query))->
		                          orWhereIn('id', \CMS::sections()->search($query)->lists('content_item_id'))->
		                          orWhereIn('id', \CMS::tags()->search($query)->lists('content_item_id'))->paginate(1);

		return \CMS::contentItems()->getContentTranslations($contents, $language);
	}

	/**
	 * Get the recent content based on 
	 * the given content type , language ,
	 * count and status.
	 * 
	 * @param  string  $contentTypeName
	 * @param  integer $count
	 * @param  string  $language
	 * @param  string  $status
	 * @return collection
	 */
	public function getRecentContents($contentTypeName, $count = 10, $language = false, $status = 'published')
	{	
		/**
		 * Return the content type that match the given name with translations.
		 * @var contentType
		 */
		$contentType = \CMS::contentTypes()->first('content_type_name', $contentTypeName);
		if ($status == 'all')
		{
			$contents = \CMS::contentItems()->findBy('content_type_id', $contentType->id)->
											  orderBy('created_at', 'desc')->
											  take($count)->
									  	      get();
		}
		else
		{
			$contents = $this->model->with($this->getRelations())->
		                              where('content_type_id', '=', $contentType->id)->
		                              where('status', '=', $status)->
									  orderBy('created_at', 'desc')->
									  take($count)->
									  get();
		}

		$contents = $this->getContentCommentsCount($contents);
		return $this->getContentTranslations($contents, $language);
	}

	/**
	 * Get all content based on the given content type ,
	 * language and status.
	 * 
	 * @param  string  $contentTypeName
	 * @param  string  $language
	 * @param  string  $status
	 * @param  integer $perPage
	 * @return collection
	 */
	public function getAllContents($contentTypeName, $language = false, $status = 'published', $perPage = 15)
	{	
		/**
		 * Return the content type that match the given name with translations.
		 * @var contentType
		 */
		$contentType = \CMS::contentTypes()->first('content_type_name', $contentTypeName);
		if ($status == 'all')
		{
			$contents = \CMS::contentItems()->paginateBy('content_type_id', $contentType->id, $perPage);
		}
		else
		{
			$contents = $this->model->with($this->getRelations())->
		                              where('content_type_id', '=', $contentType->id)->
		                              where('status', '=', $status)->
		                              paginate($perPage);	
		}

		$contents = $this->getContentCommentsCount($contents);
		return $this->getContentTranslations($contents, $language);
	}

	/**
	 * Return the specified content with translations.
	 * 
	 * @param  integer $id
	 * @param  string  $language
	 * @return object
	 */
	public function getContent($id, $language = false)
	{
		$contents = $this->getContentCommentsCount($this->find($id));
		return $this->getContentTranslations($this->find($id), $language);
	}

	/**
	 * Return the content comment count, if the obj of type 
	 * LengthAwarePaginator then it is a collection of 
	 * objects else it is a single object.
	 * 
	 * @param  object $obj
	 * @return object
	 */
	public function getContentCommentsCount($obj)
	{
		if ($obj instanceof \Illuminate\Pagination\LengthAwarePaginator || $obj instanceof \Illuminate\Database\Eloquent\Collection) 
		{
			foreach ($obj as $element) 
			{
				$element->commentsCount = \CMS::comments()->getAllItemCommentsCount($element->id, 'content');
			}
		}
		else
		{
			$obj->commentsCount = \CMS::comments()->getAllItemCommentsCount($obj->id, 'content');
		}
		return $obj;
	}

	/**
	 * Return the content translated data based on the 
	 * given language , if the obj of type LengthAwarePaginator
	 * then it is a collection of objects else it is a single
	 * object.
	 * 
	 * @param  object $obj
	 * @param  string $language
	 * @return object 
	 */
	public function getContentTranslations($obj, $language)
	{
		if ($obj instanceof \Illuminate\Pagination\LengthAwarePaginator || $obj instanceof \Illuminate\Database\Eloquent\Collection) 
		{
			foreach ($obj as $element) 
			{
				$element->data = \CMS::languageContents()->getTranslations($element->id, 'content', $language);
			}
		}
		else
		{
			$obj->data = \CMS::languageContents()->getTranslations($obj->id, 'content', $language);
		}
		return $obj;
	}

	/**
	 * Store the content and it's translations in to the storage.
	 * 
	 * @param  array $data 
	 * @return object
	 */
	public function createContent($data)
	{	
		$contentItem = $this->create($data);
		\CMS::languageContents()->insertLanguageContent([
				'title'       => $data['title'],
				'description' => $data['description'], 
				'content'     => $data['content'],
				], 'content', $contentItem->id);

		return $contentItem;
	}

	/**
	 * Update the content and it's translations in to the storage.
	 * 
	 * @param  integer $id
	 * @param  array   $data
	 * @return object
	 */
	public function updateContent($id, $data)
	{
		$this->update($id, $data);
		\CMS::languageContents()->insertLanguageContent([
				'title'       => $data['title'],
				'description' => $data['description'], 
				'content'     => $data['content'],
				], 'content', $this->find($id));

		return $this->find($id);
	}

	/**
	 * Replace with the given list of album ids to
	 * the given object.
	 * 
	 * @param object $obj
	 * @param array  $ids
	 * @return void
	 */
	public function addContentAlbums($obj, $ids)
	{
		$albums              = unserialize($obj->content_albums) ?: array();
		$albums              = array_unique(array_merge($albums, $ids));
		$obj->content_albums = serialize($albums);
		$obj->save();
	}

	/**
	 * Delete the given album id from the given object.
	 * 
	 * @param object $obj
	 * @param array  $ids
	 * @return void
	 */
	public function deleteContentAlbums($obj, $id)
	{
		$albums = unserialize($obj->content_albums);
		$key    = array_search($id, $albums);
		if ($key !== false)
		{
			unset($albums[$key]);
		} 

		$obj->content_albums = serialize($albums);
		$obj->save();
	}
}
