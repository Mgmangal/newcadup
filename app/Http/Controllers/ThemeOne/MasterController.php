<?php

namespace App\Http\Controllers\ThemeOne;

use App\Models\Master;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Department Add|Department Edit|Department Delete|Department View']);
        $this->middleware(['permission:Designation Add|Designation Edit|Designation Delete|Designation View']);
        $this->middleware(['permission:Job Function Add|Job Function Edit|Job Function Delete|Job Function View']);
        $this->middleware(['permission:Section Add|Section Edit|Section Delete|Section View']);
        $this->middleware(['permission:Role Add|Role Edit|Role Delete|Role View']);
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
        $sections = getMasterType('section');
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

    public function section()
    {
        $sub_title = 'Section List';
        $departments = getMasterType('department');
        return view('theme-one.masters.section', compact('sub_title','departments'));
    }
    public function section_store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'department_id' => 'required',
            'name' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()
            ]);
        }
        $name = $request->name;
        $department_id = $request->department_id;
        $id = $request->edit_id;
        try {
            if (!empty($id)) {
                $master = Master::find($id);
                $master->name = $name;
                $master->parent_id = $department_id;
                $master->save();
            } else {
                $master = new Master();
                $master->name = $name;
                $master->type = 'section';
                $master->parent_id = $department_id;
                $master->save();
            }
            return response()->json([
                'success' => true,
                'message' => 'Section Added Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function section_list(Request $request)
    {
        $column = ['id', 'name', 'created_at', 'id'];
        $masters = Master::where('type', '=', 'section')->where('is_delete','0');

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
            if (auth()->user()->can('Section Edit')) {
                $action .= '<a href="javascript:void(0);" onclick="editRole(`' . route('user.master.section_edit', $value->id) . '`);" class="btn btn-warning btn-sm m-1">Edit</a>';
                $action .= '<a href="javascript:void(0);" onclick="license(`' . $value->id . '`);" class="btn btn-success btn-sm m-1">License</a>';
            }
            if (auth()->user()->can('Section Delete')) {
                $action .= '<a href="javascript:void(0);" onclick="deleted(`' . route('user.master.section_destroy', $value->id) . '`);" class="btn btn-danger btn-sm m-1">Delete</a>';
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
    public function section_edit($id)
    {
        $role = Master::find($id);
        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }
    public function section_destroy($id)
    {
        $data = Master::find($id);
        $data->is_delete='1';
        $data->status='inactive';
        $data->save();
        return response()->json([
            'success' => true,
            'message' => 'Section Deleted Successfully'
        ]);
    }

    public function role()
    {
        $parentId = '';
        $role = '';
        $sub_title = 'Role List';
        return view('theme-one.masters.role', compact('sub_title','parentId', 'role'));
    }

    public function role_store(Request $request)
    {
        $name = $request->name;
        $parent_id = $request->parent_id;
        $id = $request->edit_id;
        if (empty($name)) {
            return response()->json([
                'success' => false,
                'message' => 'Role Name is required'
            ]);
        }
        try {
            if (!empty($id)) {
                $role = Role::find($id);
                $role->name = $name;
                $role->save();
            } else {
                $role = new Role();
                $role->name = $name;
                $role->save();
            }
            return response()->json([
                'success' => true,
                'message' => 'Role Added Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function role_list(Request $request)
    {
        $column = ['id', 'name', 'created_at', 'id'];
        $roles = Role::where('id', '>', '0');
        $total_row = $roles->count();
        if (isset($_POST['search'])) {
            $roles->where('name', 'LIKE', '%' . $_POST['search']['value'] . '%');
        }

        if (isset($_POST['order'])) {
            $roles->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $roles->orderBy('id', 'desc');
        }
        $filter_row = $roles->count();
        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $roles->skip($_POST["start"])->take($_POST["length"]);
        }
        $result = $roles->get();
        $data = array();
        foreach ($result as $key => $value) {
            $action = '';
            if (auth()->user()->can('Role Edit')) {
                $action .= '<a href="javascript:void(0);" onclick="editRole(`' . route('user.master.role_edit', $value->id) . '`);" class="btn btn-warning btn-sm m-1">Edit</a>';
            }
            $action .= '<a href="' . route('user.master.permission', $value->id) . '" class="btn btn-success btn-sm m-1">Permission</a>';
            if ($value->id != 1 && auth()->user()->can('Role Delete')) {
                $action .= '<a href="javascript:void(0);" onclick="deleted(`' . route('user.master.role_destroy', $value->id) . '`);" class="btn btn-danger btn-sm m-1">Delete</a>';
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
    public function role_edit($id)
    {
        $role = Role::find($id);
        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }

    public function role_destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        $role->permissions()->detach();
        clearCache();
        return response()->json([
            'success' => true,
            'message' => 'Role Deleted Successfully'
        ]);
    }

    // public function subroles($id)
    // {
    //     $parentId = $id;
    //     $role = Role::find($id);
    //     return view('settings.roles.index', compact('parentId', 'role'));
    // }

    public function permission($id)
    {
        $role = Role::with('permissions')->find($id);
        if ($role->parent_id != 0) {
            $permissions = Role::with('permissions')->find($role->parent_id)->permissions()->get();
        } else {
            $permissions = Permission::all();
        }
        $sub_title = 'Permission List';
        return view('theme-one.masters.permission', compact('sub_title','role', 'permissions'));
    }

    public function permission_store($id, Request $request)
    {
        $role = Role::find($id);
        $role->permissions()->sync($request->permissions);
        clearCache();
        return response()->json([
            'success' => true,
            'message' => 'Permissions Updated Successfully'
        ]);
    }



}
