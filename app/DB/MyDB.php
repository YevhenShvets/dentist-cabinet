<?php

namespace App\DB;

use Illuminate\Support\Facades\DB;

class MyDB
{

    public static function select_person_id($user_id){
        $id = DB::select("SELECT person_id FROM person WHERE person_id=?;", [$user_id]);
        if($id){
            return $id[0]->person_id;
        }else{
            return NULL;
        }
    }
    
   public static function get_user_data($user_id){
        $data = DB::select("SELECT id, name, middlename, surname, date_birthday, phone, email FROM users WHERE id=?;",
            [$user_id]);

        if(count($data)>0){
            $user = $data[0];
        }else{
           $user = NULL;
        }
        return $user;
   }

   public static function get_user_id($email, $phone){
       $id = DB::select("SELECT id FROM users WHERE email=? AND phone=?", [$email, $phone]);
        if(count($id)>0){
            $id = $id[0]->id;
        }else{
        $id = NULL;
        }
        return $id;
   }

   public static function select_dentist_info($dentist_id){
        $info = DB::select("SELECT u.id, u.name, u.middlename, u.surname, u.date_birthday, u.phone, d.photo, d.clinic_id, c.title, c.address  FROM users as u INNER JOIN dentist as d ON d.dentist_id=u.id INNER JOIN clinic as c ON c.id=d.clinic_id WHERE u.id=?;", [$dentist_id]);
        if(count($info)>0){
            $info = $info[0];
        }else{
           $info = NULL;
        }
        return $info;
   }

   public static function select_dentist_users_info(){
        $info = DB::select("SELECT u.id, u.name, u.middlename, u.surname, d.photo, c.title, c.address  FROM users as u INNER JOIN dentist as d ON d.dentist_id=u.id INNER JOIN clinic as c ON c.id=d.clinic_id;");
        return $info;
   }

    public static function select_records_info($person_id){
        $info = DB::select("SELECT r.id, r.date_record,  c.address, u.name, u.surname, u.middlename, d.photo  FROM record as r INNER JOIN dentist as d ON d.dentist_id=r.dentist_id INNER JOIN clinic as c ON c.id=d.clinic_id INNER JOIN users as u ON u.id=r.dentist_id WHERE r.person_id=?;",
            [$person_id]);
        return $info;
    }
    public static function select_records_for_dentist($dentist_id){
        $info = DB::select("SELECT r.id, r.date_record, u.name, u.surname, u.middlename, u.email, u.phone  FROM record as r INNER JOIN users as u ON u.id=r.dentist_id WHERE r.dentist_id=?;",
            [$dentist_id]);
        return $info;
    }

    public static function select_record_info($record_id){
        $info = DB::select("SELECT r.id, r.person_id, r.date_record, c.title, c.address, u.name, u.surname, u.middlename, d.photo, d.dentist_id  FROM record as r INNER JOIN dentist as d ON d.dentist_id=r.dentist_id INNER JOIN clinic as c ON c.id=d.clinic_id INNER JOIN users as u ON u.id=r.dentist_id WHERE r.id=?;",
            [$record_id]);
        if(count($info)>0){
            $info = $info[0];
        }else{
            $info = NULL;
        }
        return $info;
    }

    public static function select_chat_id($record_id){
        $chat_id = DB::select("SELECT id FROM chat WHERE id_record=?;", [$record_id]);
        if(count($chat_id)>0) {
            $chat_id = $chat_id[0]->id; 
        }else $chat_id = NULL;
        return $chat_id;
    }

    public static function select_messages($record_id){
        $chat_id = DB::select("SELECT id FROM chat WHERE id_record=?;", [$record_id]);
        if(count($chat_id)>0) {
            $chat_id = $chat_id[0]->id; 
            $messages = DB::select("SELECT m.message_text, m.date_create, u.name, u.surname, u.middlename FROM message as m INNER JOIN users as u ON u.id=m.user_id WHERE m.chat_id=? ORDER BY m.id;", [intval($chat_id)]);
            return $messages;
        }
        else return NULL;
    }

    public static function select_record_id($person_id, $dentist_id){
        $record_id = DB::select("SELECT id FROM record WHERE person_id=? AND dentist_id=? ORDER BY id;", [$person_id, $dentist_id]);
        if(count($record_id)>0) {
            $record_id = $record_id[0]->id; 
        }
        return $record_id;
    }

   public static function update_user_data($array){
        DB::update("UPDATE users SET name=?, middlename=?, surname=?, date_birthday=?, phone=? WHERE id=?;",
            [$array['name'], $array['middlename'], $array['surname'], $array['date_birthday'], $array['phone'], $array['id']]);
   }

   public static function update_dentist($array){
        DB::update("UPDATE dentist SET clinic_id=?, photo=? WHERE dentist_id=?;",
            [$array['clinic_id'], $array['photo'], $array['id']]);
}


   public static function insert_clinic($array){
        DB::insert("INSERT INTO clinic(title, address, description) VALUES(?, ?, ?);",
            [$array['title'], $array['address'], $array['description']]);
   }

   public static function insert_dentist($clinic_id){
        DB::insert("INSERT INTO dentist(dentist_id, clinic_id) VALUES(?, 1);",
            [$clinic_id]);
   }

   public static function insert_person($person_id){
        DB::insert("INSERT INTO person(person_id) VALUES(?);",
            [$person_id]);
    }

    public static function insert_record($array){
        DB::insert("INSERT INTO record(person_id, dentist_id, date_record, active) VALUES(?, ?, ?, ?);",
            [$array['person_id'], $array['dentist_id'], $array['date_record'], $array['active']]);
    }

    public static function insert_chat($id_record){
        DB::insert("INSERT INTO chat(id_record) VALUES(?);",
            [$id_record]);
    }

    public static function insert_message($array){
        DB::insert("INSERT INTO message(chat_id, user_id, message_text, date_create) VALUES(?, ?, ?, ?);",
                [$array['chat_id'], $array['user_id'], $array['message_text'], $array['date_create']]);
        }
}
