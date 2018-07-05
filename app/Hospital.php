<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    public function offices()
    {
        return $this->hasMany('App\Office');
    }
    public function diseases()
    {
        return $this->hasMany('App\Disease');
    }
    public function doctors()
    {
        return $this->hasMany('App\Doctor');
    }
    public function users()
    {
        return $this->belongsToMany('App\User','user_hospital');
    }
}
