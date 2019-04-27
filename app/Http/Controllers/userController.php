<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Video as VideoResource;
use App\Http\Requests;
use App\Videos;
use App\Likes;
use App\Comments;
use App\User;
use Auth;
use Session;

class userController extends Controller
{
 
    public function store(Request $request)
    {
         $user = $request->isMethod('put')? User::findOrFail($request->user_id) : new User ;
         $user->user_id = $request->user_id;
         $user->name = $request->name;
         $user->photo_url = $request->photo_url;
         $user->email = $request->email;
         $user->password = bcrypt($request->password);
         if ($user->save()) {
             return new VideoResource($user);
         }
    }


    public function login(Request $request)
    {
        $creadintial = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::guard()->attempt($creadintial)) {
            $token = str_random(50);
            $user = User::findOrFail(Auth::user()->user_id);
            $user->user_id = Auth::user()->user_id;
            $user->remember_token = $token;
            $user->update();
            return new VideoResource(['token' => $token]);
        }else{
            return new VideoResource(['failed'=>'Login Failed. Check Token']);
        }
    }



    public function like(Request $request)
    {   
        $user = User::where('remember_token',$request->token)->get();
        if (count($user) > 0) {
            $like = new Likes ;
            $like->like_id = $request->like_id;
            $like->video_id = $request->video_id;
            $like->user_id = $request->user_id;
            $like->like = 1;

            if ($like->save()) {
                return new VideoResource($like);
            }
        }else{
            return new VideoResource(['failed'=>'Login Failed. Check Token']);
        }        
    }

    public function dislike(Request $request)
    {   
        $user = User::where('remember_token',$request->token)->get();
        if (count($user) > 0) {
            $like = Likes::findOrFail($request->like_id);

            $like->like_id = $request->like_id;
            $like->like = 0;

            if ($like->update()) {
                return new VideoResource($like);
            }
        }else{
            return new VideoResource(['failed'=>'Login Failed. Check Token']);
        }  
    }

    public function addComment(Request $request)
    {
        $user = User::where('remember_token',$request->token)->get();
        if (count($user) > 0) {
            $comments = $request->isMethod('put')? Comments::findOrFail($request->comment_id) : new Comments ;

            $comments->comment_id = $request->comment_id;
            $comments->video_id = $request->video_id;
            $comments->user_id = $request->user_id;
            $comments->comment = $request->comment;

            if ($comments->save()) {
                return new VideoResource($comments);
            }
        }else{
            return new VideoResource(['failed'=>'Login Failed. Check Token']);
        } 
    }
}
