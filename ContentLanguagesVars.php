<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class ContentLanguagesVars extends Model {

	protected $table    = 'content_languages_vars';
	protected $fillable = ['title', 'description', 'content', 'item_id'];

	public function contentItems()
    {
        return $this->belongsTo('App\Modules\Content\ContentItems', 'item_id');
    }

}
