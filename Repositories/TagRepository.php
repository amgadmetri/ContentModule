<?php namespace App\Modules\Content\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;
use DB;

class TagRepository extends AbstractRepository
{	
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Content\Tags';
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
	 * Get a listing of tags when tag name match
	 * the given query.
	 * 
	 * @param  string $query
	 * @return array
	 */
	public function search($query)
	{
		return DB::table('contents_tags')->
				   whereIn('tag_id', $this->model->where('tag_name', 'like', '%' . $query . '%')->lists('id'));
	}

	/**
	 * Return the content item related to that tag.
	 * 
	 * @param  integer $id
	 * @param  string  $language 
	 * @param  integer $perPage
	 * @return collection
	 */
	public function getTagContents($contentTypeName, $id, $language = false, $status = 'published', $perPage = 15)
	{
		/**
		 * Return the content type that match the given name.
		 * @var contentType
		 */
		$contentType = \CMS::contentTypes()->first('content_type_name', $contentTypeName);
		$tag         = $this->find($id);
		if ($status == 'all')
		{
			$contents = $tag ? $tag->contentItems()->
		                             where('content_type_id', '=', $contentType->id)->
		                             paginate($perPage) : [];
		}
		else
		{
			$contents = $tag ? $tag->contentItems()->
		                             where('content_type_id', '=', $contentType->id)->
		                             where('status', '=', $status)->
		                             paginate($perPage) : [];
		}
		return \CMS::contentItems()->getContentTranslations($contents, $language);
	}

	/**
	 * If a tag exists with that name then return
	 * it else create new one.
	 * 
	 * @param  array $data 
	 * @return object
	 */
	public function createTag($data)
	{
		return $this->model->firstOrCreate(['tag_name' => $data['tag_name']]);
	}

	/**
	 * Replace with the given list of tags to
	 * the given object.
	 * 
	 * @param object $obj
	 * @param array  $data
	 * @return void
	 */
	public function addTags($obj, $data = array())
	{
		$this->deleteTags($obj);
		if ($data) 
		{
			foreach ($data as $tag) 
			{
				$tag = $this->createTag(['tag_name' => $tag]);
				$obj->Tags()->attach($tag->id);
			}
		}
	}

	/**
	  * Delete all tags from the given object.
	 * 
	 * @param  object $obj
	 * @return void
	 */
	public function deleteTags($obj)
	{
		return $obj->Tags()->detach();
	}
}
