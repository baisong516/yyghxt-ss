<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Huifang extends Model
{
    protected $table='huifangs';
    public function zxcustomer(){
        return $this->belongsTo('App\ZxCustomer','zx_customer_id','id');
    }
    public function nowusername(){
        return User::findOrFail($this->now_user_id)->realname;
    }
}
