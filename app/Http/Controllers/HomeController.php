<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gender;
use App\Social;
use Auth;
use Yajra\DataTables\DataTables;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::leftjoin('genders','genders.gender_id','=','users.gender')->where('id',Auth::user()->id)->first();

        $social = Social::WhereIn('socail_id',explode(",",$user->social))->get();
        $social = $social->pluck('socail_name')->toArray();
        $data = array(
            'user' => $user,
            'social' => $social
        );
        return view('home',$data);
    }

    public function list(){
        $user = User::leftjoin('genders','genders.gender_id','=','users.gender')
                ->leftjoin('socials','socials.socail_id','=','users.social')
                ->get();
        
        $data = array(
            'user' => $user,
        );

        return view('list',$data);
    }

    public function datatablesuser(Request $request){

        return Datatables::of($users)
                ->editColumn('name',function($data){
                     return $data->name." ".$data->lastname;
                })
                ->editColumn('bank',function($data){
                    return $data->bank_name != "" ? $data->bank_name : "-" ;
                })
                ->editColumn('bank_no',function($data){
                    return $data->bank_no != "" ? $data->bank_no : "-" ;
                })
                ->editColumn('type',function($data){
                  
                    return '<span class="text-success font-weight-light">'.$data->type_name.'</span>';
                
                })
                ->editColumn('status',function($data){
                    if($data->user_delete == null){
                        return '<span class="badge badge-success font-weight-light">ใช้งาน</span>';
                    }else{
                        return '<span class="badge badge-danger font-weight-light">ยกเลิก</span>';
                    }
                })
                ->addColumn('approve',function($data){
                    if($data->user_delete == null){
                        $checked = "checked";
                    }else{
                        $checked = "";
                    }

                    return '  <input '.$checked.'  type="checkbox" name="approve" atr="'.$data->id.'" data-render="switchery" class="js-switch" data-theme="default"  data-id="switchery-state" /> ';
                })
                ->addColumn('action', function($data){
                    if($data->user_delete == null){
                        $btn = '<button onclick="updatewallet('.$data->id.')"  class=" btn btn-warning btn-sm"><i class="fa fa-money" aria-hidden="true"></i></button>  ';
                    }else{
                        $btn = "";
                    }
          
                        $btn = $btn. '<button onclick="showuser('.$data->id.')" class="showuser btn btn-info btn-sm">ดู</button>  ';
                   
                    if($data->user_delete == null){
                       
                        $btn = $btn.'<a href="'.route('user.edit',$data->id).'" class="edit btn btn-primary btn-sm">แก้ไข</a> ';
                    }

                     return $btn;
                })
                ->rawColumns(['action','approve','status','type'])
                ->make(true);
    }
}
