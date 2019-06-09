<?php

namespace App;

use App\Transformers\RoleTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   public $transformer = RoleTransformer::class;

    protected $fillable = [
    	'name',
    	'description'
    ];
}
