<?php namespace App\Modules\Content\Repositories;

use App\AbstractRepositories\AbstractRepository;

class ContentTypeRepository extends AbstractRepository
{	
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Content\ContentTypes';
	}

	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['contentItems'];
	}
}
