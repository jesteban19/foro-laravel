<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::orderBy('id','DESC')->paginate();

        return view('posts.index',['posts' => $posts]);
    }
    public function  show(Post $post,$slug){
        //abort_if($post->slug != $slug, 404);
        if($post->slug != $slug){
            return redirect($post->url, 301);
        }

        return view('posts.show', compact('post'));
    }
}
