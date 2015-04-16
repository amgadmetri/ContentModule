<?php namespace App\Modules\Content\Traits;

use App\Modules\Content\ContentItems;
use App\Modules\Content\ContentLanguagesVars;
use LanguageRepository;

trait ContentItemTrait{

	public function getAllContents()
	{
		return ContentItems::with(['contentSections', 'contentTags', 'user'])->get();
	}

	public function getAllContentsWithData($language = false)
	{
		$language = $language ?: LanguageRepository::getDefaultLanguage()->key;
		$contents =  ContentItems::with(['contentSections', 'contentTags', 'user'])->paginate(1);
		
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
		$contentItem = $this->getContent($id);
		$data        = LanguageRepository::createLanguageContent([
			'title'       => ['title', 'description', 'content'],
			'key'         => ['title', 'description', 'content'], 
			'value'       => [$data['title'], $data['description'], $data['content']],
			'language_id' => LanguageRepository::getDefaultLanguage()->id
			], 'content', $id);

		$contentItem->update($data);

		return $contentItem;
	}

	public function deleteContent($id)
	{	
		$contentItem = $this->getContent($id);
		return $contentItem->delete();
	}
}