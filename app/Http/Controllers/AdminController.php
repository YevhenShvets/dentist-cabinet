<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\DB\MyDB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function ShowLoginForm()
    {
       return view('auth.admin-login');
    }

    public function Login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            return redirect()->route('admin.home');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function index(){
        return view('admin.home');
    }

    public function add_clinic(){
        return view('admin.add_clinic');
    }

    public function add_clinic_submit(Request $request){
        $v = Validator::make($request->all(), [
            'title' => ['required',],
            'address' => ['required'],
            'description' => ['required']
        ]);

        if ($v->fails()) {
            return redirect()->route('admin.add_clinic')
                        ->withErrors($v)
                        ->withInput();
        }
        else{
            $data = array(
                'title' => $request->input("title"),
                'address' => $request->input("address"),
                'description' => $request->input("description")
            );
            MyDB::insert_clinic($data);
            return redirect()->route('admin.home');
        }
    }

    public function add_dentist(){
        $users = MyDB::select_users();
        $clinics = MyDB::select_clinics();

        return view('admin.add_dentist', ['users' => $users, 'clinics' => $clinics]);
    }

    public function add_dentist_submit(Request $request){
        $v = Validator::make($request->all(), [
            'user_id' => ['required'],
            'clinic_id' => ['required'],
        ]);

        if ($v->fails()) {
            return redirect()->route('admin.add_dentist')
                        ->withErrors($v)
                        ->withInput();
        }
        else{
            $data = array(
                'dentist_id' => $request->input("user_id"),
                'clinic_id' => $request->input("clinic_id")
            );
            MyDB::insert_dentist_($data);
            return redirect()->route('admin.home');
        }
    }

    public function delete_user(){
        $users = MyDB::select_all_users();
        return view('admin.delete_user', ['users' => $users]);
    }

    public function delete_user_submit(Request $request){
        $v = Validator::make($request->all(), [
            'user_id' => ['required'],
        ]);

        if ($v->fails()) {
            return redirect()->route('admin.delete_user')
                        ->withErrors($v)
                        ->withInput();
        }
        else{
            MyDB::delete_user($request->input('user_id'));
            return redirect()->route('admin.home');
        }
    }
}
