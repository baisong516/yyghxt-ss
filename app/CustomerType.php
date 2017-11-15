<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    public function zxcustomers(){
        return $this->hasMany('App\ZxCustomer');
    }
}
