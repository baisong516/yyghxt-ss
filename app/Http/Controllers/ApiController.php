<?php

namespace App\Http\Controllers;

use App\Disease;
use App\Hospital;
use App\Huifang;
use App\Office;
use App\User;
use App\ZxCustomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function getOfficesFromHospital(Request $request){
        $hospital_id=$request->input('hospital_id');
        $offices = Office::where('hospital_id',$hospital_id)->get();
        $data=[];
        $status=0;
        foreach ($offices as $office){
            $data[]=[
                'id'=>$office->id,
                'display_name'=>$office->display_name,
            ];
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$data,
        ]);
    }
    public function getOfficesFromHospitals(Request $request){
        $hospitals=$request->input('hospitals');
        $data=array();
        $status=0;
        if (!empty($hospitals)){
            $offices = Office::select('id','hospital_id','display_name')->whereIn('hospital_id',$hospitals)->get();
            foreach ($offices as $office){
                $data['hos_'.$office->hospital_id]['hospital']=Hospital::find($office->hospital_id)->display_name;
                $data['hos_'.$office->hospital_id]['offices'][]=[
                    'id'=>$office->id,
                    'display_name'=>$office->display_name,
                ];
            }
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$data,
        ]);
    }

    public function getHuifangsFromCustomer(Request $request)
    {
        $customerId=$request->input('zx_customer_id');
        $huifangs = Huifang::where('zx_customer_id',$customerId)->get();
        $data=[];
        $status=0;
        foreach ($huifangs as $huifang){
            $data[]=[
                'user_id'=>$huifang->now_user_id,
                'user'=>User::findOrFail($huifang->now_user_id)->realname,
                'now_at'=>$huifang->now_at,
                'content'=>$huifang->description,
            ];
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'customer'=>ZxCustomer::findOrFail($customerId)->name,
            'customer_id'=>$customerId,
            'data'=>$data,
        ]);
    }

    public function getDiseasesFromOffice(Request $request)
    {
        $officeId=$request->input('office_id');
        $diseases = Disease::where('office_id',$officeId)->get();
        $data=[];
        $status=0;
        foreach ($diseases as $disease){
            $data['name']=Office::findOrFail($officeId)->display_name;
            $data['diseases'][]=[
                'id'=>$disease->id,
                'display_name'=>$disease->display_name,
            ];
        }
        if (!empty($data)){$status=1;}
        return response()->json([
            'status'=>$status,
            'data'=>$data,
        ]);
    }
}
