<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
    public function diseases()
    {
        return $this->hasMany('App\Disease');
    }
    public function users()
    {
        return $this->belongsToMany('App\User','user_office');
    }

    public function doctors()
    {
        return $this->hasMany('App\Doctor');
    }
    //患者
    public function zxcustomers(){
        return $this->hasMany('App\ZxCustomer');
    }
}
