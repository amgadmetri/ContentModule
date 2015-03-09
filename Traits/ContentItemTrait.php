<?php namespace App\Modules\Content\Traits;

use App\Modules\Content\ContentItems;
use App\Modules\Content\ContentLanguagesVars;

trait ContentItemTrait{

	public function getAllContents()
	{
		return ContentItems::all();
	}

	public function getContent($id)
	{
		return ContentItems::find($id);
	}

	public function createContent($data)
	{
		$contentLanguagesVars = ContentLanguagesVars::create($data);
		$contentItem          = ContentItems::create($data);
		$contentItem->contentLanguagesVars()->save($contentLanguagesVars);

		return $contentItem;
	}

	public function updateContent($id, $data)
	{
		$contentItem          = $this->getContent($id);
		$contentLanguagesVars = $contentItem->contentLanguagesVars->first();

		$contentLanguagesVars->update($data);
		$contentItem->update($data);

		return $contentItem;
	}

	public function deleteContent($id)
	{	
		$contentItem = $this->getContent($id);
		return $contentItem->delete();
	}
}