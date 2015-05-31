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

	/**
	 * Get all content Types based on the given theme.
	 * If the theme isn't given then get the default
	 * theme.
	 * 
	 * @param  string $theme
	 * @return collection
	 */
	public function getAllContentTypes($theme = false)
	{	
		$theme = $theme ?: \CMS::coreModules()->getActiveTheme()->module_key;
		return $this->findBy('theme', $theme);
	}
	
	/**
	 * Return all the content items belong to the
	 * specified content type name.
	 * 
	 * @param  string $contentTypeName
	 * @return collection
	 */
	public function getAll($contentTypeName, $perPage)
	{
		return $this->first('content_type_name', $contentTypeName)->contentItems()->paginate($perPage);
	}
}
