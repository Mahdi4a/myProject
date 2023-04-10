<?php

namespace Modules\Comment\Http\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Comment\Entities\Comment;

//use Your Model

/**
 * Class CommentRepository.
 */
class AdminCommentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Comment::class;
    }


    public function approvedCommentsWithPage($request)
    {
        $comments = $this->model->query()->whereApproved(1);
        $this->searchComments($request, $comments);
        return $comments->paginate(20);
    }

    public function unapprovedCommentsWithPage($request)
    {
        $comments = $this->model->query()->whereApproved(0);
        $this->searchComments($request, $comments);
        return $comments->paginate(20);
    }

    public function updateComments($comment)
    {
        $comment->update(['approved' => !$comment->approved]);
    }

    /**
     * @param $comments
     * @return void
     */
    public function searchComments($request, $comments): void
    {
        if ($keyword = $request->search) {
            $comments->WhereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%");
            })->orWhere('comment', 'LIKE', "%{$keyword}%")
                ->orWhere('id', $keyword);
        }
    }
}
