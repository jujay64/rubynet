<?php

namespace App;

use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\CommentTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   public $transformer = CommentTransformer::class;

    protected $fillable = [ 
        'content', 
        'user_id',
        'post_id',
    ];

    public function post(){
    	return $this->belongsTo(Post::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
