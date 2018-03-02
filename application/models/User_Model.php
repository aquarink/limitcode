<?php



if (!defined('BASEPATH')) exit('No direct script access allowed');



class User_Model extends CI_Model {



    function __construct() {

        parent::__construct();

        $this->load->database();

    }



    public function insertNewUser($email_user, $password_user, $name_user, $bhirtday_user, $gender_user, $photo_user, $auth_by, $register_date, $verify, $user_status) {

        $sql = "INSERT INTO users_tb(email_user,password_user,name_user,bhirtday_user,gender_user,photo_user, auth_by,register_date,verify,user_status) "

                . "VALUES("

                . "" . $this->db->escape($email_user) . ", "

                . "" . $this->db->escape($password_user) . ", "

                . "" . $this->db->escape($name_user) . ", "

                . "" . $this->db->escape($bhirtday_user) . ", "

                . "" . $this->db->escape($gender_user) . ", "

                . "" . $this->db->escape($photo_user) . ", "

                . "" . $this->db->escape($auth_by) . ", "

                . "" . $this->db->escape($register_date) . ", "

                . "" . $this->db->escape($verify) . ", "

                . "" . $this->db->escape($user_status) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function insertVisitor($ip_visitor, $browser_info, $datetime_visit) {

        $sql = "INSERT INTO visitor_tb(ip_visitor,browser_info,datetime_visit) "

                . "VALUES("

                . "" . $this->db->escape($ip_visitor) . ", "

                . "" . $this->db->escape($browser_info) . ", "

                . "" . $this->db->escape($datetime_visit) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function insertLogin($id_user, $ip_user, $browser_info, $datetime_login) {

        $sql = "INSERT INTO login_log_tb(id_user,ip_user,browser_info,datetime_login) "

                . "VALUES("

                . "" . $this->db->escape($id_user) . ", "

                . "" . $this->db->escape($ip_user) . ", "

                . "" . $this->db->escape($browser_info) . ", "

                . "" . $this->db->escape($datetime_login) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function insertAvatar($id_user, $avatar_path, $avatar_datetime) {

        $sql = "INSERT INTO avatar_tb(id_user,avatar_path,avatar_datetime) "

                . "VALUES("

                . "" . $this->db->escape($id_user) . ", "

                . "" . $this->db->escape($avatar_path) . ", "

                . "" . $this->db->escape($avatar_datetime) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function avatarById($id) {

        $sql = "SELECT avatar_path FROM avatar_tb WHERE id_user = " . $this->db->escape($id) . " ORDER BY id_avatar DESC LIMIT 1";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function insertNotif($id_user,$kind_notif, $url_notif, $status_notif, $datetime_notif) {

        $sql = "INSERT INTO notif_tb(id_user,kind_notif,url_notif,status_notif,datetime_notif) "

                . "VALUES("

                . "" . $this->db->escape($id_user) . ", "

                . "" . $this->db->escape($kind_notif) . ", "

                . "" . $this->db->escape($url_notif) . ", "

                . "" . $this->db->escape($status_notif) . ", "

                . "" . $this->db->escape($datetime_notif) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function updateStatusNotif($id_notif) {

        $sql = "UPDATE notif_tb SET "

                . "status_notif = 1"

                . " WHERE id_notif = " . $this->db->escape($id_notif) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function notifById($id) {

        $sql = "SELECT * FROM notif_tb WHERE id_user = " . $this->db->escape($id) . " ORDER BY id_notif DESC LIMIT 20";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function lastLoginById($id) {

        $sql = "SELECT * FROM login_log_tb WHERE id_user = " . $this->db->escape($id) . " ORDER BY id_log DESC LIMIT 1";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function updateVerifyUser($verify, $email_user) {

        $sql = "UPDATE users_tb SET "

                . "verify = " . $this->db->escape($verify) . ""

                . " WHERE email_user = " . $this->db->escape($email_user) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function updatePassUser($email_user, $password_user) {

        $sql = "UPDATE users_tb SET "

                . "password_user = " . $this->db->escape($password_user) . ""

                . " WHERE email_user = " . $this->db->escape($email_user) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function updateNameUser($email_user, $name_user) {

        $sql = "UPDATE users_tb SET "

                . "name_user = " . $this->db->escape($name_user) . ""

                . " WHERE email_user = " . $this->db->escape($email_user) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function updateNamePhotoUser($email_user, $name_user, $photo) {

        $sql = "UPDATE users_tb SET "

                . "name_user = " . $this->db->escape($name_user) . ","

                . "photo_user = " . $this->db->escape($photo) . ""

                . " WHERE email_user = " . $this->db->escape($email_user) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }

    public function updateKtp($email_user, $ktp) {

        $sql = "UPDATE users_tb SET "

                . "identity_card = " . $this->db->escape($ktp) . ""

                . " WHERE email_user = " . $this->db->escape($email_user) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }

    public function updateVerifiedAccount($id_user, $verify) {

        $sql = "UPDATE users_tb SET verify = " . $this->db->escape($verify) . " WHERE id_user = " . $this->db->escape($id_user) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }

    

    public function userByEmail($email) { 

        $sql = "SELECT * FROM users_tb WHERE email_user = " . $this->db->escape($email) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }

    public function userByID($id) { 

        $sql = "SELECT * FROM users_tb WHERE id_user = " . $this->db->escape($id) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function userLogin($email,$pass) {

        $sql = "SELECT * FROM users_tb WHERE email_user = " . $this->db->escape($email) . " AND password_user = " . $this->db->escape($pass) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function insertReqPass($email_user, $code, $request_date,$end_date,$req_verify) {

        $sql = "INSERT INTO user_reqpass_tb(email_user,code,request_date,end_date,req_verify) "

                . "VALUES("

                . "" . $this->db->escape($email_user) . ", "

                . "" . $this->db->escape($code) . ", "

                . "" . $this->db->escape($request_date) . ", "

                . "" . $this->db->escape($end_date) . ", "

                . "" . $this->db->escape($req_verify) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function updateReqPass($email_user, $code, $req_verify, $req_verify_date) {

        $sql = "UPDATE user_reqpass_tb SET "

                . "req_verify = " . $this->db->escape($req_verify) . ","

                . "req_verify_date = " . $this->db->escape($req_verify_date) . ""

                . " WHERE email_user = " . $this->db->escape($email_user) . " AND "

                . "code = " . $this->db->escape($code) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function reqpassByCode($code) {

        $sql = "SELECT * FROM user_reqpass_tb WHERE code = " . $this->db->escape($code) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function insertVerify($email_user, $verify_code, $register_date, $valid_date) {

        $sql = "INSERT INTO user_verify_tb(email_user,verify_code,register_date,valid_date) "

                . "VALUES("

                . "" . $this->db->escape($email_user) . ", "

                . "" . $this->db->escape($verify_code) . ", "

                . "" . $this->db->escape($register_date) . ", "

                . "" . $this->db->escape($valid_date) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function updateVerifyTable($id, $verify_date) {

        $sql = "UPDATE user_verify_tb SET "

                . "verify_date = " . $this->db->escape($verify_date) . ""

                . " WHERE id_verify = " . $this->db->escape($id) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function verifyByCode($code) {

        $sql = "SELECT * FROM user_verify_tb WHERE verify_code = '$code'";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function verifyById($id) {

        $sql = "SELECT * FROM user_verify_tb WHERE id_verify = '$id'";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function userDataByStatus($stat = array()) {

        $userstatus = join(',',$stat);

        $sql = "SELECT * FROM users_tb WHERE user_status IN($userstatus) ORDER BY register_date DESC";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function userDataPagination($stat = array(), $limit, $start) {

        $userstatus = join(',',$stat);

        $sql = "SELECT * FROM users_tb WHERE user_status IN($userstatus) ORDER BY register_date DESC LIMIT ".$start.",".$limit;

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function insertShortUrl($code, $short, $long) {

        $sql = "INSERT INTO short_url_tb(url_code,url_short,url_long,short_datetime) "

                . "VALUES("

                . "" . $this->db->escape($code) . ", "

                . "" . $this->db->escape($short) . ", "

                . "" . $this->db->escape($long) . ", "

                . "" . $this->db->escape(date('Y-m-d H:i:s')) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function shortUrlByCode($code) {

        $sql = "SELECT * FROM short_url_tb WHERE url_code = " . $this->db->escape($code) . " LIMIT 1";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function shortUrlByLongUrl($long) {

        $sql = "SELECT * FROM short_url_tb WHERE url_long = " . $this->db->escape($long) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function shortUrlByShortUrl($short) {

        $sql = "SELECT * FROM short_url_tb WHERE url_short = " . $this->db->escape($short) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function insertAnalyticShortUrl($id_short, $url_code, $ip_client, $browser_client, $type_client) {

        $sql = "INSERT INTO short_url_analytics_tb(id_short,url_code,ip_client,browser_client,type_client,analytic_datetime) "

                . "VALUES("

                . "" . $this->db->escape($id_short) . ", "

                . "" . $this->db->escape($url_code) . ", "

                . "" . $this->db->escape($ip_client) . ", "

                . "" . $this->db->escape($browser_client) . ", "

                . "" . $this->db->escape($type_client) . ", "

                . "" . $this->db->escape(date('Y-m-d H:i:s')) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }

}

