<?php namespace App\Modules\Content\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

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
		return ['contentItems', 'sectionTypes'];
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

	/**
	 * Store the content type and it's section types 
	 * in to the storage.
	 * 
	 * @param  array $data 
	 * @return void
	 */
	public function createContentTypes($data)
	{	
		foreach ($data as $contentTypeData) 
		{
			$contentType = $this->create($contentTypeData);
			if (array_key_exists('section_types', $contentTypeData)) 
			{
				foreach ($contentTypeData['section_types'] as $sectionTypeData) 
				{
					\CMS::sectionTypes()->create(['section_type_name' => $sectionTypeData])->
					                      contentTypes()->
					                      attach($contentType->id);
				}
			}
		}
	}
}
