<?php

namespace App\DB;

use Illuminate\Support\Facades\DB;
use DateTime;

class MyDB
{
    public static function select_users(){
        $users = DB::select("SELECT name, phone, surname, id FROM users LEFT JOIN dentist ON dentist.dentist_id=users.id WHERE dentist.dentist_id IS NULL");
        return $users;
    }

    public static function select_all_users(){
        $users = DB::select("SELECT name, phone, surname, id FROM users;");
        return $users;
    }

    public static function select_clinics(){
        $clinics = DB::select("SELECT * FROM clinic");
        return $clinics;
    }

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

   public static function get_person_data($user_id){
    $data = DB::select("SELECT id, name, middlename, surname, date_birthday, phone, email FROM users INNER JOIN person ON users.id=person.person_id WHERE id=?;",
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

   public static function select_dentist_info_($dentist_id){
    $info = DB::select("SELECT u.id, u.name, u.middlename, u.surname, u.date_birthday, u.phone, d.photo, d.clinic_id  FROM users as u INNER JOIN dentist as d ON d.dentist_id=u.id WHERE u.id=?;", [$dentist_id]);
    if(count($info)>0){
        $info = $info[0];
    }else{
       $info = NULL;
    }
    return $info;
   }

   public static function select_not_clinic_dentist(){
       return DB::select("SELECT u.id, u.name, u.middlename, u.surname, u.date_birthday, u.phone, d.photo  FROM users as u INNER JOIN dentist as d ON d.dentist_id=u.id WHERE d.clinic_id IS NULL;");
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
        $info = DB::select("SELECT r.id, r.date_record, r.date_first,  c.address, u.name, u.surname, u.middlename, d.photo  FROM record as r INNER JOIN dentist as d ON d.dentist_id=r.dentist_id INNER JOIN clinic as c ON c.id=d.clinic_id INNER JOIN users as u ON u.id=r.dentist_id WHERE r.active=1 AND r.person_id=? AND r.date_record > NOW() ORDER BY r.date_record;",
            [$person_id]);
        return $info;
    }
    public static function select_records_for_dentist($dentist_id){
        $info = DB::select("SELECT r.id, r.date_record, r.date_first, u.name, u.surname, u.middlename, u.email, u.phone  FROM record as r INNER JOIN users as u ON u.id=r.dentist_id WHERE r.dentist_id=?;",
            [$dentist_id]);
        return $info;
    }

    public static function select_records_today($dentist_id){
        return DB::select("SELECT r.id, r.date_record, r.date_first, u.name, u.surname, u.middlename, u.email, u.phone  FROM record as r INNER JOIN users as u ON u.id=r.person_id WHERE r.active=1 AND r.dentist_id=?  AND DATE(r.date_record)=DATE(NOW()) AND r.date_record > NOW() ORDER BY r.date_record;", [$dentist_id]);
    }

    public static function select_records_tomorrow($dentist_id){
        return DB::select("SELECT r.id, r.date_record, r.date_first, u.name, u.surname, u.middlename, u.email, u.phone  FROM record as r INNER JOIN users as u ON u.id=r.person_id WHERE r.active=1 AND r.dentist_id=? AND DATE(r.date_record)=DATE(NOW() + INTERVAL 1 DAY) AND r.date_record > NOW() ORDER BY r.date_record;", [$dentist_id]);
    }

    public static function select_records_another($dentist_id){
        return DB::select("SELECT r.id, r.date_record, r.date_first, u.name, u.surname, u.middlename, u.email, u.phone  FROM record as r INNER JOIN users as u ON u.id=r.person_id WHERE r.active=1 AND r.dentist_id=? AND DATE(r.date_record) > DATE(NOW() + INTERVAL 1 DAY) AND r.date_record > NOW() ORDER BY r.date_record;", [$dentist_id]);
    }

    public static function select_record_info($record_id){
        $info = DB::select("SELECT r.id, r.person_id, r.date_record, r.date_first, c.title, c.address, u.name, u.surname, u.middlename, d.photo, d.dentist_id  FROM record as r INNER JOIN dentist as d ON d.dentist_id=r.dentist_id INNER JOIN clinic as c ON c.id=d.clinic_id INNER JOIN users as u ON u.id=r.dentist_id WHERE r.id=?;",
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

    public static function select_record_id($person_id, $dentist_id, $date){
        $record_id = DB::select("SELECT id FROM record WHERE person_id=? AND dentist_id=? AND date_record=? ORDER BY id;", [$person_id, $dentist_id, $date]);
        if(count($record_id)>0) {
            $record_id = $record_id[0]->id; 
        }
        return $record_id;
    }

    public static function select_all_clinics(){
        return DB::select("select * from clinic");
    }

    public static function select_clinic($id){
        $clinic =  DB::select("select * from clinic where id=?",[$id]);
        if(count($clinic) > 0){
            $clinic = $clinic[0];
        }else{
            $clinic = null;
        }
        return $clinic;
    }

    public static function select_dentists($clinic_id){
        return DB::select('select u.id, u.name, u.middlename, u.surname, u.email, u.phone, d.* from dentist as d inner join users as u on u.id=d.dentist_id where d.clinic_id=?', [$clinic_id]);
    }

    public static function select_clinics_search($search){
        return DB::select("select * from clinic where clinic.title LIKE '%".$search."%'");
    }

    public static function select_clinics_filter_counts(){
        return DB::select("select c.*, sum(d.dentist_id) as summ from clinic as c left join dentist as d on d.clinic_id=c.id group by c.id order by summ DESC;");
    }

    public static function select_contacts(){
        return DB::select("select * from contacts where answered=0");
    }


    public static function select_feedbacks(){
        return DB::select("SELECT * FROM feedbacks ORDER BY publish");
    }

    public static function select_publish_feedbacks(){
        return DB::select("SELECT f.*, u.name as user_name FROM feedbacks as f INNER JOIN users as u ON u.id=f.user_id WHERE publish=1");
    }    

    public static function update_feedback($id, $publish){
        DB::update("UPDATE feedbacks SET publish=? WHERE id=?", [$publish, $id]);
    }

   public static function update_user_data($array){
        DB::update("UPDATE users SET name=?, middlename=?, surname=?, date_birthday=?, phone=? WHERE id=?;",
            [$array['name'], $array['middlename'], $array['surname'], $array['date_birthday'], $array['phone'], $array['id']]);
   }

   public static function update_dentist($array){
        DB::update("UPDATE dentist SET photo=? WHERE dentist_id=?;",
            [$array['photo'], $array['id']]);
    }

    public static function update_record($id, $new_date){
        DB::update("UPDATE record SET date_record=? WHERE id=?", [$new_date, $id]);
    }


   public static function insert_clinic($array){
        DB::insert("INSERT INTO clinic(title, address, description) VALUES(?, ?, ?);",
            [$array['title'], $array['address'], $array['description']]);
   }

   public static function insert_dentist($clinic_id){
        DB::insert("INSERT INTO dentist(dentist_id) VALUES(?);",
            [$clinic_id]);
   }

   public static function insert_dentist_($data){
    DB::update("UPDATE dentist SET  clinic_id=? WHERE dentist_id=?;",
        [$data["clinic_id"], $data["dentist_id"]]);
    }

   public static function insert_person($person_id){
        DB::insert("INSERT INTO person(person_id) VALUES(?);",
            [$person_id]);
    }

    public static function insert_record($array){
        DB::insert("INSERT INTO record(person_id, dentist_id, date_record, active, date_first) VALUES(?, ?, ?, ?, ?);",
            [$array['person_id'], $array['dentist_id'], $array['date_record'], $array['active'], new DateTime()]);
    }

    public static function insert_chat($id_record){
        DB::insert("INSERT INTO chat(id_record) VALUES(?);",
            [$id_record]);
    }

    public static function insert_contacts($name, $phone, $message){
        DB::insert("INSERT INTO contacts(user_name, user_phone, message, created_at, answered) VALUES(?, ?,?,?, 0)",
        [$name, $phone, $message, new DateTime()]);
    }

    public static function insert_message($array){
        DB::insert("INSERT INTO message(chat_id, user_id, message_text, date_create) VALUES(?, ?, ?, ?);",
                [$array['chat_id'], $array['user_id'], $array['message_text'], $array['date_create']]);
    }

    public static function insert_feedback($user_id, $message, $created_at){
        DB::insert("INSERT INTO feedbacks(user_id, message, created_at, publish) VALUES(?, ?, ?, ?)",
        [$user_id, $message, $created_at, 0]);
    }

    public static function delete_user($user_id){
        DB::delete("DELETE FROM users WHERE id=?;", [$user_id]);
    }

    public static function delete_record($record_id){
        DB::update("UPDATE record SET active=0 WHERE id=?", [$record_id]);
    }


    public static function update_clinic($id, $title, $address, $description){
        DB::update("UPDATE clinic SET title=?, address=?, description=? WHERE id=?", [$title, $address, $description, $id]);
    }

    public static function update_contact($id){
        DB::update("UPDATE contacts SET answered=1 WHERE id=?", [$id]);
    }
}
