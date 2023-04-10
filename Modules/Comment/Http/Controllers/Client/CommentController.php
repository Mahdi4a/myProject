<?php

namespace Modules\Comment\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Comment\Http\Repositories\ClientCommentRepository;

class CommentController extends Controller
{
    public function __construct(protected ClientCommentRepository $commentRepository)
    {
        $this->middleware(['auth']);
    }


    public function storeComments(Request $request)
    {
        $this->commentRepository->createComment($request);
        return response()->json([
            'status' => 'success',
            'message' => 'پیام شما با موفقیت ثبت شد و بعد از تایید نمایش داده میشود'
        ]);
    }
}
