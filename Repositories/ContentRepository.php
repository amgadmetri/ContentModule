<?php namespace App\Modules\Content\Repositories;

use App\Modules\Content\Traits\ContentItemTrait;
use App\Modules\Content\Traits\SectionTrait;
use App\Modules\Content\Traits\TagTrait;

class ContentRepository
{
	use ContentItemTrait;
	use SectionTrait;
	use TagTrait;
}
