<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\UserTreeTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTree extends Model
{
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   public $transformer = UserTreeTransformer::class;

   protected $fillable = [
        'left',
        'right',
        'user_id',
        'manager_id',
    ];

   public function userDown(){
    	return $this->belongsTo(User::class);
    }

   public function userUp(){
    	return $this->belongsTo(User::class);
    }
}
