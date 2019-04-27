<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    //
    protected $primaryKey = 'video_id';


    public function likes(){
    	return $this->hasMany('App\Likes','video_id');
    }

    public function comments(){
    	return $this->hasMany('App\Comments','video_id');
    }
}
