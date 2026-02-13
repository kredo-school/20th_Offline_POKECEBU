<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostTag;

class PostController extends Controller
{

    // 一覧
    public function index() {
        $posts = Post::with('images', 'user','tags')
            ->latest()
            ->paginate(10);

        return view('userpage.posts.post-list')->with('posts',$posts);
        
    }
    
    // POST作成
    public function create()
    {
        return view ('userpage.posts.create');
    }

    // POST保存
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|max:255',
            'body'      => 'required|min:1|max:1000',
            'images'    => 'required|array',
            'images.*'  => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $post = new Post();
        $post->user_id     = Auth::user()->id;
        $post->title       =$request->title;
        $post->body        = $request->body;
        $post->save();

        # #タグ抽出
        preg_match_all('/#([^\s#]+)/u', $request->body,$matches);

        $tagIds = [];

        foreach ($matches[1] as $tagName) {
            $tag = PostTag::firstOrCreate([
                'name' => mb_strtolower($tagName)
            ]);

            $tagIds[] = $tag->id;
        }

        $post->tags()->sync($tagIds);

        if($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageData = 'data:image/' 
                . $image->extension() 
                . ';base64,' 
                . base64_encode(file_get_contents($image));

                $post->images()->create([
                'image' =>$imageData
                ]);
            }
        }
        
        return redirect()
            ->route('user.posts.index')
            ->with('success','投稿しました✈️');
    }

    // 詳細
    public function show(Post $post)
    {
        return view('userpage.posts.show')->with('post',$post);
    }

    // 編集
    public function edit(Post $post)
    {

        // 認証ユーザーが投稿の所有者ではない場合
        if(Auth::user()->id != $post->user->id) {
            return redirect()->route('userpage.posts.index');
        }
        return view('userpage.posts.edit')->with('post',$post);
    }

    // 更新
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'     => 'required|max:255',
            'body'      =>'required|min:1|max:1000',
            'images.*'  =>'mimes:jpeg,jpg,png,gif|max:1084'

        ]);
        // postの更新
        $post->title    = $request->title;
        $post->body     = $request->body;
        $post->save();

        preg_match_all('/#([^\s#]+)/u',$request->body,$matches);

        $tagIds = [];

        foreach ($matches[1] as $tagName) {

        $tag = PostTag::firstOrCreate([
            'name' => mb_strtolower($tagName)
        ]);

        $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);

        // 新しい画像に変更したとき
        if($request->hasFile('images')) {
            $post->images()->delete();

            foreach ($request->file('images') as $image) {

            
                $imageData = 'data:image/' 
                . $image->extension() 
                . ';base64,' 
                . base64_encode(file_get_contents($image));

                $post->images()->create([
                'image' =>$imageData
                ]);
            }
        }

        

        return redirect()
            ->route('user.posts.show',$post)
            ->with('success','更新しました✏️');
    }

    //削除    
    public function destroy(Post $post)
    {
        if (Auth::user()->id !== $post->user_id) {
            return redirect()->route('userpage.posts.index');
        }

        $post->delete();

        return redirect()
            ->route('user.posts.index')
            ->with('success', '削除しました🗑️');
    }

    // タグ検索
    public function tag($tagName) {
       $tag = PostTag::where('name', $tagName)->firstOrFail();
       $posts = $tag->posts()
            ->with('images', 'user', 'tags')
            ->latest()
            ->paginate(12);

        return view('userpage.posts.tag-list',compact('tag','posts'));
    }
}
