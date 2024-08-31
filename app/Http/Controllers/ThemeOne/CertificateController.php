<?php
namespace App\Http\Controllers\ThemeOne;


use App\Models\User;

use App\Models\Master;
use App\Models\PilotLicense;
use App\Models\PilotMedical;
use Illuminate\Http\Request;
use App\Models\PilotTraining;
use App\Models\PilotQualification;
use Illuminate\Support\Facades\DB;
use App\Models\PilotGroundTraining;
use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['permission:Certificate Add|Certificate Edit|Certificate Delete|Certificate View']);
    }

    public function licence()
    {
        $sub_title = "Licence";
        $pilots = User::with('designation')->where('is_delete','0')->where('status','active')->get();
        return view('theme-one.certificate.licence',compact('sub_title','pilots'));
    }

    public function myLicence()
    {
        $sub_title = "My Licence";
        $user = User::with('designation')->where('id', Auth()->user()->id)->where('is_delete', '0')->where('status', 'active')->first();
        $pilots = collect([$user]);
        return view('theme-one.certificate.licence',compact('sub_title','pilots'));
    }
    public function licenceList(Request $request)
    {
        $column=['id','id','users.salutation','users.name','license.name','renewed_on','extended_date','next_due','status','created_at','id','id'];
        $users=PilotLicense::with(['user'=>function($q) {
            $q->where('status','active');
        }])->where('is_applicable','yes')->groupBy('license_id', 'user_id')->orderBy('id', 'desc');

        if(!empty($_POST['user_id']))
        {
            $users->where('user_id',$_POST['user_id']);
        }
        $dates=date('Y-m-d');
        if(!empty($_POST['dates']))
        {
            $dates=$_POST['dates'];
        }

        $total_row=$users->get()->count();

        if (!empty($_POST['search']['value'])) {
            $search = $_POST['search']['value'];
            $users->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(salutation, ' ', name)"), 'LIKE', '%' . $search . '%')
                      ->orWhere('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhereHas('license', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhere('renewed_on', 'LIKE', '%' . $search . '%')
                  ->orWhere('extended_date', 'LIKE', '%' . $search . '%')
                  ->orWhere('next_due', 'LIKE', '%' . $search . '%')
                  ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
		if (isset($_POST['order'])) {
            $users->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
            $users->orderBy('id', 'desc');
        }
		$filter_row = $users->get()->count();
        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $users->skip($_POST["start"])->take($_POST["length"]);
		}
        $result = $users->get();
        $data = array();
		foreach($result as $key => $value) {

            $action  = '<a href="javascript:void(0);" onclick="showData('.$value->id.',\'license\')" class="btn btn-primary btn-sm m-1">View</a>';
            $action  .= '<a href="' . route('user.certificate.viewLogs', ['type' => 'licence-logs', 'user_id' => $value->user->id, 'id' => $value->license->id]) . '" class="btn btn-warning btn-sm m-1">Log</a>';

            $status='Active';
            $sub_array = array();
			$sub_array[] = ++$key;
            $sub_array[] = ($value->user->salutation ?? '') . ' ' . ($value->user->name ?? '');
            $sub_array[] = $value->license->name ?? '';
            $sub_array[] = '<b>' . $value->renewed_on ?? '' . '</b>';
            $sub_array[] = $value->extended_date ?? '';
            $sub_array[] = $value->next_due ?? '';
            $next_due='';
            if(strtotime($value->next_due) > strtotime($dates))
            {
                $day=\Carbon\Carbon::parse( $dates )->diffInDays($value->next_due );
                $bt='style="background-color: #1e24dd;color: white;"';
                if($day<=60)
                {
                    $bt='style="background-color: yellow;color: #161515;"';
                }
                if($day<=30)
                {
                   $bt='style="background-color: orange;color: #161515;"';
                }
                $next_due='<button '.$bt.' type="button" class="btn btn-sm position-relative">'.$day.'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Valid<span class="visually-hidden">unread messages</span></span></button>';
            }else{
                $next_due='<span class="btn btn-sm btn-danger">Lapsed</span>';
            }

            $sub_array[] = $next_due ?? '';
            $sub_array[] = $status;
            $sub_array[] = $action;
            $data[] = $sub_array;
        }
        $output = array(
			"draw"   =>  intval($_POST["draw"]),
			"recordsTotal"   =>  $total_row,
			"recordsFiltered"  =>  $filter_row,
			"data"   =>  $data
		);
		echo json_encode($output);
    }

    public function trainings()
    {
        $sub_title = "Training";
        $pilots = User::with('designation')->where('is_delete','0')->where('status','active')->get();
        return view('theme-one.certificate.training',compact('sub_title','pilots'));
    }

    public function myTrainings()
    {
        $sub_title = "My Training";
        $user = User::with('designation')->where('id', Auth()->user()->id)->where('is_delete', '0')->where('status', 'active')->first();
        $pilots = collect([$user]);
        return view('theme-one.certificate.training',compact('sub_title','pilots'));
    }

    public function trainingList(Request $request)
    {
        $column=['id','id','users.salutation','users.name','training.name','renewed_on','extended_date','next_due','status','created_at','id','id'];
        $users=PilotTraining::with(['user'=>function($q) {
            $q->where('status','active');
        }])->where('is_applicable','yes')->groupBy('training_id', 'user_id')->orderBy('id', 'desc');

        if(!empty($_POST['user_id']))
        {
            $users->where('user_id',$_POST['user_id']);
        }
        $dates=date('Y-m-d');
        if(!empty($_POST['dates']))
        {
            $dates=$_POST['dates'];
        }

        $total_row=$users->get()->count();

        if (!empty($_POST['search']['value'])) {
            $search = $_POST['search']['value'];
            $users->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(salutation, ' ', name)"), 'LIKE', '%' . $search . '%')
                      ->orWhere('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhereHas('training', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhere('renewed_on', 'LIKE', '%' . $search . '%')
                  ->orWhere('extended_date', 'LIKE', '%' . $search . '%')
                  ->orWhere('next_due', 'LIKE', '%' . $search . '%')
                  ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
		if (isset($_POST['order'])) {
            $users->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
            $users->orderBy('id', 'desc');
        }
		$filter_row = $users->get()->count();
        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $users->skip($_POST["start"])->take($_POST["length"]);
		}
        $result =$users->get();
        // return $result[0]->training_id;
        $data = array();
		foreach($result as $key => $value) {

            $action  = '<a href="javascript:void(0);" onclick="showData('.$value->id.',\'training\')" class="btn btn-primary btn-sm m-1">View</a>';
            $action  .= '<a href="'.route('user.certificate.viewLogs', ['type' => 'training-logs', 'user_id' => $value->user_id, 'id' => $value->training_id]).'" class="btn btn-warning btn-sm m-1">Log</a>';

            $status='Active';
            $sub_array = array();
			$sub_array[] = ++$key;
            $sub_array[] = ($value->user->salutation ?? '') . ' ' . ($value->user->name ?? '');
            $sub_array[] = $value->training->name ?? '';
            $sub_array[] = '<b>' . $value->renewed_on . '</b>';
            $sub_array[] = $value->extended_date;
            $sub_array[] = $value->next_due;
            if(!empty($value->next_due)&&strtotime($value->next_due) > strtotime($dates))
            {
                $day=\Carbon\Carbon::parse( $dates )->diffInDays($value->next_due );
                $bt='style="background-color: #1e24dd;color: white;"';
                if($day<=60)
                {
                    $bt='style="background-color: yellow;color: #161515;"';
                }
                if($day<=30)
                {
                   $bt='style="background-color: orange;color: #161515;"';
                }
                $next_due='<button '.$bt.' type="button" class="btn btn-sm position-relative">'.$day.'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Valid<span class="visually-hidden">unread messages</span></span></button>';
            }else{
                $next_due='<span class="btn btn-sm btn-danger">Lapsed</span>';
            }

            $sub_array[] = $next_due;
            $sub_array[] = $status;
            $sub_array[] = $action;
            $data[] = $sub_array;
        }
        $output = array(
			"draw"   =>  intval($_POST["draw"]),
			"recordsTotal"   =>  $total_row,
			"recordsFiltered"  =>  $filter_row,
			"data"   =>  $data
		);
		echo json_encode($output);
    }

    public function medicals(Request $request)
    {
        $sub_title = "Medical";
        $pilots = User::with('designation')->where('is_delete','0')->where('status','active')->get();
        return view('theme-one.certificate.medical',compact('sub_title','pilots'));
    }

    public function myMedicals(Request $request)
    {
        $sub_title = "My Medical";
        $user = User::with('designation')->where('id', Auth()->user()->id)->where('is_delete', '0')->where('status', 'active')->first();
        $pilots = collect([$user]);
        return view('theme-one.certificate.medical',compact('sub_title','pilots'));
    }

    public function medicalList(Request $request)
    {
        $column=['id','id','users.salutation','users.name','medical.name','renewed_on','extended_date','next_due','status','created_at','id','id'];
        $users=PilotMedical::with(['user'=>function($q) {
            $q->where('status','active');
        }])->where('is_applicable','yes')->groupBy('medical_id', 'user_id')->orderBy('id', 'desc');

        if(!empty($_POST['user_id']))
        {
            $users->where('user_id',$_POST['user_id']);
        }
        $dates=date('Y-m-d');
        if(!empty($_POST['dates']))
        {
            $dates=$_POST['dates'];
        }

        $total_row=$users->get()->count();

        if (!empty($_POST['search']['value'])) {
            $search = $_POST['search']['value'];
            $users->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(salutation, ' ', name)"), 'LIKE', '%' . $search . '%')
                      ->orWhere('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhereHas('medical', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhere('renewed_on', 'LIKE', '%' . $search . '%')
                  ->orWhere('extended_date', 'LIKE', '%' . $search . '%')
                  ->orWhere('next_due', 'LIKE', '%' . $search . '%')
                  ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
		if (isset($_POST['order'])) {
            $users->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
            $users->orderBy('id', 'desc');
        }
		$filter_row = $users->get()->count();

        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $users->skip($_POST["start"])->take($_POST["length"]);
		}
        $result =$users->get();
        $data = array();
		foreach($result as $key => $value) {

            $action  = '<a href="javascript:void(0);" onclick="showData('.$value->id.',\'medical\')" class="btn btn-primary btn-sm m-1">View</a>';
            $action  .= '<a href="'.route('user.certificate.viewLogs', ['type' => 'medical-logs', 'user_id' => $value->user_id, 'id' => $value->medical_id]).'" class="btn btn-warning btn-sm m-1">Log</a>';

            $status='Active';
            $sub_array = array();
			$sub_array[] = ++$key;
            $sub_array[] = ($value->user->salutation ?? '') . ' ' . ($value->user->name ?? '');
            $sub_array[] = $value->medical->name ?? '';
            $sub_array[] = '<b>' . $value->planned_renewal_date ?? '' . '</b>';
            $sub_array[] = $value->extended_date ?? '';
            $sub_array[] = $value->next_due ?? '';
            if(strtotime($value->next_due) > strtotime($dates))
            {
                $day=\Carbon\Carbon::parse( $dates )->diffInDays($value->next_due );
                $bt='style="background-color: #1e24dd;color: white;"';
                if($day<=60)
                {
                    $bt='style="background-color: yellow;color: #161515;"';
                }
                if($day<=30)
                {
                   $bt='style="background-color: orange;color: #161515;"';
                }
                $next_due='<button '.$bt.' type="button" class="btn btn-sm position-relative">'.$day.'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Valid<span class="visually-hidden">unread messages</span></span></button>';
            }else{
                $next_due='<span class="btn btn-sm btn-danger">Lapsed</span>';
            }

            $sub_array[] = $next_due ?? ''; // strtotime($value->next_due) > strtotime($dates)?'<button type="button" class="btn btn-primary btn-sm position-relative">'.\Carbon\Carbon::parse($dates)->diffInDays($value->next_due ).'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Valid<span class="visually-hidden">unread messages</span></span></button>':'<span class="btn btn-sm btn-danger">Lapsed</span>';
            $sub_array[] = $status;
            $sub_array[] = $action;
            $data[] = $sub_array;
        }
        $output = array(
			"draw"   =>  intval($_POST["draw"]),
			"recordsTotal"   =>  $total_row,
			"recordsFiltered"  =>  $filter_row,
			"data"   =>  $data
		);
		echo json_encode($output);
    }

    public function qualifications(Request $request)
    {
        $sub_title = "Qualification";
        $pilots = User::with('designation')->where('is_delete','0')->where('status','active')->get();
        return view('theme-one.certificate.qualification',compact('sub_title','pilots'));
    }

    public function myQualifications(Request $request)
    {
        $sub_title = "My Qualification";
        $user = User::with('designation')->where('id', Auth()->user()->id)->where('is_delete', '0')->where('status', 'active')->first();
        $pilots = collect([$user]);
        return view('theme-one.certificate.qualification',compact('sub_title','pilots'));
    }

    public function qualificationList(Request $request)
    {
        $column=['id','id','users.salutation','users.name','qualification.name','renewed_on','extended_date','next_due','status','created_at','id','id'];
        $users=PilotQualification::with(['user'=>function($q) {
            $q->where('status','active');
        }])->where('is_applicable','yes')->groupBy('qualification_id', 'user_id')->orderBy('id', 'desc');

        if(!empty($_POST['user_id']))
        {
            $users->where('user_id',$_POST['user_id']);
        }
        $dates=date('Y-m-d');
        if(!empty($_POST['dates']))
        {
            $dates=$_POST['dates'];
        }

        $total_row=$users->get()->count();

        if (!empty($_POST['search']['value'])) {
            $search = $_POST['search']['value'];
            $users->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(salutation, ' ', name)"), 'LIKE', '%' . $search . '%')
                      ->orWhere('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhereHas('qualification', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhere('renewed_on', 'LIKE', '%' . $search . '%')
                  ->orWhere('extended_date', 'LIKE', '%' . $search . '%')
                  ->orWhere('next_due', 'LIKE', '%' . $search . '%')
                  ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
		if (isset($_POST['order'])) {
            $users->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
            $users->orderBy('id', 'desc');
        }
		$filter_row = $users->get()->count();

        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $users->skip($_POST["start"])->take($_POST["length"]);
		}
        $result =$users->get();
        $data = array();
		foreach($result as $key => $value) {

            $action  = '<a href="javascript:void(0);" onclick="showData('.$value->id.',\'qualification\')" class="btn btn-primary btn-sm m-1">View</a>';
            $action  .= '<a href="'.route('user.certificate.viewLogs', ['type' => 'qualification-logs', 'user_id' => $value->user_id, 'id' => $value->qualification_id]).'" class="btn btn-warning btn-sm m-1">Log</a>';

            $status='Active';
            $sub_array = array();
			$sub_array[] = ++$key;
            $sub_array[] = ($value->user->salutation ?? '') . ' ' . ($value->user->name ?? '');
            $sub_array[] = $value->qualification->name ?? '';
            $sub_array[] = '<b>' . $value->renewed_on ?? '' . '</b>';
            $sub_array[] = $value->extended_date ?? '';
            $sub_array[] = $value->next_due ?? '';
            if(strtotime($value->next_due) > strtotime($dates))
            {
                $day=\Carbon\Carbon::parse( $dates )->diffInDays($value->next_due );
                $bt='style="background-color: #1e24dd;color: white;"';
                if($day<=60)
                {
                    $bt='style="background-color: yellow;color: #161515;"';
                }
                if($day<=30)
                {
                   $bt='style="background-color: orange;color: #161515;"';
                }
                $next_due='<button '.$bt.' type="button" class="btn btn-sm position-relative">'.$day.'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Valid<span class="visually-hidden">unread messages</span></span></button>';
            }else{
                $next_due='<span class="btn btn-sm btn-danger">Lapsed</span>';
            }

            $sub_array[] = $next_due ?? '';
            $sub_array[] = $status;
            $sub_array[] = $action;
            $data[] = $sub_array;
        }
        $output = array(
			"draw"   =>  intval($_POST["draw"]),
			"recordsTotal"   =>  $total_row,
			"recordsFiltered"  =>  $filter_row,
			"data"   =>  $data
		);
		echo json_encode($output);
    }

    public function groundTrainings(Request $request)
    {
        $sub_title = "Ground Training";
        $pilots = User::with('designation')->where('is_delete','0')->where('status','active')->get();
        return view('theme-one.certificate.ground-training',compact('sub_title','pilots'));
    }

    public function myGroundTrainings(Request $request)
    {
        $sub_title = "My Ground Training";
        $user = User::with('designation')->where('id', Auth()->user()->id)->where('is_delete', '0')->where('status', 'active')->first();
        $pilots = collect([$user]);
        return view('theme-one.certificate.ground-training',compact('sub_title','pilots'));
    }

    public function groundTrainingList(Request $request)
    {
        $column=['id','id','users.salutation','users.name','training.name','renewed_on','extended_date','next_due','status','created_at','id','id'];
        $users=PilotGroundTraining::with(['user'=>function($q) {
            $q->where('status','active');
        }])->where('is_applicable','yes')->groupBy('training_id', 'user_id')->orderBy('id', 'desc');

        if(!empty($_POST['user_id']))
        {
            $users->where('user_id',$_POST['user_id']);
        }
        $dates=date('Y-m-d');
        if(!empty($_POST['dates']))
        {
            $dates=$_POST['dates'];
        }

        $total_row=$users->get()->count();

        if (!empty($_POST['search']['value'])) {
            $search = $_POST['search']['value'];
            $users->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(salutation, ' ', name)"), 'LIKE', '%' . $search . '%')
                      ->orWhere('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhereHas('training', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhere('renewed_on', 'LIKE', '%' . $search . '%')
                  ->orWhere('extended_date', 'LIKE', '%' . $search . '%')
                  ->orWhere('next_due', 'LIKE', '%' . $search . '%')
                  ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }
		if (isset($_POST['order'])) {
            $users->orderBy($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
            $users->orderBy('id', 'desc');
        }
		$filter_row = $users->get()->count();
        if (isset($_POST["length"]) && $_POST["length"] != -1) {
            $users->skip($_POST["start"])->take($_POST["length"]);
		}
        $result =$users->get();
        $data = array();
		foreach($result as $key => $value) {

            $action  = '<a href="javascript:void(0);" onclick="showData('.$value->id.',\'groundtraining\')" class="btn btn-primary btn-sm m-1">View</a>';
            $action  .= '<a href="'.route('user.certificate.viewLogs', ['type' => 'ground-training-logs', 'user_id' => $value->user_id, 'id' => $value->training_id]).'" class="btn btn-warning btn-sm m-1">Log</a>';

            $status='Active';
            $sub_array = array();
			$sub_array[] = ++$key;
            $sub_array[] = ($value->user->salutation ?? '') . ' ' . ($value->user->name ?? '');
            $sub_array[] = $value->training->name ?? '';
            $sub_array[] = '<b>' . $value->renewed_on ?? '' . '</b>';
            $sub_array[] = $value->extended_date ?? '';
            $sub_array[] = $value->next_due ?? '';
            if(strtotime($value->next_due) > strtotime($dates))
            {
                $day=\Carbon\Carbon::parse( $dates )->diffInDays($value->next_due );
                $bt='style="background-color: #1e24dd;color: white;"';
                if($day<=60)
                {
                    $bt='style="background-color: yellow;color: #161515;"';
                }
                if($day<=30)
                {
                   $bt='style="background-color: orange;color: #161515;"';
                }
                $next_due='<button '.$bt.' type="button" class="btn btn-sm position-relative">'.$day.'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Valid<span class="visually-hidden">unread messages</span></span></button>';
            }else{
                $next_due='<span class="btn btn-sm btn-danger">Lapsed</span>';
            }

            $sub_array[] = $next_due ?? ''; //strtotime($value->next_due) > strtotime($dates)?'<button type="button" class="btn btn-primary btn-sm position-relative">'.\Carbon\Carbon::parse($dates)->diffInDays($value->next_due ).'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Valid<span class="visually-hidden">unread messages</span></span></button>':'<span class="btn btn-sm btn-danger">Lapsed</span>';
            $sub_array[] = $status;
            $sub_array[] = $action;
            $data[] = $sub_array;
        }
        $output = array(
			"draw"   =>  intval($_POST["draw"]),
			"recordsTotal"   =>  $total_row,
			"recordsFiltered"  =>  $filter_row,
			"data"   =>  $data
		);
		echo json_encode($output);
    }
    public function viewLogs($type, $user_id, $id)
    {
        if($type=='licence-logs'){
            $sub_title = "Licence Logs";
        } else if($type=='training-logs'){
            $sub_title = "Training Logs";
        } else if($type=='medical-logs'){
            $sub_title = "Medical Logs";
        } else if($type=='qualification-logs'){
            $sub_title = "Qualification Logs";
        } else if($type=='ground-training-logs'){
            $sub_title = "Ground Training Logs";
        }
        return view('theme-one.certificate.view-logs',compact('sub_title','type','user_id','id'));
    }
    public function getLogList(Request $request)
    {
        $column = [
            'id', 'id', 'users.salutation', 'users.name', 'license.name',
            'renewed_on', 'extended_date', 'next_due', 'status', 'created_at', 'id', 'id'
        ];

        $type = $request->input('type');
        $user_id = $request->input('user_id');
        $id = $request->input('id');
        $model = null;
        $table = null;
        $where['user_id'] = $user_id;
        switch ($type) {
            case 'licence-logs':
                $model = PilotLicense::class;
                $where['license_id'] = $id;
                $table = "license";
                break;
            case 'training-logs':
                $model = PilotTraining::class;
                $where['training_id'] = $id;
                $table = "training";
                break;
            case 'medical-logs':
                $model = PilotMedical::class;
                $where['medical_id'] = $id;
                $table = "medical";
                break;
            case 'qualification-logs':
                $model = PilotQualification::class;
                $where['qualification_id'] = $id;
                $table = "qualification";
                break;
            case 'ground-training-logs':
                $model = PilotGroundTraining::class;
                $where['training_id'] = $id;
                $table = "training";
                break;
            default:
                return response()->json(['error' => 'Invalid log type'], 400);
        }

        if (!$model) {
            return response()->json(['error' => 'Invalid log type'], 400);
        }

        $users = $model::with(['user' => function($q) {
            $q->where('status', 'active');
        }])->where('is_applicable', 'yes')->where($where);

        if ($request->has('search.value') && $search = $request->input('search.value')) {
            $users->where(function ($q) use ($search, $table) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(salutation, ' ', name)"), 'LIKE', '%' . $search . '%')
                      ->orWhere('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhereHas($table, function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
                $q->orWhere('renewed_on', 'LIKE', '%' . $search . '%')
                  ->orWhere('extended_date', 'LIKE', '%' . $search . '%')
                  ->orWhere('next_due', 'LIKE', '%' . $search . '%')
                  ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->has('order')) {
            $users->orderBy($column[$request->input('order.0.column')], $request->input('order.0.dir'));
        } else {
            $users->orderBy('id', 'desc');
        }

        $total_row = $users->count();

        if ($request->has('length') && $request->input('length') != -1) {
            $users->skip($request->input('start'))->take($request->input('length'));
        }

        $result = $users->get();

        $data = array();
        foreach ($result as $key => $value) {
            if($value->documents){
                $action  = '<a href="' . asset('uploads/pilot_certificate/' . $value->documents) . '" target="_blank" class="btn btn-info btn-sm py-1 text-white">View</a>';
            } else {
                $action  = '<a href="javascript:void(0)" class="text-red">Not Available</a>';
            }

            $status = 'Active';
            $sub_array = array();
            $sub_array[] = ++$key;
            $sub_array[] = ($value->user->salutation ?? '') . ' ' . ($value->user->name ?? '');
            $sub_array[] = $value->$table->name ?? '';
            $sub_array[] = '<b>' . $value->renewed_on . '</b>';
            $sub_array[] = $value->extended_date;
            $sub_array[] = $value->next_due;

            $next_due = '';
            $dates = now();  // Assuming $dates is current date. Adjust if needed.
            if (strtotime($value->next_due) > strtotime($dates)) {
                $day = \Carbon\Carbon::parse($dates)->diffInDays($value->next_due);
                $bt = 'style="background-color: #1e24dd;color: white;"';
                if ($day <= 60) {
                    $bt = 'style="background-color: yellow;color: #161515;"';
                }
                if ($day <= 30) {
                    $bt = 'style="background-color: orange;color: #161515;"';
                }
                $next_due = '<button ' . $bt . ' type="button" class="btn btn-sm position-relative">' . $day . '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">Valid<span class="visually-hidden">unread messages</span></span></button>';
            } else {
                $next_due = '<span class="btn btn-sm btn-danger">Lapsed</span>';
            }

            $sub_array[] = $next_due;
            $sub_array[] = $status;
            $sub_array[] = $action;
            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($request->input("draw")),
            "recordsTotal" => $total_row,
            "recordsFiltered" => $users->count(),
            "data" => $data
        );

        return response()->json($output);
    }

    public function viewData(Request $request)
    {
        $id =$request->id;
        $type =$request->type;
        if($type=='license')
        {
            $data=PilotLicense::with(['user'=>function($q) {
                $q->where('status','active');
            }])->where('is_applicable','yes')->where('id',$id)->first();
            $html=view('theme-one.certificate.view-license',compact('data'))->render();
        }if($type=='training')
        {
            $data=PilotTraining::with(['user'=>function($q) {
                $q->where('status','active');
            }])->where('is_applicable','yes')->where('id',$id)->first();
            $ac_types=Master::where('type','aircraft_type')->where('is_delete','0')->get();
            $html=view('theme-one.certificate.view-training',compact('data','ac_types'))->render();
        }if($type=='medical')
        {
            $data=PilotMedical::with(['user'=>function($q) {
                $q->where('status','active');
            }])->where('is_applicable','yes')->where('id',$id)->first();
            $html=view('theme-one.certificate.view-medical',compact('data'))->render();
        }if($type=='qualification')
        {
            $data=PilotQualification::with(['user'=>function($q) {
                $q->where('status','active');
            }])->where('is_applicable','yes')->where('id',$id)->first();
            $html=view('theme-one.certificate.view-qualification',compact('data'))->render();
        }if($type=='groundtraining')
        {
            $data=PilotGroundTraining::with(['user'=>function($q) {
                $q->where('status','active');
            }])->where('is_applicable','yes')->where('id',$id)->first();
            $html=view('theme-one.certificate.view-groundtraining',compact('data'))->render();
        }
        echo $html;
    }

}
