<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCondition extends Model
{
    public function zxcustomers(){
        return $this->hasMany('App\ZxCustomer');
    }
}
