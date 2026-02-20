<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

use function Symfony\Component\String\u;

use App\Models\User;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment) {
       $this->comment = $comment;
       
    }

    // コメント投稿
    public function store(Request $request, $post_id) {
         $request->validate([
             'comment_body' . $post_id => 'required|max:150'
         ], [
             'comment_body' . $post_id . '.required' => 'You cannot submit and empty comment.',
             'comment_body' . $post_id . '.max' => 'The comment must not have more than 150 characters.'
         ]
         );
    
         $this->comment->create([
             'body'     => $request->input('comment_body' . $post_id),
             'user_id'  => Auth::user()->id,
             'post_id'  => $post_id
         ]);
    
         return redirect()->route('user.posts.show', $post_id)
             ->with('comment_posted',true);
    } 

    // コメント削除
    public function destroy($id) {
        $comment = $this->comment->findOrFail($id);
        if(Auth::user()->id != $comment->user_id) {
            abort(403);
        }
       $this->comment->destroy($id);
       return redirect()->back()->with('comment_deleted',true);
    }

    // ユーザーアバター取得
    public function getUserAvatar($user_id) {
        $user = User::find($user_id);
        return $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('images/default-avatar.png');
    }
    
}
