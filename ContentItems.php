<?php namespace App\Modules\Content;

use Illuminate\Database\Eloquent\Model;

class ContentItems extends Model {

    /**
     * Spescify the storage table.
     * 
     * @var table
     */
    protected $table    = 'content_items';

    /**
     * Specify the fields allowed for the mass assignment.
     * 
     * @var fillable
     */
    protected $fillable = ['user_id', 'status', 'alias', 'content_image', 'content_views', 'content_type_id'];

    /**
     * Return the gallery object from the
     * stored gallery id ib the content.
     * 
     * @return object
     */
    public function getContentImageAttribute()
    {
        return \CMS::galleries()->find($this->attributes['content_image']);
    }

    /**
     * Get the content item sections.
     * 
     * @return collection
     */
    public function sections()
    {
        return $this->belongsToMany('App\Modules\Content\Sections', 
        	                        'contents_sections', 
        	                        'content_item_id', 
        	                        'section_id')->withTimestamps();
    }

    /**
     * Get the content item tags.
     * 
     * @return collection
     */
    public function tags()
    {
        return $this->belongsToMany('App\Modules\Content\Tags', 
        	                        'contents_tags',
        	                        'content_item_id',
        	                        'tag_id')->withTimestamps();
    }

    /**
     * Get the content item user.
     * 
     * @return collection
     */
    public function user()
    {
        return $this->belongsTo('App\Modules\Acl\AclUser');
    }

    /**
     * Get the content item content type.
     * 
     * @return collection
     */
    public function contentType()
    {
        return $this->belongsTo('App\Modules\Content\ContentTypes', 'content_type_id');
    }
    
    public static function boot()
    {
        parent::boot();

        /**
         * Remove the sections , tags
         * translations and permissions
         * related to the deleted content item.
         */
        ContentItems::deleting(function($contentItem)
        {
            $contentItem->sections()->detach();
            $contentItem->tags()->detach();

            \CMS::languageContents()->deleteItemLanguageContents('content', $contentItem->id);
            \CMS::permissions()->deleteItemPermissions('content', $contentItem->id);
        });

        /**
         * Insert default permissions for the
         * created content item.
         */
        ContentItems::created(function($contentItem)
        {
           \CMS::permissions()->insertDefaultItemPermissions('content', $contentItem->id);
        });
    }
}
