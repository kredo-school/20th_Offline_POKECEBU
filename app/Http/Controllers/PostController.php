<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    private $post;
    // private $category;

    public function __construct(Post $post) {
       $this->post = $post;
    //    $this->category = $category;
    }

    public function index()
    {
        
    }

    
    public function create()
    {
        // $all_categories = $this->category->all();
        return view ('users.posts.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|min:1|max:1000',
            'image'       => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        // post保存
        $this->post->user_id        = Auth::user()->id;
        $this->post->image          = 'data:image/' .$request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description    = $request->description;
        $this->post->save();

        // foreach($request->category as $category_id){
        //     $category_post[] = ['category_id' => $category_id];
        // }
        // $this->post->categoryPost()->createMany($category_post);

        return redirect()->route('index');
    }

    
    public function show($id)
    {
        $post = $this->post->findOrFail(intval($id));
        return view('users.posts.show')->with('post',$post);
    }

    
    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        // 認証ユーザーが投稿の所有者ではない場合
        if(Auth::user()->id != $post->user->id) {
            return redirect()->route('index');
        }
        return view('users.posts.edit')->with('post',$post);
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'description'   =>'required|min:1|max:1000',
            'image'         =>'mimes:jped,jpg,png,gif|max:1084'

        ]);
        // postの更新
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        // 新しい画像に変更したとき
        if($request->image) {
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $post->save();

        return redirect()->route('post.show',$id);
    }

   
    public function destroy($id)
    {
        $this->post->destroy($id);
        return redirect()->route('index');
    }
}
