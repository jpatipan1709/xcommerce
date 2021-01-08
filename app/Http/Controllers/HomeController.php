<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gender;
use App\Social;
use Auth;
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
}
