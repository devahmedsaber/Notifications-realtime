<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get All Posts With Comments
        $posts = Post::with(['comments' =>function($q){
            $q->select('id', 'post_id','comment');
        }])->get();
        return view('home', compact('posts'));
    }

    public function saveComment(Request $request){
        // Insert New Comment Into DB
        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        // The Data That Event Takes It And Pass To Pusher Web Socket
        $data = [
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'comment' => $request->comment
        ];
        event(new NewNotification($data));
        return redirect()->back()->with(['success' => 'تم إضافة تعليقك بنجاح']);
    }
}
