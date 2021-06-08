<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DB\MyDB;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Acaronlex\LaravelCalendar\Calendar;

class UserController extends Controller
{
    public function dentist_record(Request $request, $dentist_id){
        $dentist_info = MyDB::select_dentist_info($dentist_id);
        $events = [];
        $all_event_for_dentist = MyDB::select_records_alll($dentist_id);
        foreach($all_event_for_dentist as $a){
            $events[] = Calendar::event(
                '',
                false, 
                $a->date_record,
                $a->date_record, 
                $a->id,
                [
                    'record_id' => 'http://full-calendar.io',
                    'backgroundColor' => '#ED1317',
                ]
            );
        }
        
        $calendar = new Calendar();
        if(count($events) > 0)
                $calendar->addEvents($events);

                $calendar->setOptions([
                    'locale' => 'uk',
                    'firstDay' => 1,
                    'displayEventTime' => false,
                    'allDaySlot' => false,
                    'slotDuration' => '00:60:00',
                    'height' => 'auto',
                    'initialView' => 'timeGridWeek',
                    'slotMinTime' => '08:00:00',
                    'slotMaxTime' => '21:00:00',
                    'themeSystem' => 'standard',
                    
                ]);
                $calendar->setId('1');
                $calendar->setCallbacks([
                    'dateClick' => 'function(info){ 
                        var myDate = new Date(info.dateStr);
                        if(myDate.getDay() == 6 || myDate.getDay() == 0) alert("Вихідний!");
                        else{
                        document.getElementById("date_record").setAttribute("value", moment(new Date(info.dateStr)).format("DD.MM.YYYY")); 
                        document.getElementById("time_record").setAttribute("value", moment(new Date(info.dateStr)).format("HH:mm")); 
                        document.getElementById("record_modal").click() 
                        }
                    }'
                ]);

        return view('user.dentist', ['dentist' => $dentist_info, 'calendar' => $calendar]);
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
            MyDB::insert_chat(MyDB::select_record_id($request->input("person_id"), $request->input("dentist_id"), $date_record));
            return redirect()->route('cabinet');
        }
    }
    
    public function cabinet(Request $request){
        $user_id = $request->user()->id;
        $records_dentist = MyDB::select_records_for_dentist($user_id);
        $records_info = MyDB::select_records_info($user_id);
        $person_id = MyDB::select_person_id($user_id);

        $today = MyDB::select_records_today($user_id);
        $tomorrow = MyDB::select_records_tomorrow($user_id);
        $another = MyDB::select_records_another($user_id);
        $events = [];

        $alll = MyDB::select_records_alll($user_id);
        foreach($alll as $a){
            $events[] = Calendar::event(
                $a->name.' '.$a->middlename.' '.$a->surname,
                false, 
                $a->date_record,
                $a->date_record, 
                $a->id,
                [
                    'record_id' => 'http://full-calendar.io',
                ]
            );
        }
        
        $calendar = new Calendar();
                $calendar->addEvents($events)
                ->setOptions([
                    'locale' => 'uk',
                    'firstDay' => 1,
                    'displayEventTime' => false,
                    'selectable' => true,
                    'initialView' => 'dayGridMonth',
                    'themeSystem' => 'standard',
                    'headerToolbar' => [
                        'end' => 'dayGridMonth timeGridWeek'
                    ]
                ]);
                $calendar->setId('1');
                $calendar->setCallbacks([
                    'select' => 'function(selectionInfo){}',
                    'eventClick' => 'function(info){ window.location.href = "cabinet/record/" + info.event.id; }'
                ]);


        return  view('user.cabinet', ['records' => $records_info, 'calendar' => $calendar, 'person' => $person_id, 'today' => $today, 'tomorrow' => $tomorrow, 'another' => $another]);
    }

    public function cabinet_feedback(Request $request){
        $user_id = $request->user()->id;
        $message = $request->input('message');
        MyDB::insert_feedback($user_id, $message, new DateTime());

        return redirect()->route('cabinet');
    }

    public function record_info(Request $request, $id){
        $user_id = $request->user()->id;
        $record_data = MyDB::select_record_info($id);
        $person_info = MyDB::get_person_data($record_data->person_id);
        if($record_data->person_id==$user_id) $person_info = NULL;
        //else $person_info = MyDB::get_user_data($user_id);
        $messages = MyDB::select_messages($id);
        //dd($person_info);
        return  view('user.record', ['record' => $record_data, 'person_info' => $person_info, 'messages' => $messages]);
    }

    public function record_new_date(Request $request, $id){
        $date_record = new DateTime(($request->input("date_record")));
        $date_record->setTime(intval($request->input("time_record")), 00);

        MyDB::update_record($id, $date_record);

        return redirect()->route('record_info', $id);
    }

    public function record_delete(Request $req, $id){
        $record_id = $req->input('record_id');
        MyDB::delete_record($record_id);
        return redirect()->route('cabinet');
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
        $dentist = MyDB::select_dentist_info_($user_id);
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
                'photo' => $photo_data
            );
            MyDB::update_user_data($data);
            MyDB::update_dentist($data1);
            return redirect()->route('cabinet');
        }
    }

}
