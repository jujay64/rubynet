<?php

namespace App\Transformers;

use App\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Comment $comment)
    {
        return [
            'identifier' => (int)$comment->id,
            'user' => (int)$comment->user_id,
            'post' => (int)$comment->post_id,
            'creationDate' =>  (string)$comment->created_at,
            'lastChangedDate' =>  (string)$comment->updated_at,
            'deletedDate' => isset($comment->deleted_at) ? (string)$comment->deleted_at : null,
        ];
    }
}
