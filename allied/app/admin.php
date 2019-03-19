<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    //
    public function roles()
    {
        return $this->hasMany('App\user_role');

    }
    public function employee()
    {
        return $this->belongsTo('App\employee','employee_id');
    }
}
