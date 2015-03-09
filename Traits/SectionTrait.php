<?php namespace App\Modules\Content\Traits;

use App\Modules\Content\ContentSections;
use DB;

trait SectionTrait{

	public function getAllSections()
	{
		return ContentSections::all();
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

	public function getSectionsWithNoContent($id)
	{
		$ids = DB::table('content_relations')->where('item_id', '=', $id)->lists('section_id');
		return ContentSections::whereNotIn('id', $ids)->get();
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