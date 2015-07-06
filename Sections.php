<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model {

	/**
     * Spescify the storage table.
     * 
     * @var table
     */
	protected $table    = 'sections';

	/**
     * Specify the fields allowed for the mass assignment.
     * 
     * @var fillable
     */
	protected $fillable = ['parent_id', 'section_type_id', 'section_image','is_active'];

	/**
	 * Specify what field should be castet to what.
	 * 
	 * @var casts
	 */
	protected $casts    = ['is_active' => 'boolean'];

	/**
	 * Get the name that will be displayed in the 
	 * menu link.
	 * 
	 * @return string
	 */
	public function getLinkNameAttribute()
	{
		return \CMS::sections()->getSection($this->attributes['id'])->data['title'];
	}

	 /**
     * Return the gallery object from the
     * stored gallery id of the section.
     * 
     * @return object
     */
    public function getSectionImageAttribute()
    {
        return \CMS::galleries()->find($this->attributes['section_image']);
    }

	/**
	 * Get True or False based on the value
	 * of is active field.
	 * 
	 * @param  integer $value 
	 * @return string
	 */
	public function getIsActiveAttribute($value)
	{
		return $value ? 'True' : 'False';
	}

	/**
     * Get the section content items.
     * 
     * @return collection
     */
	public function contentItems()
	{
		return $this->belongsToMany('App\Modules\Content\ContentItems', 
			                        'contents_sections', 
			                        'section_id', 
			                        'content_item_id')->withTimestamps();
	}

	/**
     * Get the section section type.
     * 
     * @return collection
     */
	public function sectionType()
	{
		return $this->belongsTo('App\Modules\Content\SectionTypes', 'section_type_id');
	}

	/**
	 * Get the section children.
	 * 
	 * @return collection
	 */
	public function children()
    {
        return $this->hasMany('App\Modules\Content\Sections', 'parent_id');
    }
	public static function boot()
	{
		parent::boot();

		/**
         * Remove content item related
         * to the deleted section.
         */
		Sections::deleting(function($section)
		{
			$section->contentItems()->detach();
		});
	}
}
