<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class ContentItems extends Model {

    protected $table    = 'content_items';
    protected $fillable = ['user_id', 'status', 'alias', 'content_image', 'content_views'];

    public function contentSections()
    {
        return $this->belongsToMany('App\Modules\Content\ContentSections', 
        	'content_relations', 
        	'item_id', 
        	'section_id')->withTimestamps();
    }

    public function contentTags()
    {
        return $this->belongsToMany('App\Modules\Content\ContentTags', 
        	'tags_relations',
        	'item_id',
        	'tag_id')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\Modules\Acl\AclUser');
    }
    
    public static function boot()
    {
        parent::boot();

        ContentItems::deleting(function($contentItem)
        {
            $contentItem->contentSections()->detach();
            $contentItem->contentTags()->detach();

            \LanguageRepository::deleteItemLanguageContents('content', $contentItem->id);
            \AclRepository::deleteItemPermissions('content', $contentItem->id);
        });

        ContentItems::created(function($contentItem)
        {
           \AclRepository::insertDefaultItemPermissions('content', $contentItem->id);
        });
    }
}
