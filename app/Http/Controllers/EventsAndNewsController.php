<?php

namespace App\Http\Controllers;

use App\Models\EventsNews;
use Illuminate\Http\Request;

class EventsAndNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.events-news.events-news");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name'=>"required",
            "image"=>"required"  
          ]); 
          $imageName = time().'.'.$request->image->extension();
          $request->image->move(public_path("images"),$imageName);
          $event = new EventsNews;
          $event->name = $request->name;
          $event->image = 'images/'.$imageName;
          $event->save();
          return back()->with('success', 'Event added successfully');    
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
     
        $offset = request('offset', 0);
        $limit = request('limit', 10);
        $sort = request('sort', 'id');
        $order = request('order', 'DESC');
        $sql = EventsNews::where('id', '!=', 0);
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
            $operate = '<a href="'.route('events-and-news.edit', $row->id).'" class="btn btn-xs btn-gradient-primary btn-rounded btn-icon edit-data" data-id="' . $row->id . '" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<form action="'.route('events-and-news.destroy', $row->id).'" method="POST" style="display:inline;">
                '.csrf_field().'
                '.method_field('DELETE').'
                <button type="submit" class="btn btn-xs btn-gradient-danger btn-rounded btn-icon" onclick="return confirm(\'Are you sure you want to delete this item?\')">
                    <i class="fa fa-trash"></i>
                </button>
            </form>';

            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;
            $tempRow['name'] = $row->name;
            $tempRow['image'] = '<img src="' . env('APP_URL') . '/' . $row->image . '" alt="Product Image" class="img-thumbnail" style="height: 50px; width:50px;">';
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $events = EventsNews::findOrFail($id);
        return view('admin.events-news.edit-event-news',compact('events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $event = EventsNews::findOrFail($id);
        $request->validate([
            'name'=>'required',
        ]);
        
        $event->name = $request->name;
        if($request->image != null){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path("images"),$imageName);
            $event->image = 'images/' . $imageName;
        }
        $event->save();
        return redirect()->to('/events-and-news'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        try {
            $event = EventsNews::findOrFail($id);
            $event->delete();
            
            if($request->ajax()) {
                return response()->json([
                    'error' => false,
                    'message' => 'Event deleted successfully'
                ]);
            }
            
            return back()->with('success', 'Event deleted successfully');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Error deleting event'
                ]);
            }
            return back()->with('error', 'Error deleting event');
        }
    }
}