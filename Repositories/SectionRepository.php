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
	public function getSectionContents($id, $language = false, $perPage = 15)
	{
		$contents = $this->find($id)->contentItems()->paginate($perPage);
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
	public function getSectionTree($link = '', $parent_id = 0)
	{
		$sectionType = \CMS::sectionTypes()->first('section_type_name', 'Categories');
		$link        = $link ?: url('category');
		$html        = '';
		
		if ($sectionType) 
		{
			foreach ($sectionType->sections as $section) 
			{
				if ($section->parent_id == $parent_id) 
				{
					$html .= view('content::sections.parts.categorytemplate', compact('section', 'link'))->render();
				}
			}
		}
		return $html;
	}
}
