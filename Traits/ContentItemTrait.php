<?php namespace App\Modules\Content\Traits;

use App\Modules\Content\ContentItems;
use App\Modules\Content\ContentLanguagesVars;
use LanguageRepository;

trait ContentItemTrait{

	public function getAllContents($status = 'published')
	{
		if ($status == 'all') 
		{
			return ContentItems::with(['contentSections', 'contentTags', 'user'])->paginate('3');
		}

		return ContentItems::where('status', '=', $status)->
		                     with(['contentSections', 'contentTags', 'user'])->
		                     paginate('3');
	}

	public function getAllContentsWithData($language = false)
	{
		$language = $language ?: LanguageRepository::getDefaultLanguage()->key;
		$contents =  $this->getAllContents();
		
		foreach ($contents as $content) 
		{
			$content->data = $this->getContentData($content, $language);
		}
		return $contents;
	}

	public function getContent($id)
	{
		return ContentItems::with(['contentSections', 'contentTags', 'user'])->find($id);
	}

	public function getContentWithData($id, $language = false)
	{
		$content       = $this->getContent($id);
		$content->data = $this->getContentData($content, $language);

		return $content;
	}

	public function getContentData($obj, $language = false)
	{
		$language = $language ?: LanguageRepository::getDefaultLanguage()->key;
		return LanguageRepository::getContent($obj->id, 'content', $language);
	}

	public function createContent($data)
	{
		$contentItem = ContentItems::create($data);
		
		LanguageRepository::createLanguageContent([
			'title'       => ['title', 'description', 'content'],
			'key'         => ['title', 'description', 'content'], 
			'value'       => [$data['title'], $data['description'], $data['content']],
			'language_id' => LanguageRepository::getDefaultLanguage()->id
			], 'content', $contentItem->id);

		return $contentItem;
	}

	public function updateContent($id, $data)
	{
		$contentItem  = $this->getContent($id);
		$languageData = LanguageRepository::createLanguageContent([
			'title'       => ['title', 'description', 'content'],
			'key'         => ['title', 'description', 'content'], 
			'value'       => [$data['title'], $data['description'], $data['content']],
			'language_id' => LanguageRepository::getDefaultLanguage()->id
			], 'content', $id);
		
		$contentItem->update(array_merge($languageData, ['alias' => $data['alias'], 'status' => $data['status'], 'user_id' => $data['user_id']]));

		return $contentItem;
	}

	public function deleteContent($id)
	{	
		$contentItem = $this->getContent($id);
		return $contentItem->delete();
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
}