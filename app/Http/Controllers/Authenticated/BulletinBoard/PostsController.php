<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\PostEditFormRequest;
use App\Http\Requests\BulletinBoard\PostCommentRequest;
use App\Http\Requests\BulletinBoard\MainCategoryRequest;
use App\Http\Requests\BulletinBoard\SubCategoryRequest;
use Auth;

class PostsController extends Controller
{
    // 投稿一覧画面の表示
    public function show(Request $request){
        // 中間テーブルpostsテーブルの情報を取得
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        // インスタンス化
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){  // もし検索欄に入力されているなら
            // タイトルもしくは投稿内容に入力されたワードがあるかチェック
            $posts = Post::with('user', 'postComments'
            )
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')
            ->get();
            $sub_categories=Subcategory::pluck('sub_category')->toArray();
            if(in_array($request->keyword, $sub_categories)){
                $sub_category=$request->keyword;
                $posts = Post::whereHas('subCategories',function ($q) use ($sub_category) {
                    $q->where('sub_category', '=', $sub_category);
                })->get();
            }
        }else if($request->category_word){  // 各カテゴリボタンを押したなら
            $sub_category = $request->category_word;
            // リレーション先のテーブルの条件で検索
            $posts = Post::whereHas('subCategories',function ($q) use ($sub_category) {
               $q->where('sub_category', '=', $sub_category);
            })->get();
        }else if($request->like_posts){  // もし「いいねした投稿」ボタンを押したなら
            // ログインユーザーがいいねした投稿を取得
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){  // もし「自分の投稿」を押したなら
            // ログインユーザーの投稿を取得
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    // 投稿詳細の表示
    public function postDetail($post_id){
        $post = Post::with('user', 'postComments','subCategories')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    // 検索結果
    public function postInput(){
        $main_categories = MainCategory::get();
        // dd($main_categories);
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    // 投稿ボタン押下時
    public function postCreate(PostFormRequest $request){
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        $posts=Post::findOrFail($post->id);
        // $sub_category=SubCategory::where('sub_category',$request->post_category_id)->first();
        $sub_category=$request->post_category_id;
        $posts->subCategories()->attach($sub_category);
        return redirect()->route('post.show');
    }

    // 投稿編集ボタン押下時
    public function postEdit(PostEditFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    // 投稿削除ボタン押下時
    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    // メインカテゴリ・サブカテゴリ追加押下時
    public function mainCategoryCreate(MainCategoryRequest $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function subCategoryCreate(SubCategoryRequest $request){
        $main_category_id=MainCategory::where('main_category',$request->main_category_id)->first();
        SubCategory::create([
                'main_category_id'=>$main_category_id->id,
                'sub_category'=>$request->sub_category_name,
        ]);
        return redirect()->route('post.input');
    }

    // コメントボタン押下時
    public function commentCreate(PostCommentRequest $request){
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
