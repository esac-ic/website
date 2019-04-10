<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsItem extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'text',
        'image_url',
        'thumbnail_url',
        'author',
        'sticky_until',
    ];

    public function newsItemText(){
        return $this->hasOne('App\Text', 'id', 'text');
    }

    public function newsItemTitle()
    {
        return $this->hasOne('App\Text', 'id', 'title');
    }

    public function getImageUrl(){
        if($this->image_url != ""){
            return \Storage::disk('public')->url($this->image_url);
        } else {
            return "/img/header-3.jpg";
        }
    }

    public function getThumbnailUrl(){
        if($this->thumbnail_url != ""){
            return \Storage::disk('public')->url($this->thumbnail_url);
        } else {
            return "/img/header-3.jpg";
        }

    }

    /**
     * Applies an ordering where sticky elements are on top, given that they have not yet expired.
     * Sticky posts themselves are ordered indeterminately as to allow a later order rule to order them correctly.
     *
     * @param $query
     * @return mixed
     */
    public function scopeOrderSticky($query){
        return $query->orderByRaw('IF(`sticky_until` IS NULL OR `sticky_until` < NOW(), 1, 0)');
    }
}
