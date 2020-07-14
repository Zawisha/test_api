<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = ['id', 'title', 'city'];

    public function member_rel()
    {
        return $this->hasMany('App\Member','event_id','id');
    }

}
