<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DB\MyDB;

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
    public function index(Request $request)
    {
        $data = MyDB::select_dentist_users_info();
        $person_id =  MyDB::select_person_id($request->user()->id);
        return view('home', ['dentists' => $data, 'person' => $person_id]);
    }

    public function create_role(Request $request, $id, $role){
        if(isset($role)){
            MyDB::insert_dentist($id);
        }else{
            MyDB::insert_person($id);
        }
    }
}
