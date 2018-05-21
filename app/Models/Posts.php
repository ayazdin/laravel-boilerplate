<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    /**
     * Get the meta values for the post.
     */
    public function postmeta()
    {
        return $this->hasMany('App\Models\Postmeta', 'postid');
    }
}
