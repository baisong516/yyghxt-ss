<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebType extends Model
{
    //患者
    public function zxcustomers(){
        return $this->hasMany('App\ZxCustomer');
    }
}
