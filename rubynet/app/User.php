<?php

namespace App;

use App\Post;
use App\PostLike;
use App\Department;
use Laravel\Passport\HasApiTokens;
use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
   use Notifiable, SoftDeletes, HasApiTokens;

   
   protected $dates = ['deleted_at'];

    CONST VERIFIED_USER = '1';
    CONST UNVERIFIED_USER = '0';

    CONST ADMIN_USER = 'true';
    CONST REGULAR_USER = 'false';

    protected $table = 'users';

    public $transformer = UserTransformer::class;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'first_name_kana',
        'last_name_kana',
        'nick_name',
        'current_job',
        'former_job',
        'hobbies',
        'location',
        'birth_place',
        'student_circles',
        'one_word',
        'picture',
        'description',
        'entry_date',
        'date_of_birth',
        'internal_phone_number',       
        'email', 
        'password',
        'verified',
        'verification_token',
        'admin',
        'department_id',
        'job_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token',
    ];

    public function setEmailAttribute($email){
        $this->attributes['email'] = strtolower($email);
    }

    public function isVerified(){
        return $this->verified == User::VERIFIED_USER;
    }

    public function isAdmin(){
        return $this->admin == User::ADMIN_USER;
    }

    public function isManager(){
        return $this->manager == User::MANAGER_USER;
    }

     public function posts(){
        return $this->hasMany(Post::class);
    }

    public function postsLikes(){
        return $this->hasMany(PostLike::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function manager(){
        return $this->belongsTo(User::class);
    }

    public static function generateVerificationCode()
    {
        return str_random(40);
    }   
}
