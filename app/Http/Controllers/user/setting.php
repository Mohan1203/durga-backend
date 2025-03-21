<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class setting extends Controller
{
    public function index(Request $request){
        $appUrl = env("APP_URL",$request->getSchemeAndHttpHost());
        $settings = Settings::first();
        if($settings['logo'] != null){
            $settings['logo'] = $appUrl . '/' . $settings['logo']; 
        }
        if($settings['state_image'] != null){
            $settings['state_image'] = $appUrl . '/' . $settings['state_image']; 
        }
        return response()->json([
           'data' => $settings,
            'status' => true,
            
        ]);
    }
}