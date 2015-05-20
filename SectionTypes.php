<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class SectionTypes extends Model {

	/**
     * Spescify the storage table.
     * 
     * @var table
     */
	protected $table    = 'section_types';

	/**
     * Specify the fields allowed for the mass assignment.
     * 
     * @var fillable
     */
	protected $fillable = ['section_type_name'];

	/**
     * Get the section type sections.
     * 
     * @return collection
     */
	public function sections()
	{
		return $this->hasMany('App\Modules\Content\Sections', 'section_type_id');
	}

	public static function boot()
	{
		parent::boot();

		/**
         * Remove the sections related
         * to the deleted section type.
         */
		SectionTypes::deleting(function($sectionType)
		{
			$sectionType->sections()->delete();
		});
	}
}
