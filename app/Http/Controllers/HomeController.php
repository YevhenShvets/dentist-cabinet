<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DB\MyDB;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = MyDB::select_dentist_users_info();
        $clinics = DB::table('clinic')->paginate(6);
        $feedbacks = MyDB::select_publish_feedbacks();
        $search = $request->input('search');
        if($search && $search !=""){
            $clinics = MyDB::select_clinics_search($search);
            // dd();
        }
        $filter = $request->input('filter');
        if($filter){
            if($filter == 'counts'){
                $clinics = MyDB::select_clinics_filter_counts();
            }
        }
        if($request->user()){
            $person_id =  MyDB::select_person_id($request->user()->id);
        }else{
            $person_id = NULL;
        }
        return view('home', ['dentists' => $data, 'person' => $person_id, 'clinics' => $clinics, 'feedbacks' => $feedbacks]);
    }
    

    public function clinic($id, Request $request){
        $clinic = MyDB::select_clinic($id);
        if($clinic){
            $dentists = MyDB::select_dentists($clinic->id);
        }
        if($request->user()){
            $person_id =  MyDB::select_person_id($request->user()->id);
        }else{
            $person_id = NULL;
        }
        return view('clinic', ['clinic' => $clinic, 'dentists' => $dentists, 'person_id' => $person_id]);
    }


    public function contacts(){
        return view('contacts');
    }

    public function contacts_submit(Request $request){
        $name = $request->input('name');
        $phone = $request->input('phone');
        $message = $request->input('message');

        MyDB::insert_contacts($name, $phone, $message);

        return redirect()->route('home');
    }
}
