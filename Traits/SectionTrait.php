<?php namespace App\Modules\Content\Traits;

use App\Modules\Content\ContentSections;
use DB;

trait SectionTrait{

	public function searchSection($query)
	{
		return DB::table('content_relations')->
				whereIn(
				'section_id', 
				ContentSections::where('section_name', 'like', '%' . $query . '%')->lists('id')
				)->lists('item_id');
	}

	public function getSectionContentsWithData($id, $language = false)
	{
		$contentSection = ContentSections::find($id);
		$contents       = $contentSection->contentItems()->paginate(1);

		foreach ($contents as $content) 
		{
			$content->data = $this->getContentData($content, $language);
		}
		return $contents;
	}

	public function getSectionTree($link = '', $ulClass = 'nav nav-pills', $liClass = '', $parent_id = 0)
	{
		$sections = $this->getAllSections();
		$html     = '';
		foreach ($sections as $section) 
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

	public function getAllSections()
	{
		return ContentSections::with(['contentItems', 'contentSectionType'])->get();
	}

	public function getSection($id)
	{
		return ContentSections::find($id);
	}

	public function createSection($data)
	{
		return ContentSections::create($data);
	}

	public function updateSection($id, $data)
	{
		$section = $this->getSection($id);
		return $section->update($data);
	}

	public function deleteSection($id)
	{	
		$section = $this->getSection($id);
		return $section->delete();
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
		return	$this->getSection($id)->is_active;
	}
}