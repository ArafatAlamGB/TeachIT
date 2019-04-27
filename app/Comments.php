<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $primaryKey = 'comment_id';

    public function video(){
    	return $this->belongsTo('App\Videos','video_id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }
}
