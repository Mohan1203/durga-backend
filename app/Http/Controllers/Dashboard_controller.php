<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard_controller
{
    public function show_dashboard(){
        return view('admin.dashboard');
    }
}
