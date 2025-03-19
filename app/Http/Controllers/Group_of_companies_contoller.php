<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timeline;

class Group_of_companies_contoller
{
    public function show_group_of_companies(){
        return view('admin.group-of-companies.group-of-companies');
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
    
    public function handle_show_data(Request $request){
        {
            $offset = request('offset', 0);
            $limit = request('limit', 10);
            $sort = request('sort', 'id');
            $order = request('order', 'DESC');
    
            $sql = Timeline::where('id', '!=', 0);
    
            if (!empty($_GET['search'])) {
                $search = $_GET['search'];
                $sql->where(function ($query) use ($search) {
                    $query->where('id', 'LIKE', "%$search%")->orwhere('name', 'LIKE', "%$search%");
                });
            }
    
            if ($request->show_deleted) {
                $sql->onlyTrashed();
            }
            $total = $sql->count();
            $sql->orderBy($sort, $order)->skip($offset)->take($limit);
            $res = $sql->get();
            $bulkData = array();
            $bulkData['total'] = $total;
            $rows = array();
            $no = 1;
            $operate = "";
            foreach ($res as $row) {
                $operate = '<a href='.route('handle.show-edit-grp-comp',$row->id).' class="btn btn-xs btn-gradient-primary btn-rounded btn-icon edit-data" data-id=' . $row->id . ' title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
                $operate .= '<form action="' . route('handle.delete_timeline', $row->id) . '" method="DELETE" class="d-inline delete-form" >
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-xs btn-gradient-danger btn-rounded btn-icon">
                    <i class="fa fa-trash"></i>
                </button>
            </form>';
                $tempRow = $row->toArray();
                $tempRow['no'] = $no++;
                $tempRow['year'] = $row->year;
                $tempRow['image'] = '<img src="' . env('APP_URL') . '/' . $row->image . '" alt="Product Image" class="img-thumbnail" style="height: 50px; width:50px;">';
                $tempRow['description'] = $row->description;
                $tempRow['slug'] = $row->slug;
                $tempRow['operate'] = $operate;
                $rows[] = $tempRow;
            }
            $bulkData['rows'] = $rows;
            return response()->json($bulkData);
        }
    }

    public function handle_show_edit(Request $request,$id){
        $timeline = Timeline::findOrFail($id);
        return view('admin.group-of-companies.edit-group-of-comp', compact('timeline'));
    }

    public function handle_edit_data(Request $request,$id){
        $timeline = Timeline::findOrFail($id);
        $request->validate([
            'year'=>'required',
            'description'=>"required",
        ]);
        
        $timeline->year = $request->year;
        $timeline->description = $request->description;
        if($request->image != null){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path("images"),$imageName);
            $timeline->image = 'images/' . $imageName;
        }
        $timeline->save();
        return redirect()->to('/group-of-companies');   
    }

    public function delete_timeline(Request $request,  $id){
        $res = Timeline::where('id',$id)->delete();
        return back()->with('success', 'Timeline deleted successfully');
    }

    
}