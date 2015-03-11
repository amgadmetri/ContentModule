<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class ContentItems extends Model {

    protected $table    = 'content_items';
    protected $fillable = ['user_id', 'status', 'alias', 'post_image', 'post_views'];

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

    public function languageContents()
    {
        return $this->hasMany('App\Modules\Language\LanguageContent', 'item_id');
    }
    
    public static function boot()
    {
        parent::boot();

        ContentItems::deleting(function($contentItem)
        {
            foreach ($contentItem->languageContents as  $languageContent) 
            {
                $languageContent->languageContentData()->delete();
            }   
            $contentItem->languageContents()->delete();
            $contentItem->contentSections()->detach();
            $contentItem->contentTags()->detach();
            \AclRepository::deleteItemPermissions('content', $contentItem->id);
        });

        ContentItems::created(function($contentItem)
        {
           \AclRepository::insertDefaultItemPermissions('content', $contentItem->id);
        });
    }
}
