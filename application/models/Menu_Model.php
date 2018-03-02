<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insertNewMenu($menu_name, $menu_url, $menu_status) {
        $sql = "INSERT INTO menus_tb(menu_name,menu_url,menu_status) "
                . "VALUES("
                . "" . $this->db->escape($menu_name) . ", "
                . "" . $this->db->escape($menu_url) . ", "
                . "" . $this->db->escape($menu_status) . ")";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function insertNewSubMenu($id_menu, $sub_name, $sub_url, $sub_status) {
        $sql = "INSERT INTO menu_sub_tb(id_menu,sub_name,sub_url,sub_status) "
                . "VALUES("
                . "" . $this->db->escape($id_menu) . ", "
                . "" . $this->db->escape($sub_name) . ", "
                . "" . $this->db->escape($sub_url) . ", "
                . "" . $this->db->escape($sub_status) . ")";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function subMenuByIdMenu($id_menu) {
        $sql = "SELECT * FROM menu_sub_tb WHERE id_menu = " . $this->db->escape($id_menu) . "";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function menuFromArticle() {
        $sql = "SELECT id_category FROM content_tb GROUP BY id_category";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function subMenuFromArticle() {
        $sql = "SELECT id_sub FROM content_tb GROUP BY id_sub";
        $query = $this->db->query($sql);
        return $query->result();
    }


    public function updateMenu($id_menu, $menu_name, $menu_url, $menu_status) {
        $sql = "UPDATE menus_tb SET "
                . "menu_name = " . $this->db->escape($menu_name) . ","
                . "menu_url = " . $this->db->escape($menu_url) . ","
                . "menu_status = " . $this->db->escape($menu_status) . ""
                . " WHERE id_menu = " . $this->db->escape($id_menu) . "";
        $this->db->query($sql);
        return $this->db->affected_rows(); 
    }

    public function updateSubMenu($id_sub, $id_menu, $sub_name, $sub_url, $sub_status) {
        $sql = "UPDATE menu_sub_tb SET "
                . "id_menu = " . $this->db->escape($id_menu) . ","
                . "sub_name = " . $this->db->escape($sub_name) . ","
                . "sub_url = " . $this->db->escape($sub_url) . ","
                . "sub_status = " . $this->db->escape($sub_status) . ""
                . " WHERE id_sub = " . $this->db->escape($id_sub) . "";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }
    
    public function menuById($id_menu) {
        $sql = "SELECT * FROM menus_tb WHERE id_menu = " . $this->db->escape($id_menu) . "";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function subMenuById($id_sub) {
        $sql = "SELECT * FROM menu_sub_tb WHERE id_sub = " . $this->db->escape($id_sub) . "";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function menuByStatus($status) {
        $sql = "SELECT * FROM menus_tb WHERE menu_status = " . $this->db->escape($status) . "";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function subMenuByStatus($status) {
        $sql = "SELECT m.id_menu,m.menu_name,m.menu_url,s.id_sub,s.sub_name,s.sub_url FROM menu_sub_tb s LEFT JOIN menus_tb m ON m.id_menu = s.id_menu WHERE s.sub_status = " . $this->db->escape($status) . " ORDER BY s.id_sub DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function menuByUrl($url) {
        $sql = "SELECT * FROM menus_tb WHERE menu_url = " . $this->db->escape($status) . "";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function menuByIdMenuUrl($id_menu, $url) {
        $sql = "SELECT * FROM menu_sub_tb WHERE id_menu = " . $this->db->escape($id_menu) . " AND sub_url = " . $this->db->escape($url) . "";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function subMenuCount() {
        $sql = "SELECT s.sub_name AS subname,m.menu_url AS menuurl,s.sub_url AS suburl,COUNT(c.id_sub) AS countarticle 
            FROM menu_sub_tb s 
            LEFT JOIN menus_tb m ON s.id_menu = m.id_menu
            LEFT JOIN content_tb c ON s.id_sub = c.id_sub 
            GROUP BY c.id_sub ORDER BY countarticle DESC LIMIT 10";
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
