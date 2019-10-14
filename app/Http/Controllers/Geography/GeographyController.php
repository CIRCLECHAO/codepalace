<?php

namespace App\Http\Controllers\Geography;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City,App\Province,App\Area;

class GeographyController extends Controller
{
    /*获取区域信息*/
    public function get_gs_info(Request $request){
        $type=$request->type??1;
        $id=$request->id??null;
        $pid=$request->pid??null;
        $re=[];
        switch ($type){
            case 1:
                if($id!=0) {
                    $re = Province::where('province_id',$id)
                        ->select('province_id as code','province_name as name')
                        ->get();
                }elseif($pid){

                }else{
                    $re = Province::select('province_id as code','province_name as name')
                        ->get();
                }
                break;
            case 2:
                if($id!=0){
                    $re = City::where('city_id',$id)
                        ->select('city_id as code','city_name as name')
                        ->get();
                }elseif($pid){
                    $re = Province::where('province_id',$pid)->get()[0]->cities;
                    foreach ($re as &$v){
                        $v->code=$v->city_id;
                        $v->name=$v->city_name;
                    }
                }else{
                    $re = City::select('city_id as code','city_name as name')
                        ->get();
                }
                break;
            case 3:
                if($id!=0){
                    $re = Area::where('area_id',$id)
                        ->select('area_id as code','area_name as name')
                        ->get();
                }elseif($pid){
                    $re = City::where('city_id',$pid)->get()[0]->areas;
                    foreach ($re as &$v){
                        $v->code=$v->area_id;
                        $v->name=$v->area_name;
                    }
                }else{
                    $re = Area::select('area_id as code','area_name as name')
                        ->get();
                }
                break;
        }

        return $re;
    }
}
