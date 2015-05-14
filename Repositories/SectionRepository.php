<?php namespace App\Modules\Content\Repositories;

use App\AbstractRepositories\AbstractRepository;
use App\Modules\Content\ContentSections;
use DB;

class SectionRepository extends AbstractRepository
{
	protected function getModel()
	{
		return 'App\Modules\Content\ContentSections';
	}

	protected function getRelations()
	{
		return ['contentItems', 'contentSectionType'];
	}

	public function addSections($obj, $data)
	{
		$this->deleteSections($obj);
		return $obj->contentSections()->attach($data);
	}

	public function deleteSections($obj)
	{
		return $obj->contentSections()->detach();
	}

	public function SectionIsActive($id)
	{
		return	$this->find($id)->is_active;
	}

	public function searchSection($query)
	{
		return DB::table('content_relations')->
				whereIn(
				'section_id', 
				ContentSections::where('section_name', 'like', '%' . $query . '%')->lists('id')
				)->lists('item_id');
	}

	public function getSectionContentsWithData($id, $language = false, $perPage = 15)
	{
		$contentSection = $this->find($id);
		$contents       = $contentSection->contentItems()->paginate($perPage);

		foreach ($contents as $content) 
		{
			$content->data = \CMS::contentItems()->getContentData($content, $language);
		}
		return $contents;
	}

	public function getSectionTree($link = '', $ulClass = 'nav nav-pills', $liClass = '', $parent_id = 0)
	{
		$sectionType = \CMS::sectionTypes()->getAllCategories();
		$html        = '';
		foreach ($sectionType->contentSections as $section) 
		{
			if ($section->parent_id == $parent_id) 
			{
				$html .= 
				"<li class='$liClass'>
					<a href='$link/$section->id'>
						$section->section_name  
					</a>
					<ul class='$ulClass'>
						{$this->getSectionTree($link, $ulClass, $liClass, $section->id)}
					</ul>
				</li>";
			}
		}
		return $html;
	}
}
