<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DB\MyDB;
use Illuminate\Support\Facades\Validator;
use DateTime;

class UserController extends Controller
{
    public function dentist_record(Request $request, $dentist_id){
        $dentist_info = MyDB::select_dentist_info($dentist_id);
        return view('user.dentist', ['dentist' => $dentist_info]);
    }

    public function dentist_record_create(Request $request, $id){
        $v = Validator::make($request->all(), [
            'date_record' => ['required',],
            'time_record' => ['required'],
            'person_id' => ['required'],
            'dentist_id' => ['required']
        ]);

        if ($v->fails()) {
            return redirect()->route('dentist_record')
                        ->withErrors($v)
                        ->withInput();
        }
        else{
            $date_record = new DateTime(($request->input("date_record")));
            $date_record->setTime(intval($request->input("time_record")), 00);
            $data = array(
                'person_id' => $request->input("person_id"),
                'dentist_id' => $request->input("dentist_id"),
                'date_record' => $date_record,
                'active' => true
            );
            MyDB::insert_record($data);
            MyDB::insert_chat(MyDB::select_record_id($request->input("person_id"), $request->input("dentist_id")));
            return redirect()->route('cabinet');
        }
    }
    
    public function cabinet(Request $request){
        $user_id = $request->user()->id;
        $records_dentist = MyDB::select_records_for_dentist($user_id);
        $records_info = MyDB::select_records_info($user_id);
        $person_id = MyDB::select_person_id($user_id);
        return  view('user.cabinet', ['recordsDentist' => $records_dentist, 'records' => $records_info, 'person' => $person_id]);
    }

    public function record_info(Request $request, $id){
        $user_id = $request->user()->id;
        $record_data = MyDB::select_record_info($id);
        $person_info = MyDB::get_user_data($record_data->person_id);
        $messages = MyDB::select_messages($id);
        return  view('user.record', ['record' => $record_data, 'person_info' => $person_info, 'messages' => $messages]);
    }

    public function message_create(Request $request, $id){
        $chat_id = MyDB::select_chat_id($id);
        $data = array(
            'chat_id' => $chat_id,
            'user_id' => $request->input("user_id"),
            'message_text' => $request->input("message"),
            'date_create' => date('Y-m-d\TH:i')
        );
        MyDB::insert_message($data);
        return redirect()->route('record_info', [$id]);
    }

    public function settings(Request $request){
        $user_id = $request->user()->id;
        $user_data = MyDB::get_user_data($user_id);
        $dentist = MyDB::select_dentist_info($user_id);
        return  view('user.settings', ['user' => $user_data, 'dentist' => $dentist]);
    }

    public function settings_update(Request $request){
        $v = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'date_birthday' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:20']
        ]);

        if ($v->fails()) {
            return redirect()->route('settings')
                        ->withErrors($v)
                        ->withInput();
        }
        else{
            $data = array(
                'id' => $request->user()->id,
                'name' => $request->input("name"),
                'middlename' => $request->input("middlename"),
                'surname' => $request->input("surname"),
                'date_birthday' => $request->input("date_birthday"),
                'phone' => $request->input("phone")
            );
            MyDB::update_user_data($data);
            return redirect()->route('cabinet');
        }
    }

    public function settings_update_dentist(Request $request){
        $v = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'date_birthday' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'clinic_id' => ['required'],
            'dentist_photo' => ['required']
        ]);

        if ($v->fails()) {
            return redirect()->route('settings')
                        ->withErrors($v)
                        ->withInput();
        }
        else{
            $photo = $request->file("dentist_photo");
            if($photo)
                $photo_data = $photo->openFile()->fread($photo->getSize());
            else $photo_data = NULL;
            $data = array(
                'id' => $request->user()->id,
                'name' => $request->input("name"),
                'middlename' => $request->input("middlename"),
                'surname' => $request->input("surname"),
                'date_birthday' => $request->input("date_birthday"),
                'phone' => $request->input("phone")
            );
            $data1 = array(
                'id' => $request->user()->id,
                'clinic_id' => $request->input("clinic_id"),
                'photo' => $photo_data
            );
            MyDB::update_user_data($data);
            MyDB::update_dentist($data1);
            return redirect()->route('cabinet');
        }
    }

}
