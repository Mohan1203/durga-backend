<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timeline;

class Group_of_companies_contoller
{
    public function show_group_of_companies(){
        return view('admin.group-of-companies');
    }

    public function handle_add_year(Request $request){
        $request->validate([
            'year'=>'required',
            'image'=>'required',
            'description'=>"required",
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path("timeline"),$imageName);
        $timeline = new Timeline;
        $timeline->year = $request->year;
        $timeline->image = 'timeline/'.$imageName;
        $timeline->description = $request->description;
        $timeline->save();
     
        return back()->with('success','Timeline added successfuly');
    }
}