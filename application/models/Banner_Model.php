<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insertNewAds($ad_title, $advertiser, $ad_postition, $ad_width, $ad_height, $ad_path, $ad_datetime, $ad_status) {
        $sql = "INSERT INTO ads_tb(ad_title,advertiser,ad_postition,ad_width,ad_height,ad_path,ad_datetime, ad_status) "
                . "VALUES("
                . "" . $this->db->escape($ad_title) . ", "
                . "" . $this->db->escape($advertiser) . ", "
                . "" . $this->db->escape($ad_postition) . ", "
                . "" . $this->db->escape($ad_width) . ", "
                . "" . $this->db->escape($ad_height) . ", "
                . "" . $this->db->escape($ad_path) . ", "
                . "" . $this->db->escape($ad_datetime) . ", "
                . "" . $this->db->escape($ad_status) . ")";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function bannerByStatus($status) {
        $sql = "SELECT * FROM ads_tb WHERE ad_status = " . $this->db->escape($status) . " ORDER BY id_ad DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function bannerByPosition($position) {
        $sql = "SELECT * FROM ads_tb WHERE ad_postition = " . $this->db->escape($position) . " LIMIT 1";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function bannerByStatusPosition($position,$status) {
        $sql = "SELECT * FROM ads_tb WHERE ad_status = " . $this->db->escape($status) . " AND ad_postition = " . $this->db->escape($position) . "";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function bannerList() {
        $sql = "SELECT * FROM ads_tb ORDER BY id_ad DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function bannerPagination($status, $limit, $start) {
        $sql = "SELECT * FROM ads_tb WHERE ad_status = " . $this->db->escape($status) . " LIMIT ".$start.",".$limit;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function bannerListPagination($limit, $start) {
        $sql = "SELECT * FROM ads_tb ORDER BY id_ad DESC LIMIT ".$start.",".$limit;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function updateStatusPosition($position,$status) {

        $sql = "UPDATE ads_tb SET "

        . "ad_status = " . $this->db->escape($status) . ""

        . " WHERE ad_postition = " . $this->db->escape($position) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }

    public function updateStatusId($id_ad,$status) {

        $sql = "UPDATE ads_tb SET "

        . "ad_status = " . $this->db->escape($status) . ""

        . " WHERE id_ad = " . $this->db->escape($id_ad) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }

    public function bannerById($id_ad) {
        $sql = "SELECT * FROM ads_tb WHERE id_ad = " . $this->db->escape($id_ad) . " LIMIT 1";
        $query = $this->db->query($sql);
        return $query->result();
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
    
    public function userByEmail($email) {
        $sql = "SELECT * FROM users_tb WHERE email_user = '$email'";
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
        $sql = "SELECT * FROM user_reqpass_tb WHERE code = '$code'";
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
}
