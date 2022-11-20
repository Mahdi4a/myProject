<?php

namespace Modules\Comment\Http\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Comment\Entities\Comment;
use Modules\Product\Entities\Product;

//use Your Model

/**
 * Class CommentRepository.
 */
class ClientCommentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Comment::class;
    }

    public function createComment($request)
    {
        $product = Product::query()->find($request->comment_id);
        $product->comments()->create([
            'comment' => $request->comment,
            'user_id' => $request->user()->id,
            'parent_id' => $request->parent_id,
        ]);
    }
}
