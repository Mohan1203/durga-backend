<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventsNews;

class events_and_news extends Controller
{
    public function get_all_events(Request $request){
        $appUrl = env("APP_URL",$request->getSchemeAndHttpHost());
        $events = EventsNews::where('id','>',0)->get();
        $eventsWithImages = $events->map(function ($event)use ($appUrl){
            $eventArray = $event->toArray();
            if(!empty($eventArray['image'])){
            $eventArray['image'] = $appUrl . '/' . $eventArray['image']; 
            }  
           return $eventArray; 
        });
        return response()->json([
            'success' => true,
            'data' => $eventsWithImages
        ],200); 
    }
}