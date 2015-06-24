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
	protected $fillable = ['content_type_name', 'theme'];

	/**
	 * Get the name that will be displayed in the 
	 * menu link.
	 * 
	 * @return string
	 */
	public function getLinkNameAttribute()
	{
		return $this->attributes['content_type_name'];
	}

	/**
     * Get the content type content items.
     * 
     * @return collection
     */
	public function contentItems()
	{
		return $this->hasMany('App\Modules\Content\ContentItems', 'content_type_id');
	}

	/**
     * Get the content type section types.
     * 
     * @return collection
     */
    public function sectionTypes()
    {
        return $this->belongsToMany('App\Modules\Content\SectionTypes',
                                    'content_types_section_types',
                                    'content_type_id',
                                    'section_type_id')->withTimestamps();
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
