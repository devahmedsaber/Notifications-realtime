<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['post_id', 'user_id', 'comment', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = true;

    // Relation With Users
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    // Relation With Posts
    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

}
