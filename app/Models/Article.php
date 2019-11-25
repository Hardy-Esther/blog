<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'title',
        'user_id',
        'body',
        'excerpt',
        'slug',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::Class, 'article_tags');
    }

}
