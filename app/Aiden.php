<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class Aiden extends Model
{
    public static function getCurrentUser()
    {
        return Auth::user();
    }
    /**
     * return 所有用户id和名字组成的一维数组
     */
    public static function getAllUserArray()
    {
        $obj=User::select('id','realname')->get();
        $users=[];
        foreach ($obj as $user){
            $users[$user->id]=$user->realname;
        }
        return $users;
    }

    /**
     * 所有有效用户(仅咨询员和竞价员)
     * @return array
     */
    public static function getAllActiveUserArray()
    {
        $obj=User::select('id','realname')->whereIn('department_id',[1,2])->where('is_active',1)->get();
        $users=[];
        foreach ($obj as $user){
            $users[$user->id]=$user->realname;
        }
        return $users;
    }

    /**
     * 所有有有效竞价用户
     * @return array
     */
    public static function getAllActiveJingjiaUserArray()
    {
        $usero=[];
        foreach (Auth::user()->offices as $office){
            $usero=array_merge($usero,$office->users->whereIn('department_id',[1])->where('is_active',1)->toArray());
        }
//        $obj=User::select('id','realname')->whereIn('department_id',[1])->where('is_active',1)->get();
        $users=[];
        foreach ($usero as $user){
            $users[$user['id']]=$user['realname'];
        }
        return $users;
    }
    /**
     * return 对应表的id和名称组成的一维数组
     */
    public static function getAllModelArray($table)
    {
        $obj=DB::table($table)->select('id','display_name')->get();
        $data=[];
        foreach ($obj as $v){
            $data[$v->id]=$v->display_name;
        }
        return $data;
    }

    /**
     * return 当前用户权限对应的科室id和科室名称的一维数组
     */
    public static function getAuthdOffices()
    {
        $offices=[];
        foreach (Auth::user()->offices as $office){
            $offices[$office->id]=$office->display_name;
        }
        return $offices;
    }
    /**
     * return 当前用户权限对应的科室id
     */
    public static function getAuthdOfficesId()
    {
        $offices=[];
        foreach (Auth::user()->offices as $office){
            $offices[]=$office->id;
        }
        return $offices;
    }
    /**
     * return 当前用户权限对应的病种id和名称的二维数组(以科室分组)
     */
    public static function getAuthdDiseases()
    {
        $diseases=[];
        foreach (Auth::user()->offices as $office){
            $diseases[$office->id]['name']=$office->display_name;
            foreach ($office->diseases as $disease){
                $diseases[$office->id]['diseases'][$disease->id]=$disease->display_name;
            }
        }
        return $diseases;
    }
    /**
     * return 当前用户权限对应的病种id
     */
    public static function getAuthdDiseasesId()
    {
        $diseases=[];
        foreach (Auth::user()->offices as $office){
            foreach ($office->diseases as $disease){
                $diseases[]=$disease->id;
            }
        }
        return $diseases;
    }
    /**
     * return 当前用户权限对应的科室下的医生
     */
    public static function getAuthdDoctors()
    {
        $doctors=Doctor::whereIn('office_id',array_keys(static::getAuthdOffices()))->get();
        $data=[];
        foreach ($doctors as $doctor){
            $data[$doctor->office_id][$doctor->id]=$doctor->display_name;
        }
        return $data;

    }

    /**
     * 系统中所有有效咨询员
     * @return array
     */
    public static function getAllZxUserArray()
    {
        $users=[];
        foreach (Auth::user()->offices as $office){
            foreach ($office->users()->where('users.department_id',2)->where('users.is_active',1)->get() as $user){
                $users[$user->id]=$user->realname;
            }
        }
        return $users;
    }

    /**
     * 系统中所有有效竞价员
     * @return array
     */
    public static function getAllJjUserArray()
    {
        $users=[];
        foreach (Auth::user()->offices as $office){
            foreach ($office->users()->where('users.department_id',1)->where('users.is_active',1)->get() as $user){
                $users[$user->id]=$user->realname;
            }
        }
        return $users;
    }

    //获取专题一维数组（special_id=>special_url）
    public static function getSpecialsArray()
    {
        $data=[];
        $specials=Special::select('id','url')->get();
        foreach ($specials as $special){
            $data[$special->id]=$special->url;
        }
        return $data;
    }

    /**
     * 系统中所有有效咨询员数组
     * @return array
     */
    public static function getAllActiveZiXunUserArray()
    {
        $users=[];
        foreach (Auth::user()->offices as $office){
            foreach ($office->users()->where('users.department_id',2)->where('users.is_active',1)->get() as $user){
                $users[$user->id]=$user->realname;
            }
        }
        return $users;
    }

    /**
     * @param $phone
     * @return mixed
     */
    public static function phoneHide($phone)
    {
        if (empty($phone)){
            return '';
        }else{
            $phone=substr_replace($phone,'****',3,4);
            return $phone;
        }

//        $IsWhat = preg_match('/(0[0-9]{2,3}[-]?[2-9][0-9]{6,7}[-]?[0-9]?)/i', $phone); //固定电话
//        if ($IsWhat == 1) {
//            return preg_replace('/(0[0-9]{2,3}[-]?[2-9])[0-9]{3,4}([0-9]{3}[-]?[0-9]?)/i', '$1****$2', $phone);
//        } else {
//            return preg_replace('/(1[35478]{1}[0-9])[0-9]{4}([0-9]{4})/i', '$1****$2', $phone);
//        }
    }

    public static function phoneCheck($phone,$customer_condition_id,$enableViewPhone,$isAdmin,$day,$userid,$arrive_at)
    {
        if (in_array($customer_condition_id,[1,2,5])){
            if ($isAdmin){
                return $phone;
            }else{
                $arrive_at=Carbon::createFromFormat('Y-m-d H:i:s',$arrive_at)->addDays($day);
                if (Carbon::now()<$arrive_at){
                    return $phone;
                }else{
                    return $enableViewPhone||Auth::user()->id==$userid?$phone:Aiden::phoneHide($phone);
                }
            }
        }else{
            return $enableViewPhone||Auth::user()->id==$userid?$phone:\App\Aiden::phoneHide($phone);
        }
    }
    /**
     * @param $wechat
     * @return mixed
     */
    public static function wechatHide($wechat)
    {
        if (empty($wechat)){
            return '';
        }else{
            $wechat=substr_replace($wechat,'*******',0,7);
            return $wechat;
        }
    }
}
