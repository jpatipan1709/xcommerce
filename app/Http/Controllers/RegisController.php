<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gender;
use App\Social;
use Hash;
use DB;
class RegisController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function regisform(){

        
        $genders = Gender::all();
        $socials  = Social::all();

        $data = array(
            'genders' => $genders,
            'socials' => $socials,
        );
   
        return view('auth.register',$data);
    }
    public function register(Request $request)
    {
        $rules = [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthday' => ['date'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/', 'confirmed'],
        ];
    
        $customMessages = [
            'required'       => 'กรุณาใส่ข้อมูล :attribute ',
            'unique'         => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',
            'max'            => 'คุณสามารถใส่ตัวอักษร :attribute ไม่เกิน :max ตัวอักษร',
            'min'            => 'คุณต้องใส่ตัวอักษร :attribute อย่างน้อย :min ตัวอักษร',
            'confirmed'      => 'รหัสผ่านไม่ตรงกัน โปรดตรวจสอบอีกครั้ง',
            'regex'          => 'กรุณาระบุรหัสผ่านที่มี อักษรตัวใหญ่ 1 ตัว อักษรพิมพ์เล็ก 1 ตัว และเครื่องหมายพิเศษ',
            'string'         => 'กรุณาใส่ข้อมูล :attribute เป็นตัวอักษรเท่านั้น',
            'email'          => 'กรุณาใส่ข้อมูล :attribute เป็นรูปแบบอีเมล์เท่านั้น'

        ];

        $this->validate($request, $rules, $customMessages);

        $social_im = implode(",",$request->social);


        DB::beginTransaction();
        try {
            $user = new User;
            $user->firstname        = $request['firstname'];
            $user->lastname         = $request['lastname'];
            $user->birthday         = $request['birthday'];
            $user->gender           = $request['gender'];
            $user->social           = $social_im;
            $user->email            = $request['email'];
            $user->password         = Hash::make($request['password']);
            if($files =  $request->file('images')) {
                $fileName = date('YmdHis').time() . "." . $files->getClientOriginalExtension();
                $filePath = $files->storeAs('uploads', $fileName, 'public');
                $user->images          = $filePath;
            }
            $user->save();
            DB::commit();
            return redirect('regisform')->with('success','เพิ่มข้อมูลผู้ใช้งาน เรียบร้อย!!');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            dd($e);
            return redirect('regisform')->with('error','ไม่สามารถเพิ่มข้อมูลผู้ใช้งาน!!');
        }

    }

   
}
