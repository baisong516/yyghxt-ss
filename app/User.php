<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','is_online','real_name','password','is_active','qq','phone','wechat','department_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function department(){
        return $this->belongsTo('App\Department');
    }

    public function hospitals()
    {
        return $this->belongsToMany('App\Hospital','user_hospital');
    }

    public function hasHospital($hospital_id)
    {
        $hospitals=$this->hospitals()->get();
        foreach ($hospitals as $hospital){
            if ($hospital_id==$hospital->id){
                return true;
            }
        }
        return false;
    }

    public function offices()
    {
        return $this->belongsToMany('App\Office','user_office');
    }
    public function hasOffice($office_id)
    {
        $offices=$this->offices;
        foreach ($offices as $office){
            if ($office_id==$office->id){
                return true;
            }
        }
        return false;
    }
    //患者
    public function zxcustomer(){
        return $this->hasMany('App\ZxCustomer');
    }
}
