<?php namespace App\Modules\Content\Repositories;

use App\AbstractRepositories\AbstractRepository;
use App\Modules\Content\ContentTags;
use DB;


class TagRepository extends AbstractRepository
{
	protected function getModel()
	{
		return 'App\Modules\Content\ContentTags';
	}

	protected function getRelations()
	{
		return ['contentItems'];
	}

	public function searchTag($query)
	{
		return DB::table('tags_relations')->
				whereIn('tag_id', ContentTags::where('tag_content', 'like', '%' . $query . '%')->lists('id')
				)->lists('item_id');
	}

	public function getTagContentsWithData($id, $language = false, $perPage = 15)
	{
		$contentTags = $this->find($id);
		$contents    = $contentTags->contentItems()->paginate($perPage);

		foreach ($contents as $content) 
		{
			$content->data = $this->getContentData($content, $language);
		}
		return $contents;
	}

	public function createTag($data)
	{
		return ContentTags::firstOrCreate(['tag_content' => $data['tag_content']]);
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
