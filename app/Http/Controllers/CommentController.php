<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment) {
       $this->comment = $comment;
       
    }

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
    
         return redirect()->route('user.posts.show', $post_id);
    } 

    public function destroy($id) {
       $this->comment->destroy($id);
       return redirect()->back();
    }
       
    
}
