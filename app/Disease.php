<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
    public function office()
    {
        return $this->belongsTo('App\Office');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','user_disease');
    }
}
