<?php namespace App\Modules\Content\Traits;

use App\Modules\Content\ContentItems;
use App\Modules\Content\ContentLanguagesVars;
use LanguageRepository;

trait ContentItemTrait{

	public function getAllContents()
	{
		return ContentItems::all();
	}

	public function getContent($id)
	{
		return ContentItems::find($id);
	}

	public function getContentData($obj, $language = false)
	{
		$language = $language ?: LanguageRepository::getDefaultLanguage()->key;
		return LanguageRepository::getContent($obj, $language);
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
			]);

		$contentItem->update($data);

		return $contentItem;
	}

	public function deleteContent($id)
	{	
		$contentItem = $this->getContent($id);
		return $contentItem->delete();
	}
}