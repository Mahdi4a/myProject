<?php

namespace Modules\Comment\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Http\Repositories\AdminCommentRepository;

class CommentController extends Controller
{
    public function __construct(protected AdminCommentRepository $commentRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = $this->commentRepository->approvedCommentsWithPage($request);
        return view('comment::admin.approved', compact('comments'));
    }

    public function unapproved(Request $request)
    {
        $comments = $this->commentRepository->unapprovedCommentsWithPage($request);
        return view('comment::admin.unapproved', compact('comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->commentRepository->updateComments($comment);
        alert()->success('وضعیت نظر با موفقیت تغییر شد');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        alert()->success('نظر با موفقیت حذف شد');
        return back();
    }
}
