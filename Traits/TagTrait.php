<?php namespace App\Modules\Content\Traits;

use App\Modules\Content\ContentTags;
use \LanguageRepository;
use DB;

trait TagTrait{

	public function searchTag($query)
	{
		return DB::table('tags_relations')->
				whereIn(
				'tag_id', 
				ContentTags::where('tag_content', 'like', '%' . $query . '%')->lists('id')
				)->lists('item_id');
	}

	public function getTagContentsWithData($id, $language = false)
	{
		$contentTags = ContentTags::find($id);
		$contents    = $contentTags->contentItems()->paginate(1);

		foreach ($contents as $content) 
		{
			$content->data = $this->getContentData($content, $language);
		}
		return $contents;
	}

	public function getAllTags()
	{
		return ContentTags::with('contentItems')->get();
	}

	public function getTag($id)
	{
		return ContentTags::find($id);
	}

	public function createTag($data)
	{
		return ContentTags::firstOrCreate(['tag_content' => $data['tag_content']]);
	}

	public function updateTag($id, $data)
	{
		$tag = $this->getTag($id);
		return $tag->update($data);
	}

	public function deleteTag($id)
	{	
		$tag = $this->getTag($id);
		return $tag->delete();
	}

	public function getTagsWithNoContent($id)
	{
		$ids = DB::table('tags_relations')->where('item_id', '=', $id)->lists('tag_id');
		return ContentTags::whereNotIn('id', $ids)->get();
	}

	public function addTags($obj, $data)
	{
		$this->deleteTags($obj);

		if($data)
		{
			foreach ($data as $tag) 
			{
				$contentTag = ContentTags::firstOrCreate(['tag_content' => $tag]);
				$obj->ContentTags()->attach($contentTag->id);
			}
		}
	}

	public function deleteTags($obj)
	{
		return $obj->ContentTags()->detach();
	}
}