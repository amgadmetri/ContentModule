<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class ContentSections extends Model {

	protected $table    = 'content_sections';
	protected $fillable = ['parent_id', 'section_name','is_active'];
	protected $casts    = ['is_active' => 'boolean'];

	public function getIsActiveAttribute($value)
	{
		return $value ? 'True' : 'False';
	}

	public function contentItems()
	{
		return $this->belongsToMany('App\Modules\Content\ContentItems', 
			'content_relations', 
			'section_id', 
			'item_id')->withTimestamps();
	}

	public static function boot()
	{
		parent::boot();

		ContentSections::deleting(function($contentSection)
		{
			$contentSection->contentItems()->detach();
		});
	}
}
