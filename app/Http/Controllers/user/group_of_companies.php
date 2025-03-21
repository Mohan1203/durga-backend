<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timeline;

class group_of_companies extends Controller
{
    public function get_all_timeline(Request $request){
        $appUrl = env("APP_URL",$request->getSchemeAndHttpHost());
        $timelines = Timeline::orderBy('year','ASC')->get();
        $timelineWithImages = $timelines->map(function ($timeline) use ($appUrl){
            $timelineArray = $timeline->toArray();
            if($timelineArray['image']){
                $timelineArray['image'] = $appUrl . '/' . $timelineArray['image']; 
            }
            return $timelineArray;
        });
        return response()->json([
            'success' => true,
            'data' => $timelineWithImages 
        ]);
    }
}