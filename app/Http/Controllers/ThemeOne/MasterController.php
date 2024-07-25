<?php

namespace App\Http\Controllers\ThemeOne;

use App\Models\Master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Department Add|Department Edit|Department Delete|Department View']);
        $this->middleware(['permission:Designation Add|Designation Edit|Designation Delete|Designation View']);
        $this->middleware(['permission:Job Function Add|Job Function Edit|Job Function Delete|Job Function View']);
    }

    public function department()
    {
        $sub_title = 'Department List';
        return view('theme-one.masters.department', compact('sub_title'));
    }
    public function department_store(Request $request)
    {
        $name=$request->name;
        $id=$request->edit_id;
        if(empty($name)){
            return response()->json([
                'success'=>false,
                'message'=>'Department Name is required'
            ]);
        }
        try{
            if(!empty($id)){
                $master=Master::find($id);
                $master->name=$name;
                $master->save();
            }else{
                $master=new Master();
                $master->name=$name;
                $master->type='department';
                $master->save();
            }
            return response()->json([
                'success'=>true,
                'message'=>'Department Added Successfully'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function department_list(Request $request)
    {
        $column=['id','name','created_at','id'];
        $masters=Master::where('type','=','department')->where('is_delete','0');

        $total_row=$masters->count();
        if (isset($_POST['search'])) {
            $masters->where('name', 'LIKE', '%' . $_POST['search']['value'] . '%');
		}

		if (isset($_POST['order'])) {
            $masters->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
            $masters->orderBy('id', 'desc');
        }
		$filter_row =$masters->count();
        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $masters->skip($_POST["start"])->take($_POST["length"]);
		}
        $result =$masters->get();
        $data = array();
		foreach ($result as $key => $value) {

            $action = '';
            if (auth()->user()->can('Department Edit')) {
                $action .= '<a href="javascript:void(0);" onclick="editRole(`'.route('user.master.department_edit', $value->id).'`);" class="btn btn-warning btn-sm m-1">Edit</a>';
            }
            if(auth()->user()->can('Department Delete')){
                $action .= '<a href="javascript:void(0);" onclick="deleted(`'.route('user.master.department_destroy', $value->id).'`);" class="btn btn-danger btn-sm m-1">Delete</a>';
            }
            $sub_array = array();
			$sub_array[] = ++$key;
            $sub_array[] = $value->name;
            $sub_array[] = date('d-m-Y',strtotime($value->created_at));
            $sub_array[] =  $action;
            $data[] = $sub_array;
        }
        $output = array(
			"draw"       =>  intval($_POST["draw"]),
			"recordsTotal"   =>  $total_row,
			"recordsFiltered"  =>  $filter_row,
			"data"       =>  $data
		);

		echo json_encode($output);
    }
    public function department_edit($id)
    {
        $role=Master::find($id);
        return response()->json([
            'success'=>true,
            'data'=>$role
        ]);
    }
    public function department_destroy($id)
    {
        $data=Master::find($id);
        $data->is_delete='1';
        $data->status='inactive';
        $data->save();
        return response()->json([
            'success'=>true,
            'message'=>'Department Deleted Successfully'
        ]);
    }

    public function designation()
    {
        $sub_title = 'Designation List';
        return view('theme-one.masters.designation', compact('sub_title'));
    }
    public function designation_store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()
            ]);
        }
        $name = $request->name;
        $id = $request->edit_id;
        try {
            if (!empty($id)) {
                $master = Master::find($id);
                $master->name = $name;
                $master->save();
            } else {
                $master = new Master();
                $master->name = $name;
                $master->type = 'designation';
                $master->save();
            }
            return response()->json([
                'success' => true,
                'message' => 'Designation Added Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function designation_list(Request $request)
    {
        $column = ['id', 'name', 'created_at', 'id'];
        $masters = Master::where('type', '=', 'designation')->where('is_delete','0');

        $total_row = $masters->count();
        if (isset($_POST['search'])) {
            $masters->where('name', 'LIKE', '%' . $_POST['search']['value'] . '%');
        }

        if (isset($_POST['order'])) {
            $masters->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $masters->orderBy('id', 'desc');
        }
        $filter_row = $masters->count();
        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $masters->skip($_POST["start"])->take($_POST["length"]);
        }
        $result = $masters->get();
        $data = array();
        foreach ($result as $key => $value) {

            $action = '';
            if (auth()->user()->can('Designation Edit')) {
                $action = '<a href="javascript:void(0);" onclick="editRole(`' . route('user.master.designation_edit', $value->id) . '`);" class="btn btn-warning btn-sm m-1">Edit</a>';
                $action .= '<a href="javascript:void(0);" onclick="license(`' . $value->id . '`);" class="btn btn-success btn-sm m-1">License</a>';
                $action .= '<a href="javascript:void(0);" onclick="mapLeave(`' . $value->id . '`);" class="btn btn-success btn-sm m-1">Assign Leave</a>';
            }
            if (auth()->user()->can('Designation Delete')) {
                $action .= '<a href="javascript:void(0);" onclick="deleted(`' . route('user.master.designation_destroy', $value->id) . '`);" class="btn btn-danger btn-sm m-1">Delete</a>';
            }
            $sub_array = array();
            $sub_array[] = ++$key;
            $sub_array[] = $value->name;
            $sub_array[] = date('d-m-Y', strtotime($value->created_at));
            $sub_array[] =  $action;
            $data[] = $sub_array;
        }
        $output = array(
            "draw"       =>  intval($_POST["draw"]),
            "recordsTotal"   =>  $total_row,
            "recordsFiltered"  =>  $filter_row,
            "data"       =>  $data
        );

        echo json_encode($output);
    }
    public function designation_edit($id)
    {
        $role = Master::find($id);
        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }
    public function designation_destroy($id)
    {
        $data = Master::find($id);
        $data->is_delete='1';
        $data->status='inactive';
        $data->save();
        return response()->json([
            'success' => true,
            'message' => 'Designation Deleted Successfully'
        ]);
    }

    public function job_function()
    {
        $sub_title = 'Job Function List';
        $sections = Master::where('type', 'section')->get();
        return view('theme-one.masters.job_function', compact('sub_title','sections'));
    }
    public function job_function_store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'section_id' => 'required',
            'name' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()
            ]);
        }
        $name = $request->name;
        $section_id = $request->section_id;
        $id = $request->edit_id;
        try {
            if (!empty($id)) {
                $master = Master::find($id);
                $master->name = $name;
                $master->parent_id = $section_id;
                $master->save();
            } else {
                $master = new Master();
                $master->name = $name;
                $master->type = 'job_function';
                $master->parent_id = $section_id;
                $master->save();
            }
            return response()->json([
                'success' => true,
                'message' => 'Job Function Added Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function job_function_list(Request $request)
    {
        $column = ['id', 'parent_id', 'name', 'created_at', 'id'];
        $masters = Master::where('type', '=', 'job_function')->where('is_delete','0');

        $total_row = $masters->count();
        if (isset($_POST['search'])) {
            $masters->where('name', 'LIKE', '%' . $_POST['search']['value'] . '%');
        }

        if (isset($_POST['order'])) {
            $masters->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $masters->orderBy('id', 'desc');
        }
        $filter_row = $masters->count();
        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $masters->skip($_POST["start"])->take($_POST["length"]);
        }
        $result = $masters->get();
        $data = array();
        foreach ($result as $key => $value) {

            $action = '';
            if (auth()->user()->can('Job Function Edit')) {
                $action .= '<a href="javascript:void(0);" onclick="editRole(`' . route('user.master.job_function_edit', $value->id) . '`);" class="btn btn-warning btn-sm m-1">Edit</a>';
                $action .= '<a href="javascript:void(0);" onclick="license(`' . $value->id . '`);" class="btn btn-success btn-sm m-1">License</a>';
            }
            if (auth()->user()->can('Job Function Delete')) {
                $action .= '<a href="javascript:void(0);" onclick="deleted(`' . route('user.master.job_function_destroy', $value->id) . '`);" class="btn btn-danger btn-sm m-1">Delete</a>';
            }

            $sub_array = array();
            $sub_array[] = ++$key;
            $sub_array[] = Master::find($value->parent_id)->name;
            $sub_array[] = $value->name;
            $sub_array[] = date('d-m-Y', strtotime($value->created_at));
            $sub_array[] =  $action;
            $data[] = $sub_array;
        }
        $output = array(
            "draw"       =>  intval($_POST["draw"]),
            "recordsTotal"   =>  $total_row,
            "recordsFiltered"  =>  $filter_row,
            "data"       =>  $data
        );

        echo json_encode($output);
    }
    public function job_function_edit($id)
    {
        $role = Master::find($id);
        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }
    public function job_function_destroy($id)
    {
        $data = Master::find($id);
        $data->is_delete='1';
        $data->status='inactive';
        $data->save();
        return response()->json([
            'success' => true,
            'message' => 'Job Function Deleted Successfully'
        ]);
    }



}
