<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'text' => ['required', 'string', 'max:10000'],
            "image"=>['mimes:pdf,jpg,png','max:2048']
        ]);
        $path=null;
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('images','public');
        }
        if(is_null($request->postperm)){
            $pp=0;

        }else{
            $pp=1;
        }
        if (is_null($request->scheduled_time) || $pp==1){
            $st=NULL;
        }else{
            $st=Carbon::parse($request->scheduled_time);
        }
        $publication = Publication::create([
            'text' => $request->text,
            'imagename' => $path,
            'user_id' =>$request->user()->id,
            'scheduled_time'=>$st,
            'publicated'=>$pp,
        ]);
        return redirect(route('posts', absolute: false));
    }
    public function showmyposts()
    {
        $posts = Publication::where('user_id', auth()->id())->get();

        return view('posts',["posts"=>$posts]);
    }
    public function postcomment(Request $request){
        $request->validate([
            'text' => ['required', 'string', 'max:10000'],
        ]);
        $comment = Comment::create([
            'text' => $request->text,
            'user_id' =>$request->user()->id,
            'publication_id'=>$request->post_id,
        ]);
        return redirect(route('get-post',['id'=>$request->post_id], absolute: false));
    }
    public function deletecomment(Request $request){
        $id=intval($request->delete);
        $comment=Comment::find($id);
        $comment->delete();
        return redirect(route('get-post',['id'=>$request->post_id], absolute: false));
    }
    public function showpostwithcomments($id)
    {
        $post = Publication::where('publications.id', $id)->join('users', 'users.id', '=', 'publications.user_id')->get(["publications.id", "publications.imagename","publications.text", "users.name", "publications.created_at","users.id as user_id"])[0];
        $comments=Publication::find($id)->comments()->join('users', 'users.id', '=', 'comments.user_id')->get(["comments.text","users.name","comments.id","comments.created_at","users.id as user_id"]);
        return view('post',["ipost"=>$post,"comments"=>$comments]);
    }
    public function showmycomments(){
        $comments=Comment::where("user_id",auth()->id())->get();
        return view('comments',["comments"=>$comments]);
    }
    public function showpublishedposts()
    {
        $posts = Publication::where('publicated', 1)->join('users', 'users.id', '=', 'publications.user_id')->get(["publications.id", "publications.imagename","publications.text", "users.name", "publications.created_at"]);
        return view('welcome',["posts"=>$posts]);
    }
    public function publish(Request $request)
    {
        $id=intval($request->publish);
        $post=Publication::find($id);
        $post->publicated=1;
        $post->save();
        return redirect(route('posts', absolute: false));
    }
    public function unpublish(Request $request)
    {
        $id=intval($request->unpublish);
        $post=Publication::find($id);
        $post->publicated=0;
        $post->save();
        return redirect(route('posts', absolute: false));
    }
    public function delete(Request $request)
    {
        $id=intval($request->delete);
        $post=Publication::find($id);
        $post->delete();
        return redirect(route('posts', absolute: false));
    }

    public function openedit(Request $request)
    {
        $id=intval($request->edit);
        $post=Publication::find($id);
        #dd($post);
        return view('form-post',["opname"=>"Edit post","text"=>$post->text,"imagename"=>$post->imagename,"post_id"=>$id]);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'text' => ['required', 'string', 'max:10000'],
            "image"=>['mimes:pdf,jpg,png','max:2048']
        ]);
        $path=null;
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('images','public');
        }
        if(is_null($request->postperm)){
            $pp=0;
        }else{
            $pp=1;
        }
        
        $publication=Publication::find($request->post_id);
        if (auth()->id()==$publication->user_id){
            $publication->update(["text"=>$request->text]);
            $publication->update(["imagename"=>$path]);
            $publication->update(["publicated"=>$pp]);
            #$publication->save();
        }
        return redirect(route('posts', absolute: false));
    }
}
