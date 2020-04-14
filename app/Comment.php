<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'tutorial_id'];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function tutorial()
    {
        return $this->belongsTo('App\Tutorial', 'tutorial_id', 'id');
    }
}
