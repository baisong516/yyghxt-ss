<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ZxCustomer extends Model
{
    protected $table = 'zx_customers';
    //科室
    public function office(){
        return $this->belongsTo('App\Office');
    }
    //病种
    public function disease(){
        return $this->belongsTo('App\Disease');
    }
    //回访
    public function huifangs(){
        return $this->hasMany('App\Huifang','zx_customer_id','id');
    }
    //媒体
    public function media(){
        return $this->belongsTo('App\Media');
    }
    //咨询员
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
    //商务通转电话人员
    public function transuser(){
        return $this->belongsTo('App\User','trans_user_id');
    }
    //网站类型
    public function webtype(){
        return  $this->belongsTo('App\WebType','webtype_id');
    }
    //患者类型
    public function customertype(){
        return $this->belongsTo('App\CustomerType','customer_type_id');
    }
    //患者状态
    public function customercondition(){
        return $this->belongsTo('App\CustomerCondition');
    }
    //根据分配到的项目查询患者数据
    public static function getCustomers(){
        $offices=static::offices();
        if (empty($offices)){
            return null;
        }
        return static::whereIn('office_id',$offices)->with('office','disease','media','user','huifangs','customertype','customercondition','webtype','transuser')->get();
    }
    //获取科室项目id
    public static function offices(){
        $officeIds=[];
        foreach (Auth::user()->offices as $office){
            $officeIds[]=$office->id;
        }
        return $officeIds;
    }
}
