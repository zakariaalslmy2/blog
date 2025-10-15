<?php

namespace App\Http\Controllers\api\dashboard;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;


class SettingController extends Controller
{
    public function index(){

       $settings=Settings::chackSetting();
       $settings=SettingResource::make($settings);


       return response()->json(['data'=>$settings,'error'=>"this arror "],200);

    }

}
