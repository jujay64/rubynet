<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\DepartmentTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
   use SoftDeletes;
   protected $dates = ['deleted_at'];

   public $transformer = DepartmentTransformer::class;

    protected $fillable = [
    	'name',
    	'description'
    ];

    public function users()
    {
    	return $this->hasMany(User::class);
    }
}
