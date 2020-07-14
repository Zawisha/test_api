<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['id',  'name', 'email','surname','event_id'];

    public function event_rel()
    {
        return $this->hasOne('App\Event','id','event_id');
    }
}
