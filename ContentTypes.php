<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class ContentTypes extends Model {

	/**
     * Spescify the storage table.
     * 
     * @var table
     */
	protected $table    = 'content_types';

    /**
     * Specify the fields allowed for the mass assignment.
     * 
     * @var fillable
     */
	protected $fillable = ['content_type_name'];

	/**
     * Get the content type content items.
     * 
     * @return collection
     */
	public function contentItems()
	{
		return $this->hasMany('App\Modules\Content\ContentItems', 'content_type_id');
	}

	public static function boot()
	{
		parent::boot();

		/**
         * Remove the content items related
         * to the deleted content type.
         */
		ContentTypes::deleting(function($contentTypes)
		{
			$contentTypes->contentItems()->delete();
		});
	}
}
