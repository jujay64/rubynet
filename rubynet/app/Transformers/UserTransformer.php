<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier' => (int)$user->id,
            'firstName' => (string)$user->first_name,
            'firstNameYomikata' => (string)$user->first_name_kana,
            'lastNameYomikata' => (string)$user->last_name_kana,
            'lastName' => (string)$user->last_name,
            'nickName' => (string)$user->nick_name,
            'currentJob' => (string)$user->current_job,
            'formerJob' => (string)$user->former_job,
            'hobbies' => (string)$user->hobbies,
            'location' => (string)$user->location,
            'placeOfBirth' => (string)$user->birth_place,
            'studentCircles' => (string)$user->student_circles,
            'oneWord' => (string)$user->one_word,
            'picture' => url('storage/profile/'.$user->picture),
            'description' => (string)$user->description,
            'entryDate' =>  (string)$user->entry_date,
            'dateOfBirth' =>  (string)$user->date_of_birth,
            'internalPhoneNumber' => (string)$user->internal_phone_number,
            'email' => (string)$user->email, 
            'isVerified' => (int)$user->verified,
            'isAdmin' => ($user->admin === 'true'),
            'department' => (int)$user->department_id,
            'departmentName' => (string)$user->department->name,
            'role' => (int)$user->role_id,
            'job' => (int)$user->job_id,
            'postsCount' => (int)$user->posts_count,
            'commentsCount' => (int)$user->comments_count,
            'likesCount' => (int)$user->posts_likes_count,
            'creationDate' =>  (string)$user->created_at,
            'lastChangedDate' =>  (string)$user->updated_at,
            'deletedDate' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
            'links' =>
            [
                [
                    'rel' => 'self',
                    'href' => route('users.show',$user->id)
                ],
                [
                    'rel' => 'user.posts',
                    'href' => route('users.posts.index',$user->id)
                ]
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'firstName' => 'first_name',
            'firstNameYomikata' => 'first_name_kana',
            'lastNameYomikata' => 'last_name_kana',
            'lastName' => 'last_name',
            'nickName' => 'nick_name',
            'currentJob' => 'current_job',
            'formerJob' => 'former_job',
            'hobbies' => 'hobbies',
            'location' => 'location',
            'placeOfBirth' => 'birth_place',
            'studentCircles' => 'student_circles',
            'oneWord' => 'one_word',
            'password' => 'password',
            'picture' => 'picture',
            'description' => 'description',
            'entryDate' =>  'entry_date',
            'dateOfBirth' =>  'date_of_birth',
            'internalPhoneNumber' => 'internal_phone_number',
            'email' => 'email', 
            'isVerified' => 'verified',
            'isAdmin' => 'admin',
            'department' => 'department_id',
            'role' => 'role_id',
            'job' => 'job_id',
            'creationDate' =>  'created_at',
            'lastChangedDate' =>  'updated_at',
            'deletedDate' => 'deleted_at',         
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
        'id' => 'identifier',
        'first_name' => 'firstName',
        'first_name_kana' => 'firstNameYomikata',
        'last_name_kana' => 'lastNameYomikata',
        'last_name' => 'lastName',
        'nick_name' => 'nickName',
        'current_job' => 'currentJob',
        'former_job' => 'formerJob',
        'hobbies' => 'hobbies',
        'location' => 'location',
        'birth_place' => 'placeOfBirth',
        'student_circles' => 'studentCircles',
        'one_word' => 'oneWord',
        'password' => 'password',
        'picture' => 'picture',
        'description' => 'description',
        'entry_date' => 'entryDate',
        'date_of_birth' => 'dateOfBirth',
        'internal_phone_number' => 'internalPhoneNumber',
        'email' => 'email', 
        'verified' => 'isVerified',
        'admin' =>  'isAdmin',
        'department_id' => 'department',
        'role_id' => 'role',
        'job_id' => 'job',
        'created_at' => 'creationDate',
        'updated_at' => 'lastChangedDate',
        'deleted_at' => 'deletedDate' ,             
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
