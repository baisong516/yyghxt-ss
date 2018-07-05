<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function office()
    {
        return $this->belongsTo('App\Office');
    }
}
