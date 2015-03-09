<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class ContentTags extends Model {

	protected $table    = 'content_tags';
	protected $fillable = ['tag_content'];

	public function contentItems()
    {
        return $this->belongsToMany('App\Modules\Content\ContentItems', 
        	'tags_relations',
        	'tag_id',
        	'item_id')->withTimestamps();
    }

    public static function boot()
	{
		parent::boot();

		ContentTags::deleting(function($contentTags)
		{
			$contentTags->contentItems()->detach();
		});
	}

}
