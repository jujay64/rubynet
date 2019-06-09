<?php

namespace App;

use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\PostLikeTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostLike extends Model
{
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   public $transformer = PostLikeTransformer::class;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function post(){
    	return $this->belongsTo(Post::class);
    }
}
