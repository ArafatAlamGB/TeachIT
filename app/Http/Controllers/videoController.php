<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Video as VideoResource;
use App\Http\Requests;
use App\Videos;
use App\Likes;
use App\Comments;

class videoController extends Controller
{
    public function index()
    {
        $data = Videos::with('likes','comments')->withCount('likes','comments')->get();
        return new VideoResource($data);
    }

    public function store(Request $request)
    {   
        $videos = $request->isMethod('put')? Videos::findOrFail($request->video_id) : new Videos ;
        $videos->video_id = $request->video_id;
        $videos->title = $request->title;
        $videos->url = $request->url;
        $videos->description = $request->description;
        $videos->thum_nail_url = $request->thum_nail_url;

        if ($videos->save()) {
            return new VideoResource($videos);
        }
    }

    public function show($id)
    {
        $data = Videos::with('likes','comments')->withCount('likes','comments')->findOrFail($id);
        return new VideoResource($data);
    }

    public function destroy($id)
    {
        $data = Videos::findOrFail($id);

        if ($data->delete()) {
            return new VideoResource($data);
        }
    }

    public function orderBy($orderBy)
    {
        if($orderBy == 'name'){

            $data = Videos::with('likes','comments')->withCount('likes','comments')->orderBy('title','ASC')->get();
            return new VideoResource($data);

        }elseif ($orderBy == 'time') {

             $data = Videos::with('likes','comments')->withCount('likes','comments')->orderBy('created_at','DESC')->get();
            return new VideoResource($data);

        }elseif ($orderBy == 'likes') {

            $data = Videos::with('likes','comments')->withCount('likes','comments')->orderBy('likes_count','DESC')->get();
            return new VideoResource($data);

        }elseif ($orderBy == 'comments') {

            $data = Videos::with('likes','comments')->withCount('likes','comments')->orderBy('comments_count','DESC')->get();
            return new VideoResource($data);
        }else{
            $data = Videos::with('likes','comments')->withCount('likes','comments')->orderBy('video_id','DESC')->get();
            return new VideoResource($data);
        }
    }

    public function totalLike($video_id)
    {
        $totalLikes = likes::where('video_id',$video_id)
                        ->where('like',1)
                        ->get();

        return new VideoResource(['likes' => $totalLikes->count()]);
    }

    

    public function totalDislike($video_id)
    {
        $totalDisLikes = likes::where('video_id',$video_id)
                        ->where('like',0)
                        ->get();
                        
        return new VideoResource(['dislikes' => $totalDisLikes->count()]);
    }

    
}
