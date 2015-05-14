<?php namespace App\Modules\Content\Repositories;

use App\AbstractRepositories\AbstractRepository;

class SectionTypeRepository extends AbstractRepository
{
	protected function getModel()
	{
		return 'App\Modules\Content\ContentSectionTypes';
	}

	protected function getRelations()
	{
		return ['contentSections'];
	}

	public function getAllCategories()
	{
		return $this->findBy('section_type_name', 'Category')[0];
	}
}
