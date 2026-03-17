<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostTag;

class PostController extends Controller
{

    // 一覧
    public function index(Request $request)
    {
        $search_word = $request->input('search');

        $query = Post::with('images', 'user', 'tags')->latest();

        if (!empty($search_word)) {
            $query->where(function ($q) use ($search_word) {
                $q->where('title', 'like', "%{$search_word}%")
                    ->orWhere('body', 'like', "%{$search_word}%")
                    ->orWhereHas('tags', function ($t) use ($search_word) {
                        $t->where('name', 'like', "%{$search_word}%");
                    });
            });
        }

        $posts = $query->paginate(10);
        $popularTags = PostTag::withCount('posts')->orderByDesc('posts_count')->limit(30)->get();

        return view('userpage.posts.post-list', compact('posts', 'popularTags', 'search_word'));
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
            ->with('success','Post created successfully.');
    }

    // 詳細
    public function show(Post $post)
    {
        $post->load(['images', 'tags', 'user']);

        $tagIds = $post->tags->pluck('id');

        $relatedPosts = Post::whereHas('tags', function($query) use ($tagIds) {
            $query->whereIn('tag_id', $tagIds);
        })
            ->where('id', '!=', $post->id)
        ->with(['images','user'])
            ->latest()
            ->take(6)
            ->get();

        return view('userpage.posts.show', compact('post', 'relatedPosts'));
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
            ->with('success','Post updated successfully.');
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
            ->with('success', 'Post deleted successfully.');
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
