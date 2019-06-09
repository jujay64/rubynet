<?php

namespace App;

use App\User;
use App\Comment;
use App\Transformers\PostTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   public $transformer = PostTransformer::class;

   protected $fillable = [
        'title', 
        'content', 
        'like_count',
        'comment_count',
        'user_id',
    ];

    public function comments(){
    	return $this->hasMany(Comment::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
