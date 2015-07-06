<?php namespace App\Modules\Content\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;
use DB;

class SectionRepository extends AbstractRepository
{	
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Content\Sections';
	}

	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['contentItems', 'sectionType', 'children'];
	}

	/**
	 * Get a listing of sections when section name match
	 * the given query.
	 * 
	 * @param  string $query
	 * @return array
	 */
	public function search($query)
	{
		return DB::table('contents_sections')->
				   whereIn('section_id', $this->model->where('section_name', 'like', '%' . $query . '%')->lists('id'));
	}

	/**
	 * Get all sections based on the given section type
	 * and language.
	 * 
	 * @param  string  $contentTypeName
	 * @param  string  $language
	 * @param  string  $status
	 * @param  integer $perPage
	 * @return collection
	 */
	public function getAllSections($sectionTypeName, $language = false, $perPage = 15)
	{	
		/**
		 * Return the section type that match the given name.
		 * @var contentType
		 */
		$sectionType = \CMS::sectionTypes()->first('section_type_name', $sectionTypeName);
		$sections    = $this->paginateBy('section_type_id', $sectionType->id, $perPage);

		return $this->getSectionTranslations($sections, $language);
	}

	/**
	 * Return the specified section with translations.
	 * 
	 * @param  integer $id
	 * @param  string  $language
	 * @return object
	 */
	public function getSection($id, $language = false)
	{
		$section = $this->find($id);
		return $this->getSectionTranslations($section, $language);
	}

	/**
	 * Return the section translated data based on the 
	 * given language , if the obj of type LengthAwarePaginator
	 * then it is a collection of objects else it is a single
	 * object.
	 * 
	 * @param  object $obj
	 * @param  string $language
	 * @return object 
	 */
	public function getSectionTranslations($obj, $language)
	{
		if ($obj instanceof \Illuminate\Pagination\LengthAwarePaginator || $obj instanceof \Illuminate\Database\Eloquent\Collection) 
		{
			foreach ($obj as $element) 
			{
				$element->data = \CMS::languageContents()->getTranslations($element->id, 'section', $language);
			}
		}
		else
		{
			$obj->data = \CMS::languageContents()->getTranslations($obj->id, 'section', $language);
		}
		return $obj;
	}

	/**
	 * Store the section and it's translations in to the storage.
	 * 
	 * @param  array $data 
	 * @return object
	 */
	public function createSection($data)
	{	
		$section = $this->create($data);
		\CMS::languageContents()->insertLanguageContent([
				'title'       => $data['title'],
				'description' => $data['description'],
				], 'section', $section->id);

		return $section;
	}

	/**
	 * Update the section and it's translations in to the storage.
	 * 
	 * @param  integer $id
	 * @param  array   $data
	 * @return object
	 */
	public function updateSection($id, $data)
	{
		$this->update($id, $data);
		\CMS::languageContents()->insertLanguageContent([
				'title'       => $data['title'],
				'description' => $data['description'], 
				], 'section', $this->find($id));

		return $this->getSection($id);
	}

	/**
	 * Replace with the given list of section ids to
	 * the given object.
	 * 
	 * @param object $obj
	 * @param array  $data
	 * @return void
	 */
	public function addSections($obj, $data)
	{
		$this->deleteSections($obj);
		return $obj->sections()->attach($data);
	}

	/**
	  * Delete all sections from the given object.
	 * 
	 * @param  object $obj
	 * @return void
	 */
	public function deleteSections($obj)
	{
		return $obj->sections()->detach();
	}

	/**
	 * Check if the section is active or not.
	 * 
	 * @param  integer $id
	 * @return boolean
	 */
	public function SectionIsActive($id)
	{
		return	$this->find($id)->is_active;
	}

	/**
	 * Return the content item related to that section.
	 * 
	 * @param  integer $id
	 * @param  string  $language 
	 * @param  integer $perPage
	 * @return collection
	 */
	public function getSectionContents($contentTypeName, $id, $language = false, $status = 'published', $perPage = 15)
	{
		/**
		 * Return the content type that match the given name.
		 * @var contentType
		 */
		$contentType = \CMS::contentTypes()->first('content_type_name', $contentTypeName);
		$section     = $this->find($id);
		if ($status == 'all')
		{
			$contents = $section ? $section->contentItems()->
		                              		 where('content_type_id', '=', $contentType->id)->
		                                     paginate($perPage) : [];
		}
		else
		{
			$contents = $section ? $section->contentItems()->
		                              		 where('content_type_id', '=', $contentType->id)->
		                                     where('status', '=', $status)->
		                                     paginate($perPage) : [];
		}
		return \CMS::contentItems()->getContentTranslations($contents, $language);
	}

	/**
	 * Recursive function that build the category tree.
	 *  
	 * @param  string  $link      The route link to
	 *                            display the category
	 * @param  integer $parent_id
	 * @return string
	 */
	public function getSectionTree($sectionTypeName, $path = false, $language = false, $perPage = 15, $parent_id = 0)
	{
		$themeName = \CMS::CoreModules()->getActiveTheme()->module_key;
		$sections  = $this->getAllSections($sectionTypeName, $language, $perPage);
		$path      = $path ? $themeName . "::" . $path : 'content::sections.parts.categorytemplate';
		$html      = '';
		
		foreach ($sections as $section) 
		{
			if ($section->parent_id == $parent_id) 
			{
				$html .= view($path, compact('section', 'path', 'sectionTypeName', 'language', 'perPage'))->render();
			}
		}
		return $html;
	}
}
