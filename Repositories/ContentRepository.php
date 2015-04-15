<?php namespace App\Modules\Content\Repositories;

use App\Modules\Content\Traits\ContentItemTrait;
use App\Modules\Content\Traits\SectionTypeTrait;
use App\Modules\Content\Traits\SectionTrait;
use App\Modules\Content\Traits\TagTrait;

use App\Modules\Content\ContentItems;

use \LanguageRepository;
use \AclRepository;

class ContentRepository
{
	use ContentItemTrait;
	use SectionTypeTrait;
	use SectionTrait;
	use TagTrait;

	public function search($query)
	{	
		$contents = ContentItems::whereIn('id', LanguageRepository::search($query))->
		            orWhereIn('user_id', AclRepository::search($query))->
		            orWhereIn('id', $this->searchSection($query))->
		            orWhereIn('id', $this->searchTag($query))->paginate(1);

		foreach ($contents as $content) 
		{
			$content->data = $this->getContentData($content, \Lang::locale());
		}
		return $contents;
	}
}
