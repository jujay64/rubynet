<?php

namespace App;

use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\DepartmentManagerTransformer;

class DepartmentManager extends Model
{
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   public $transformer = DepartmentManagerTransformer::class;

   protected $fillable = [
        'user_id',
        'department_id',
    ];

   public function user(){
    	return $this->belongsTo(User::class);
    }

   public function post(){
    	return $this->belongsTo(Post::class);
    }
}
