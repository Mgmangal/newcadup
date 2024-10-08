<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirCraft;
use App\Models\Master;
use App\Models\User;
use App\Models\City;
use App\Models\FlightDocAssign;
use App\Models\MasterAssign;
use App\Models\LeaveAssign;
use App\Models\FlyingLog;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_user=User::where('status','active')->count()-1;
        $active_pilot=User::where('designation','1')->where('status','active')->count();
        $total_air_croft=AirCraft::count();
        $active_air_croft=AirCraft::where('status','active')->count();
        $total_designation=Master::where('type','designation')->count();
        $total_section=Master::where('type','section')->count();
        //echo now()->subDays(30)->endOfDay();
        // $chartData=FlyingLog::selectRaw("COUNT(*) views, date")->groupBy('date')->orderBy('date', 'DESC')->get();
        $chartData=FlyingLog::selectRaw("COUNT(*) views, date")->groupBy('date')->where('date', '>', date('Y-m-d',strtotime(now()->subDays(30)->endOfDay())))->get();
        return view('dashboard',compact('chartData','active_pilot','active_air_croft','total_user','total_air_croft','total_designation','total_section'));
    }

    public function getlicense(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $html = '<input type="hidden" name="master_id" value="' . $id . '">';
        $html .= '<input type="hidden" name="type" value="' . $type . '">';
        $licens =  Master::orderBy('sub_type', 'asc')->where('type', '=', 'certificate');
        if (!empty($type)&&$type=='aircraft') {
            $licens->where('sub_type', '=', 'license')->orWhere('sub_type', '=', 'training')->orWhere('sub_type', '=', 'qualification')->orWhere('sub_type', '=', 'ground_training')->orWhere('sub_type', '=', 'medical');
        }
        $licens->where('status', '=', 'active')->where('is_delete','0');
        $license=$licens->get();
        $html .= '<div class="row">';
        $html .= '<table class="table border">';
        $html .= '<tr><th>Name</th><th>Type</th></tr>';
        $groupedBySubType = $license->groupBy('sub_type');
        
        foreach ($groupedBySubType as $subType => $licenses) {
            $html .= '<tr>
                        <td colspan="2"><strong>'. ucwords(str_replace('_', ' ', $subType)) .'</strong></td>
                    </tr>';
            foreach ($licenses as $key => $value) {
                if($value->status=='active'){
                $d = MasterAssign::where('master_id', $id)->where('is_for','=',$type)->where('certificate_id', $value->id)->first();
                $html .= '<tr>';
                $html .= '<td>';
                $html .= '<div class="form-check m-2">
                                <input type="hidden" name="edit_id[' . $value->id . ']" value="' . (!empty($d->id) ? $d->id : '') . '">
                                <input class="form-check-input" type="checkbox" value="' . $value->id . '" ' . (!empty($d->certificate_id) && $d->certificate_id == $value->id ? 'checked' : '') . ' id="mng' . $value->id . '" name="licenses[' . $value->id . ']">
                                <label class="form-check-label" for="mng' . $value->id . '">' . $value->name . '</label>
                            </div>';
                $html .='</td>';
                $html .= '<td>' . ucwords(str_replace('_', ' ',$value->sub_type)) . '</td>';
                $html .= '</tr>';
                }
            }
        }
        $html .= '</table>';
        $html .= '</div>';
        return response()->json([
            'success' => true,
            'data' => $html
        ]);
    }

    public function license(Request $request)
    {
        $type = $request->type;
        $master_id = $request->master_id;
        $licenses = $request->licenses;
        $is_mendatory = $request->is_mendatory;
        $is_active = $request->is_active;
        MasterAssign::where('master_id', $master_id)->where('is_for', $type)->delete();
        
        foreach ($licenses as $key => $val) {
            if (!empty($val)) {
                $data = new MasterAssign;
                $data->master_id = $master_id;
                $data->certificate_id = $val;
                $data->is_for=$type;
                $data->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'License Added Successfully'
        ]);
    }
    
    public function getLeave(Request $request)
    {
        $id = $request->id;
        $html = '<input type="hidden" name="master_id" value="' . $id . '">';
        $licens =  Master::orderBy('id', 'asc')->where('type', '=', 'leave_type');
        $leaveTypes=$licens->get();
        $html .= '<div class="row">';
        $html .= '<table class="table border">';
        $html .= '<tr><th>Leave Type</th><th>Day</th></tr>';
        foreach ($leaveTypes as $key => $value) {
            $d = LeaveAssign::where('designation_id', $id)->where('master_id', $value->id)->first();
            $html .= '<tr>';
            $html .= '<td>';
            $html .= '<div class="form-group m-2">
                            <input type="hidden" name="edit_id[' . $key . ']" value="' . (!empty($d->id) ? $d->id : '') . '">
                            <input type="hidden" name="leave_type[' . $key . ']" value="' . $value->id . '">
                            <input class="form-control" type="text" value="' . $value->name . '" id="mng' . $value->id . '" name="leave[' . $key . ']" readonly>
                        </div>';
            $html .='</td>';
            
            $html .= '<td>';
            $html .= ' <div class="form-group m-2">
                            <input class="form-control" type="text" value="' . (!empty($d->id) ? $d->days : '') . '" id="mng1' . $value->id . '" name="day[' . $key . ']">
                        </div>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '</div>';
        return response()->json([
            'success' => true,
            'data' => $html
        ]);
    }

    public function leave(Request $request)
    {
        $master_id = $request->master_id;
        $leave_type = $request->leave_type;
        $day = $request->day;
        $edit_id = $request->edit_id;
        LeaveAssign::where('designation_id', $master_id)->delete();
        foreach ($leave_type as $key => $val) {
            if (!empty($day[$key])) {
                $data = new LeaveAssign;
                $data->master_id = $val;
                $data->designation_id = $master_id;
                $data->days =  $day[$key];
                $data->save();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Data Added Successfully'
        ]);
    }
    
    public function getPostFlightDoc(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $html = '<input type="hidden" name="flying_log_id" value="' . $id . '">';
        $licens =  Master::orderBy('name', 'asc')->where('type', '=', 'post_flight_doc');
        $licenses=$licens->get();
        $html .= '<div class="row">';
        $html .= '<table class="table border">';
        $html .= '<tr><th>Name</th><th></th><th></th></tr>';
        foreach ($licenses as $key => $value) {
            $d = FlightDocAssign::where('master_id', $value->id )->where('flying_log_id',$id)->first();
            $html .= '<tr>';
                $html .= '<td>';
                    $html .= '<div class="form-check m-2">
                                <input type="hidden" name="edit_id['.$value->id.']" value="'.(!empty($d->id) ? $d->id : '').'">
                                <input class="form-check-input" type="checkbox" value="'.$value->id.'" '.(!empty($d->master_id) && $d->master_id == $value->id ? 'checked' : '') . ' id="mng' . $value->id . '" name="doc_id['.$value->id.']">
                                <label class="form-check-label" for="mng'.$value->id.'">'.$value->name.'</label>
                            </div>';
                $html .='</td>';
                $html .= '<td>';
                    $html .= '<input class="form-control" type="file" name="doc['.$value->id.']">';
                $html .='</td>';
                $html .= '<td>';
                    if(!empty($d)){
                    $html .= '<a href="'.asset('uploads/flight_doc/'.$d->doc).'" target="blank" class="btn btn-sm btn-warning">View</a>';
                    }
                $html .='</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '</div>';
        return response()->json([
            'success' => true,
            'data' => $html
        ]);
    }

    public function postFlightDoc(Request $request)
    {
        $flying_log_id = $request->flying_log_id;
        $edit_id = $request->edit_id;
        $doc_id = $request->doc_id;
        $doc = $request->doc;
        foreach($doc_id as $docid)
        {
            if(!empty($edit_id[$docid]))
            {
                $data=FlightDocAssign::find($edit_id[$docid]);
            }else{
                $data=new FlightDocAssign;
            }
            $data->master_id=$docid;
            $data->flying_log_id=$flying_log_id;
            if(!empty($doc[$docid]))
            {
                $file=$doc[$docid];
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('uploads/flight_doc'), $name);
                $data->doc=$name;
            }
            $data->save();
        }
        return response()->json([
            'success' => true,
            'message' => 'License Added Successfully'
        ]);
    }
    
    public function get_city(Request $request)
    {
        $state_id = $request->state_id;
        $row = City::where('state_id',$state_id)->get();
        $html= '';
        if(!empty($row))
        {
            foreach ($row as $key => $value) {
                $html.= '<option value="'.$value->id.'">'.$value->name.'</option>';
            }
        }
        echo json_encode($html);
    }
    
    public function getSector(Request $request)
    {   
        $term=$request->term;
        $masters = Master::where('name', 'LIKE', '%' .$term. '%')->where('type', '=', 'sectors')->where('status','active')->pluck('name')->all();
        return response()->json($masters);
    }
    public function userIndex()
    {
        return view('theme-one.dashboard');
    }

    public function changeTimezone(Request $request)
    {
        $timezone = $request->timezone;
        session(['timezone' => $timezone]);
        return response()->json([
            'success' => true
        ]);
    }
}
