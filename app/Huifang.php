<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Huifang extends Model
{
    protected $table='huifangs';
    public function zxcustomer(){
        return $this->belongsTo('App\ZxCustomer','zx_customer_id','id');
    }
    public function nowusername(){
        return User::findOrFail($this->now_user_id)->realname;
    }

    public static function createHuifang($data)
    {
        $huifang=new Huifang();
        $huifang->zx_customer_id=$data['zx_customer_id'];
        $huifang->now_user_id=Auth::user()->id;
        $huifang->next_user_id=$data['next_user_id'];
        $huifang->next_at=$data['next_at'];
        $huifang->description=$data['description'];
        $huifang->now_at=Carbon::now();
        $huifang->save();
        return $huifang;
    }
}
