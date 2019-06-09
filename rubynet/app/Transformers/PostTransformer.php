<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'identifier' => (int)$post->id,
            'user' => (int)$post->user_id,
            'title' => (string)$post->title,
            'content' => (string)$post->content,
            'likeCount' => (int)$post->like_count,
            'commentCount' => (int)$post->comment_count,
            'creationDate' =>  (string)$post->created_at,
            'lastChangedDate' =>  (string)$post->updated_at,
            'deletedDate' => isset($post->deleted_at) ? (string)$post->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
        'identifier' => 'id',
        'user' => 'user_id',
        'title' => 'title',
        'content' => 'content',
        'likeCount' => 'like_count',
        'commentCount' => 'comment_count',
        'creationDate' =>  'created_at',
        'lastChangedDate' =>  'updated_at',
        'deletedDate' =>'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
