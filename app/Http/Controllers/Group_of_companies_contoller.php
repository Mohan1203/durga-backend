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
            try{
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
                    
                    // Use a button with data attributes instead of a form
                    $operate .= '<form action="'.route('handle.delete_timeline', $row->id).'" method="POST" style="display:inline;">
                    '.csrf_field().'
                    <button type="submit" class="btn btn-xs btn-gradient-danger btn-rounded btn-icon" onclick="return confirm(\'Are you sure you want to delete this item?\')">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>';
                    
                    $tempRow = $row->toArray();
                    $tempRow['no'] = $no++;
                    $tempRow['year'] = $row->year;
                    $tempRow['image'] = '<img src="' . env('APP_URL') . '/' . $row->image . '" alt="Product Image" class="img-thumbnail" style="height: 50px; width:50px;">';
                    $tempRow['description'] = $row->description;
                    $tempRow['operate'] = $operate;
                    $rows[] = $tempRow;
                }
                $bulkData['rows'] = $rows;
                return response()->json($bulkData);
            }catch(\Exception $e){
                dd($e);
            }
           
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

    public function delete_timeline(Request $request, $id){
        try {
            $timeline = Timeline::findOrFail($id);
            
            // Delete image if exists
            if ($timeline->image && file_exists(public_path($timeline->image))) {
                unlink(public_path($timeline->image));
            }
            
            $timeline->delete();
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Timeline deleted successfully']);
            }
            
            return back()->with('success', 'Timeline deleted successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Error deleting timeline: ' . $e->getMessage()], 500);
            }
            
            return back()->with('error', 'Error deleting timeline: ' . $e->getMessage());
        }
    }

    
}