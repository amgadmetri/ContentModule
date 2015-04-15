<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class ContentSectionTypes extends Model {

	protected $table    = 'content_section_types';
	protected $fillable = ['section_type_name'];

	public function contentSections()
	{
		return $this->hasMany('App\Modules\Content\ContentSections', 'section_type_id');
	}

	public static function boot()
	{
		parent::boot();

		ContentSectionTypes::deleting(function($contentSectionTypes)
		{
			$contentSectionTypes->contentSections()->delete();
		});
	}
}
