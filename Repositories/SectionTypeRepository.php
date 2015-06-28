<?php namespace App\Modules\Content\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class SectionTypeRepository extends AbstractRepository
{	
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Content\SectionTypes';
	}

	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['sections', 'contentTypes'];
	}

	/**
	 * Return all the sections belong to the
	 * specified section type name.
	 * 
	 * @param  string $contentTypeName
	 * @return collection
	 */
	public function getAll($sectionTypeName, $perPage)
	{
		return $this->first('section_type_name', $sectionTypeName)->sections()->paginate($perPage);
	}
}
