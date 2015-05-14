<?php namespace App\Modules\Content\Repositories;

use App\AbstractRepositories\AbstractRepository;
use App\Modules\Content\ContentItems;

class ContentItemRepository extends AbstractRepository
{
	protected function getModel()
	{
		return 'App\Modules\Content\ContentItems';
	}

	protected function getRelations()
	{
		return ['contentSections', 'contentTags', 'user'];
	}

	public function getAllContents($status = 'published', $perPage = 15)
	{
		if ($status == 'all')
		{
			return $this->paginate($perPage);
		}
		return $this->paginateBy('status', $status, $perPage);
	}

	public function getAllContentsWithData($language = false, $status = 'published', $perPage = 15)
	{
		$contents =  $this->getAllContents($status = 'published', $perPage = 15);
		
		foreach ($contents as $content) 
		{
			$content->data = $this->getContentData($content, $language);
		}
		return $contents;
	}

	public function getContentWithData($id, $language = false)
	{
		$content       = $this->find($id);
		$content->data = $this->getContentData($content, $language);

		return $content;
	}

	public function getContentData($obj, $language = false)
	{
		return \CMS::languageContents()->getContent($obj->id, 'content', $language);
	}

	public function createContent($data)
	{
		$contentItem = $this->create($data);
		\CMS::languageContents()->createLanguageContent([
			'title'       => ['title', 'description', 'content'],
			'key'         => ['title', 'description', 'content'], 
			'value'       => [$data['title'], $data['description'], $data['content']],
			'language_id' => \CMS::languages()->getDefaultLanguage()->id
			], 'content', $contentItem->id);

		return $contentItem;
	}

	public function updateContent($id, $data)
	{
		$languageData = \CMS::languageContents()->createLanguageContent([
			'title'       => ['title', 'description', 'content'],
			'key'         => ['title', 'description', 'content'], 
			'value'       => [$data['title'], $data['description'], $data['content']],
			'language_id' => \CMS::languages()->getDefaultLanguage()->id
			], 'content', $id);

		return $this->update($id, array_merge($languageData, $data));
	}

	public function addContentAlbums($obj, $ids)
	{
		$albums              = unserialize($obj->content_albums) ?: array();
		$albums              = array_unique(array_merge($albums, $ids));
		$obj->content_albums = serialize($albums);
		$obj->save();

		return $obj;
	}

	public function deleteContentAlbums($obj, $id)
	{
		$albums = unserialize($obj->content_albums);
		$key    = array_search($id, $albums);

		if ($key !== false)
		{
			unset($albums[$key]);
		} 

		$obj->content_albums = serialize($albums);
		return $obj->save();
	}

	public function search($query)
	{	
		$contents = ContentItems::whereIn('id', \CMS::languageContents()->search($query, 'content'))->
		            orWhereIn('user_id', \CMS::users()->search($query))->
		            orWhereIn('id', \CMS::sections()->searchSection($query))->
		            orWhereIn('id', \CMS::tags()->searchTag($query))->paginate(1);

		foreach ($contents as $content) 
		{
			$content->data = $this->getContentData($content, \Lang::locale());
		}
		return $contents;
	}
}
