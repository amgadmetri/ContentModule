<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model {

	/**
     * Spescify the storage table.
     * 
     * @var table
     */
	protected $table    = 'tags';

	/**
     * Specify the fields allowed for the mass assignment.
     * 
     * @var fillable
     */
	protected $fillable = ['tag_name'];

    /**
     * Get the name that will be displayed in the 
     * menu link.
     * 
     * @return string
     */
    public function getLinkNameAttribute()
    {
        return $this->attributes['tag_name'];
    }

	/**
     * Get the tag content items.
     * 
     * @return collection
     */
	public function contentItems()
    {
        return $this->belongsToMany('App\Modules\Content\ContentItems', 
        	'contents_tags',
        	'tag_id',
        	'content_item_id')->withTimestamps();
    }

    public static function boot()
	{
		parent::boot();

		/**
         * Remove content item related
         * to the deleted tag.
         */
		Tags::deleting(function($tags)
		{
			$tags->contentItems()->detach();
		});
	}

}
