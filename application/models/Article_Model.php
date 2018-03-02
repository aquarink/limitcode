<?php



if (!defined('BASEPATH')) exit('No direct script access allowed'); 



class Article_Model extends CI_Model {



    function __construct() {

        parent::__construct();

        $this->load->database();

    }



    public function insertNewArticle($id_user, $id_category, $id_sub, $kind, $title, $content_describ, $content_video, $content_thumbnail, $content_link, $content_datetime, $edited_status, $content_status) {

        $sql = "INSERT INTO content_tb(id_user,id_category,id_sub,kind,title,content_describ,content_video, content_thumbnail,content_link,content_datetime,edited_status,content_status) "

        . "VALUES("

        . "" . $this->db->escape($id_user) . ", "

        . "" . $this->db->escape($id_category) . ", "

        . "" . $this->db->escape($id_sub) . ", "

        . "" . $this->db->escape($kind) . ", "

        . "" . $this->db->escape($title) . ", "

        . "" . $this->db->escape($content_describ) . ", "

        . "" . $this->db->escape($content_video) . ", "

        . "" . $this->db->escape($content_thumbnail) . ", "

        . "" . $this->db->escape($content_link) . ", "

        . "" . $this->db->escape($content_datetime) . ", "

        . "" . $this->db->escape($edited_status) . ", "

        . "" . $this->db->escape($content_status) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function insertTags($content_link, $the_tags, $tag_datetime) {

        $sql = "INSERT INTO tags_tb(content_link,the_tags,tag_datetime) "

        . "VALUES("

        . "" . $this->db->escape($content_link) . ", "

        . "" . $this->db->escape($the_tags) . ", "

        . "" . $this->db->escape($tag_datetime) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }

    public function updateTag($tags, $url) {
        $sql = "UPDATE tags_tb SET the_tags = " . $this->db->escape($tags) . ", tag_datetime = " . date('Y-m-d H:i:s') . " WHERE content_link = " . $this->db->escape($url) . "";
        $this->db->query($sql);
        return $this->db->affected_rows();

    }

    public function getTagByContentLink($content_link) {

        $sql = "SELECT the_tags FROM tags_tb WHERE content_link = " . $this->db->escape($content_link) . " LIMIT 1";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function insertView($id_content, $ip_client, $watch_datetime) {

        $sql = "INSERT INTO watch_content_tb(id_content,ip_client,watch_datetime) "

        . "VALUES("

        . "" . $this->db->escape($id_content) . ", "

        . "" . $this->db->escape($ip_client) . ", "

        . "" . $this->db->escape($watch_datetime) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function insertBounce($random_page_id, $id_content, $ip_client,$id_user, $bounce_datetime, $bounce_sc) {

        $sql = "INSERT INTO bounce_tb(random_page_id,id_content,ip_client,id_user,bounce_datetime,bounce_sc) "

        . "VALUES("

        . "" . $this->db->escape($random_page_id) . ", "

        . "" . $this->db->escape($id_content) . ", "

        . "" . $this->db->escape($ip_client) . ", "

        . "" . $this->db->escape($id_user) . ", "

        . "" . $this->db->escape($bounce_datetime) . ", "

        . "" . $this->db->escape($bounce_sc) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function updateBounce($random_page_id, $id_content, $ip_client, $bounce) {

        $sql = "UPDATE bounce_tb SET "

        . "bounce_sc = " . $this->db->escape($bounce) . ""

        . " WHERE random_page_id = " . $this->db->escape($random_page_id) . " AND id_content = " . $this->db->escape($id_content) . " AND ip_client = " . $this->db->escape($ip_client) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function getBounceBy($random_page_id, $id_content, $ip_client) {

        $sql = "SELECT bounce_sc FROM bounce_tb WHERE random_page_id = " . $this->db->escape($random_page_id) . " AND id_content = " . $this->db->escape($id_content) . " AND ip_client = " . $this->db->escape($ip_client) . " LIMIT 1";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function updateArticle($id_content, $id_user, $id_category, $id_sub, $kind, $title, $content_describ, $content_video, $content_thumbnail, $content_link, $content_datetime, $edited_status, $content_status) {

        $sql = "UPDATE content_tb SET id_user = " . $this->db->escape($id_user) . ",id_category = " . $this->db->escape($id_category) . ",id_sub = " . $this->db->escape($id_sub) . ",kind = " . $this->db->escape($kind) . ",title = " . $this->db->escape($title) . ",content_describ = " . $this->db->escape($content_describ) . ",content_video = " . $this->db->escape($content_video) . ", content_thumbnail = " . $this->db->escape($content_thumbnail) . ",content_link = " . $this->db->escape($content_link) . ",content_datetime = " . $this->db->escape($content_datetime) . ",edited_status = " . $this->db->escape($edited_status) . ",content_status = " . $this->db->escape($content_status) . " WHERE id_content = " . $this->db->escape($id_content) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }

    public function updateVideo($id_content, $id_user, $id_category, $id_sub, $kind, $title, $content_describ, $content_thumbnail, $content_link, $content_datetime, $edited_status, $content_status) {

        $sql = "UPDATE content_tb SET id_user = " . $this->db->escape($id_user) . ",id_category = " . $this->db->escape($id_category) . ",id_sub = " . $this->db->escape($id_sub) . ",kind = " . $this->db->escape($kind) . ",title = " . $this->db->escape($title) . ",content_describ = " . $this->db->escape($content_describ) . ", content_thumbnail = " . $this->db->escape($content_thumbnail) . ",content_link = " . $this->db->escape($content_link) . ",content_datetime = " . $this->db->escape($content_datetime) . ",edited_status = " . $this->db->escape($edited_status) . ",content_status = " . $this->db->escape($content_status) . " WHERE id_content = " . $this->db->escape($id_content) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function insertComment($id_content, $id_user, $comment, $ip_client, $comment_datetime) {

        $sql = "INSERT INTO comment_content_tb(id_content,id_user,comment,ip_client,comment_datetime) "

        . "VALUES("

        . "" . $this->db->escape($id_content) . ", "

        . "" . $this->db->escape($id_user) . ", "

        . "" . $this->db->escape($comment) . ", "

        . "" . $this->db->escape($ip_client) . ", "

        . "" . $this->db->escape($comment_datetime) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function articleByIdUserKind($id,$kind) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.id_user = " . $this->db->escape($id) . " AND c.kind = " . $this->db->escape($kind) . " GROUP BY c.id_content,w.id_content";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByIdUserKindPagination($id,$kind,$limit,$start) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.id_user = " . $this->db->escape($id) . " AND c.kind = " . $this->db->escape($kind) . " GROUP BY c.id_content,w.id_content ORDER BY c.id_content DESC LIMIT ".$start.",".$limit;

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleCommentByIdUserKind($id_user,$id_content) {

        $sql = "SELECT COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.id_user = " . $this->db->escape($id_user) . " AND cm.id_content = " . $this->db->escape($id_content) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByStatus($status) { 

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content ORDER BY c.id_content DESC";

        $query = $this->db->query($sql);

        return $query->result();
 
    }

    public function articleByTagsREGEXP($tagsLike) { 

        $sql ="SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link
            FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 
            LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 
            LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 
            LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content
            LEFT JOIN menus_tb m ON m.id_menu = c.id_category 
            LEFT JOIN tags_tb t ON t.content_link = c.content_link
            WHERE t.the_tags REGEXP " . $this->db->escape($tagsLike) . "
            GROUP BY c.id_content,t.the_tags ORDER BY c.content_datetime DESC LIMIT 10";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByStatusLimit($status,$limit) { 

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content ORDER BY c.id_content DESC LIMIT $limit";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByWatchStatusLimit($status,$limit) { 

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content ORDER BY COUNT(w.id_watch) DESC LIMIT $limit";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articlePagination($status,$limit,$start) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content LIMIT ".$start.",".$limit;

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function commentById($id_content) {

        $sql = "SELECT u.name_user AS nameuser, c.comment_datetime AS timedate, c.comment AS comm, u.photo_user AS photo FROM comment_content_tb c

        LEFT JOIN users_tb u ON c.id_user = u.id_user WHERE id_content = " . $this->db->escape($id_content) . " ORDER BY c.comment_datetime DESC LIMIT 5";

        $query = $this->db->query($sql);

        return $query->result(); 

    }



    public function articleByIdUser($id,$status) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link, u.register_date AS uRegDate, u.photo_user AS photo

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.id_user = " . $this->db->escape($id) . " AND c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByIdUserPagination($iduser,$status,$limit,$start) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.id_user = " . $this->db->escape($iduser) . " AND c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content LIMIT ".$start.",".$limit;

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByTags($tag,$status) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link, u.register_date AS uRegDate

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE t.the_tags LIKE '%$tag%' AND c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content";

        $query = $this->db->query($sql);

        return $query->result();

    }

    public function articleByTagPagination($tag,$status,$limit,$start) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE t.the_tags LIKE '%$tag%' AND c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content LIMIT ".$start.",".$limit;

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByMenu($menu,$status) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE m.menu_url = " . $this->db->escape($menu) . " AND c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByMenuPagination($menu,$status,$limit,$start) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE m.menu_url = " . $this->db->escape($menu) . " AND c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content LIMIT ".$start.",".$limit;

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByMenuSub($menu,$sub,$status) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE m.menu_url = " . $this->db->escape($menu) . " AND c.content_status = " . $this->db->escape($status) . " AND s.sub_url = " . $this->db->escape($sub) . " GROUP BY c.id_content,w.id_content";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByMenuSubPagination($menu,$sub,$status,$limit,$start) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE m.menu_url = " . $this->db->escape($menu) . " AND c.content_status = " . $this->db->escape($status) . " AND s.sub_url = " . $this->db->escape($sub) . " GROUP BY c.id_content,w.id_content LIMIT ".$start.",".$limit;

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByIdUserAuthor($id,$status,$limit) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.id_user = " . $this->db->escape($id) . " AND c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content,w.id_content LIMIT $limit";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleById($id_content) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link, u.email_user AS email

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.id_content = " . $this->db->escape($id_content) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }

    public function articleByIdContentIdUser($id_content,$id_user) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.id_content = " . $this->db->escape($id_content) . " AND c.id_user = " . $this->db->escape($id_user) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }

    public function lastArticleByKindStatus($kind,$status,$limit) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.kind = " . $this->db->escape($kind) . " AND c.content_status = " . $this->db->escape($status) . "  GROUP BY c.id_content,w.id_content ORDER BY c.id_content DESC LIMIT $limit";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function articleByUrl($url) {

        $sql = "SELECT COUNT(w.id_watch) AS wtch, COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, 

        c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, 

        c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

        FROM content_tb c LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN watch_content_tb w ON w.id_content = c.id_content 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link WHERE c.content_link = " . $this->db->escape($url) . " LIMIT 1";

        $query = $this->db->query($sql);

        $this->db->cache_on();

        return $query->result();

    }



    public function rejectByIdContent($id_content) {

        $sql = "SELECT * FROM content_reject_tb WHERE id_content = " . $this->db->escape($id_content) . " ORDER BY id_reject DESC LIMIT 1";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function updateRejectByStatus($id_reject, $status) {

        $sql = "UPDATE content_reject_tb SET "

        . "status_reject = " . $this->db->escape($status) . ""

        . " WHERE id_reject = " . $this->db->escape($id_reject) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function articleByVideoPath($path) {

        $sql = "SELECT id_content FROM content_tb WHERE content_video = " . $this->db->escape($path) . "";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function updateContentStatus($id_content, $status) {

        $sql = "UPDATE content_tb SET "

        . "content_status = " . $this->db->escape($status) . ""

        . " WHERE id_content = " . $this->db->escape($id_content) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function insertRejected($id_content, $reason_rejected, $datetime_reject, $status_reject) {

        $sql = "INSERT INTO content_reject_tb(id_content,reason_rejected,datetime_reject,status_reject) "

        . "VALUES("

        . "" . $this->db->escape($id_content) . ", "

        . "" . $this->db->escape($reason_rejected) . ", "

        . "" . $this->db->escape($datetime_reject) . ", "

        . "" . $this->db->escape($status_reject) . ")";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function updateReject($id_reject, $id_content, $status_reject) {

        $sql = "UPDATE menus_tb SET "

        . "status_reject = " . $this->db->escape($status_reject) . ""

        . " WHERE id_reject = " . $this->db->escape($id_reject) . " AND id_content = " . $this->db->escape($id_content) . "";

        $this->db->query($sql);

        return $this->db->affected_rows();

    }



    public function commentReview($status,$limit) {

        $sql = "SELECT COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, 

        m.menu_name AS menu, c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, 

        c.content_status AS stat, c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link 

        FROM content_tb c 

        LEFT JOIN users_tb u ON u.id_user = c.id_user 

        LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub 

        LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content 

        LEFT JOIN menus_tb m ON m.id_menu = c.id_category 

        LEFT JOIN tags_tb t ON t.content_link = c.content_link  WHERE c.content_status = " . $this->db->escape($status) . " GROUP BY c.id_content ORDER BY COUNT(cm.id_comment) DESC LIMIT $limit";

        $query = $this->db->query($sql);

        return $query->result(); 

    }



    public function contentBySeenToday() {

        $now = date("Y-m-d");

        $sql = "SELECT COUNT(w.id_watch) AS wtch, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

            FROM content_tb c

            LEFT JOIN users_tb u ON u.id_user = c.id_user

            LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub        

            LEFT JOIN watch_content_tb w ON w.id_content = c.id_content            

            LEFT JOIN menus_tb m ON m.id_menu  = c.id_category 

            WHERE date(w.watch_datetime) = '".$now."'

            GROUP BY w.id_content, date(w.watch_datetime)

            LIMIT 3";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function contentBySeenWeek() {

        $now = date("Y-m-d");

        $min = date("d")-7;

        $week = date("Y-m-".$min);

        $sql = "SELECT COUNT(w.id_watch) AS wtch, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

            FROM content_tb c

            LEFT JOIN users_tb u ON u.id_user = c.id_user

            LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub        

            LEFT JOIN watch_content_tb w ON w.id_content = c.id_content            

            LEFT JOIN menus_tb m ON m.id_menu  = c.id_category 

            WHERE date(w.watch_datetime) BETWEEN '".$week."' AND '".$now."'

            GROUP BY w.id_content, date(w.watch_datetime)

            LIMIT 3";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function contentTopComment(){
        $now = date("Y-m-d");
        $sql = "SELECT COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link
            FROM content_tb c
            LEFT JOIN users_tb u ON u.id_user = c.id_user
            LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub                   
            LEFT JOIN menus_tb m ON m.id_menu  = c.id_category 
            LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content
            WHERE date(cm.comment_datetime) = '$now'
            GROUP BY  cm.id_content
            ORDER BY cmnt DESC 
            LIMIT 4";
        $query = $this->db->query($sql);
        return $query->result();
    }



    public function contentTopCommentWeek(){

        $now = date("Y-m-d");

        $min = date("d")-7;

        $week = date("Y-m-".$min);

        $sql = "SELECT COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

            FROM content_tb c

            LEFT JOIN users_tb u ON u.id_user = c.id_user

            LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub                   

            LEFT JOIN menus_tb m ON m.id_menu  = c.id_category 

            LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

            WHERE DATE(c.content_datetime) BETWEEN '$week' AND ' $now'

            GROUP BY  cm.id_content, c.id_content

            ORDER BY cmnt DESC

            LIMIT 4";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function contentLastComment(){

        $sql = "SELECT COUNT(cm.id_comment) AS cmnt, c.id_content AS id, c.title AS title, c.content_describ AS describ, m.id_menu AS idmenu, m.menu_name AS menu, c.kind AS kind, c.content_video AS video, c.content_thumbnail AS thumbnail, s.sub_name AS sub, u.name_user AS uname, c.content_status AS stat, c.content_datetime AS datearticle, s.id_sub AS idsub, u.id_user AS idUser, c.content_link AS link

            FROM content_tb c

            LEFT JOIN users_tb u ON u.id_user = c.id_user

            LEFT JOIN menu_sub_tb s ON s.id_sub = c.id_sub                   

            LEFT JOIN menus_tb m ON m.id_menu  = c.id_category 

            LEFT JOIN comment_content_tb cm ON cm.id_content = c.id_content

            GROUP BY  cm.id_content

            ORDER BY cm.comment_datetime DESC

            LIMIT 6";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function lastComment(){

        $sql = "SELECT cm.comment as cmnt, u.name_user as cmntr, c.title as title, cm.comment_datetime as time, us.name_user as upldr, u.photo_user as photo

            FROM `comment_content_tb` as cm

            LEFT JOIN content_tb as c ON c.id_content = cm.id_content

            LEFT JOIN users_tb as u ON u.id_user = cm.id_user

            LEFT JOIN users_tb as us ON us.id_user = c.id_user

            ORDER BY comment_datetime DESC LIMIT 3";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function lastVideo(){

        $sql = "SELECT title, content_thumbnail as thumbnail, content_link as link, content_datetime as time, kind, content_video

        FROM `content_tb`

        WHERE kind = '2' AND content_status = '1'

        ORDER BY content_datetime DESC

        LIMIT 6";

        $query = $this->db->query($sql);

        return $query->result();

    }



    public function lastArticle(){

        $sql = "SELECT COUNT(cmn.id_comment) as cmnt, c.title AS title, c.content_describ AS descr, c.content_thumbnail as thumb, c.content_link AS link, date(c.content_datetime) AS time, u.name_user AS uname, c.kind as kind

        FROM content_tb AS c

        LEFT JOIN users_tb AS u ON u.id_user = c.id_user

        LEFT JOIN comment_content_tb AS cmn ON cmn.id_content = c.id_content

        WHERE c.kind = '1' AND c.content_status = '1'

        GROUP BY cmn.id_content

        ORDER BY c.content_datetime DESC

        LIMIT 3";

        $query = $this->db->query($sql);

        return $query->result();

    }

    public function articleRandom() {

        $sql = "SELECT title,kind,content_link FROM content_tb WHERE content_status = 1  ORDER BY RAND() LIMIT 5";

        $query = $this->db->query($sql);

        return $query->result();

    }


    public function analyticContent($id_user){
        $sql = "SELECT  u.id_user,u.name_user,c.id_content,c.title,SUM(b.bounce_sc),COUNT(w.id_watch)
            FROM content_tb c
            LEFT JOIN users_tb u ON u.id_user = c.id_user
            LEFT JOIN bounce_tb b ON b.id_content = c.id_content
            LEFT JOIN watch_content_tb w ON w.id_content = c.id_content
            WHERE c.id_user = " . $this->db->escape($id_user) . "
            GROUP BY c.id_content ORDER BY c.content_datetime DESC";

        $query = $this->db->query($sql);

        return $query->result();

    }

    public function analyticContentPagination($id_user,$limit,$start){
        $sql = "SELECT  u.id_user,u.name_user,c.id_content,c.title,SUM(b.bounce_sc) AS bounce,COUNT(w.id_watch) AS watch
            FROM content_tb c
            LEFT JOIN users_tb u ON u.id_user = c.id_user
            LEFT JOIN bounce_tb b ON b.id_content = c.id_content
            LEFT JOIN watch_content_tb w ON w.id_content = c.id_content
            WHERE c.id_user = " . $this->db->escape($id_user) . "
            GROUP BY c.id_content ORDER BY c.content_datetime DESC LIMIT $start,$limit";

        $query = $this->db->query($sql);

        return $query->result();

    }

}

