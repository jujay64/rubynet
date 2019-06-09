<?php

namespace App\Transformers;

use App\PostLike;
use League\Fractal\TransformerAbstract;

class PostLikeTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(PostLike $postLike)
    {
        return [
            'user' => (int)$postLike->user_id,
            'post' => (int)$postLike->post_id,
            'creationDate' =>  (string)$postLike->created_at,
            'lastChangedDate' =>  (string)$postLike->updated_at,
            'deletedDate' => isset($postLike->deleted_at) ? (string)$postLike->deleted_at : null,
        ];
    }
}
