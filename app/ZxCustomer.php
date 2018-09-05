<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ZxCustomer extends Model
{
    protected $table = 'zx_customers';

    public static function createCustomer($request)
    {
        $tel=$request->input('tel');
        $wechat=$request->input('wechat');
        if (!empty($tel)&&ZxCustomer::where('tel',$tel)->count()>0){
            return redirect()->route('zxcustomers.index')->with('error','电话为：'.$tel.'的数据已存在！');
        }
        if (!empty($wechat)&&ZxCustomer::where('wechat',$wechat)->count()>0){
            return redirect()->route('zxcustomers.index')->with('error','微信为：'.$wechat.'的数据已存在！');
        }
        $customer=new ZxCustomer();
        $customer->name=$request->input('name');
        $customer->age=$request->input('age');
        $customer->sex=$request->input('sex');
        $customer->tel=$request->input('tel');
        $customer->qq=$request->input('qq');
        $customer->wechat=$request->input('wechat');
        $customer->idcard=$request->input('idcard');
        $customer->keywords=$request->input('keywords');
        $customer->fuzhen=$request->input('fuzhen')?$request->input('fuzhen'):0;
        $customer->description=$request->input('description');
        $customer->user_id=$request->input('user_id')?$request->user_id:Auth::user()->id;
        $customer->office_id=$request->input('office_id');
        $customer->disease_id=$request->input('disease_id');
        $customer->doctor_id=$request->input('doctor_id');
        $customer->city=$request->input('city');
        $customer->media_id=$request->input('media_id');
        $customer->webtype_id=$request->input('webtype_id');
        $customer->trans_user_id=$request->input('trans_user_id');
        $customer->cause_id=$request->input('cause_id')?$request->input('cause_id'):0;
        $customer->zixun_at=$request->input('zixun_at');
        $customer->yuyue_at=$request->input('yuyue_at');
        $customer->time_slot=$request->input('time_slot');
        $customer->arrive_at=$request->input('arrive_at');
        $customer->customer_type_id=$request->input('customer_type_id');
        $customer->customer_condition_id=$request->input('customer_condition_id');
        $customer->addons=$request->input('addons');
        $customer->jingjia_user_id=$request->input('jingjia_user_id');
        $bool=$customer->save();
        //创建回访
        $next_at=$request->input('next_at');
        if ($next_at){
            $data=[
                'zx_customer_id'=>$customer->id,
                'next_at'=>$next_at,
                'description'=>'',
                'next_user_id'=>$request->input('user_id')?$request->user_id:Auth::user()->id,
            ];
            Huifang::createHuifang($data);
        }
        return $bool;
    }

    public static function updateCustomer($request, $id)
    {
        $customer=ZxCustomer::findOrFail($id);
        $customer->name=$request->input('name');
        $customer->age=$request->input('age');
        $customer->sex=$request->input('sex');
        $customer->tel=$request->input('tel');
        $customer->qq=$request->input('qq');
        $customer->wechat=$request->input('wechat');
        $customer->idcard=$request->input('idcard');
        $customer->fuzhen=$request->input('fuzhen');
        $customer->keywords=$request->input('keywords');
        $customer->description=$request->input('description');
        $customer->office_id=$request->input('office_id');
        if (!empty($request->input('user_id'))){
            $customer->user_id=$request->input('user_id');
        }
        $customer->disease_id=$request->input('disease_id');
        $customer->doctor_id=$request->input('doctor_id');
        $customer->city=$request->input('city');
        $customer->media_id=$request->input('media_id');
        $customer->webtype_id=$request->input('webtype_id');
        $customer->trans_user_id=$request->input('trans_user_id');
        $customer->zixun_at=$request->input('zixun_at');
        $customer->yuyue_at=$request->input('yuyue_at');
        $customer->time_slot=$request->input('time_slot');
        $customer->arrive_at=$request->input('arrive_at');
        $customer->customer_type_id=$request->input('customer_type_id');
        $customer->customer_condition_id=$request->input('customer_condition_id');
        $customer->addons=$request->input('addons');
        $customer->jingjia_user_id=$request->input('jingjia_user_id');
        return $customer->save();
    }

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
        return $this->hasMany('App\Huifang');
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
    public static function getCustomers($limit=null){
        $offices=static::offices();
        if (empty($offices)){
            return null;
        }
//        return static::whereIn('office_id',$offices)->with('office','disease','media','user','huifangs','customertype','customercondition','webtype','transuser')->get();
        if (empty($limit)){
            return static::whereIn('office_id',$offices)->with('huifangs')->get();
        }else{
            return static::whereIn('office_id',$offices)->with('huifangs')->orderBy('created_at','desc')->take($limit)->get();
        }

    }
    //根据分配到的项目查询患者数据
    public static function getTodayCustomers(){
        $offices=static::offices();
        if (empty($offices)){
            return null;
        }
//        return static::whereIn('office_id',$offices)->with('office','disease','media','user','huifangs','customertype','customercondition','webtype','transuser')->get();
        return static::whereIn('office_id',$offices)->where('created_at','>=',Carbon::now()->startOfDay())->with('huifangs')->get();
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
