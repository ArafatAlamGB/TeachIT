<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $primaryKey = 'like_id';

    public function video(){
    	return $this->belongsTo('App\videos', 'video_id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }
}
