<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Events_and_news_contoller
{
    public function show_events_and_news(){
        return view('admin.events-news');
    }
}
