<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GhCustomer extends Model
{
    protected $table='gh_customers';

    public static function getCustomers()
    {
        $offices=static::offices();
        if (empty($offices)){
            return null;
        }
        //return static::whereIn('office_id',$offices)->with('huifangs')->get();
        return static::whereIn('office_id',$offices)->get();
    }

    public static function offices()
    {
        $officeIds=[];
        foreach (Auth::user()->offices as $office){
            $officeIds[]=$office->id;
        }
        return $officeIds;
    }
}
