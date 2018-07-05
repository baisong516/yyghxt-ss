<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GhHuifang extends Model
{
    public function ghcustomer(){
        return $this->belongsTo('App\GhCustomer','gh_customer_id','id');
    }
    public function nowusername(){
        return User::findOrFail($this->now_user_id)->realname;
    }
}
