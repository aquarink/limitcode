/*
SQLyog Enterprise v10.42 
MySQL - 5.5.5-10.1.25-MariaDB : Database - limitcode
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`limitcode` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `limitcode`;

/*Table structure for table `ads_tb` */

DROP TABLE IF EXISTS `ads_tb`;

CREATE TABLE `ads_tb` (
  `id_ad` int(11) NOT NULL AUTO_INCREMENT,
  `ad_title` varchar(250) DEFAULT NULL,
  `advertiser` varchar(250) DEFAULT NULL,
  `ad_postition` varchar(250) DEFAULT NULL,
  `ad_width` int(11) DEFAULT NULL,
  `ad_height` int(11) DEFAULT NULL,
  `ad_path` text,
  `ad_datetime` datetime DEFAULT NULL,
  `ad_status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_ad`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Table structure for table `album_gallery_tb` */

DROP TABLE IF EXISTS `album_gallery_tb`;

CREATE TABLE `album_gallery_tb` (
  `id_album` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_gallery` int(11) DEFAULT NULL,
  `album_name` varchar(250) DEFAULT NULL,
  `album_thumbnail` text,
  `datetime_album` datetime DEFAULT NULL,
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `avatar_tb` */

DROP TABLE IF EXISTS `avatar_tb`;

CREATE TABLE `avatar_tb` (
  `id_avatar` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `avatar_path` text,
  `avatar_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_avatar`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Table structure for table `bounce_tb` */

DROP TABLE IF EXISTS `bounce_tb`;

CREATE TABLE `bounce_tb` (
  `id_bounce` int(11) NOT NULL AUTO_INCREMENT,
  `random_page_id` varchar(100) DEFAULT NULL,
  `id_content` int(11) DEFAULT NULL,
  `ip_client` varchar(100) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `bounce_datetime` datetime DEFAULT NULL,
  `bounce_sc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bounce`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;

/*Table structure for table `comment_content_tb` */

DROP TABLE IF EXISTS `comment_content_tb`;

CREATE TABLE `comment_content_tb` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `comment` text,
  `ip_client` varchar(200) DEFAULT NULL,
  `comment_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_comment`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `content_gallery_tb` */

DROP TABLE IF EXISTS `content_gallery_tb`;

CREATE TABLE `content_gallery_tb` (
  `id_content` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `id_album` int(11) DEFAULT NULL,
  `kind` varchar(10) DEFAULT NULL,
  `title_gallery` varchar(250) DEFAULT NULL,
  `content_describ` longtext,
  `content_link` text,
  `path_gallery` text,
  `datetime_gallery` datetime DEFAULT NULL,
  `edited_status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_content`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `content_reject_tb` */

DROP TABLE IF EXISTS `content_reject_tb`;

CREATE TABLE `content_reject_tb` (
  `id_reject` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) DEFAULT NULL,
  `reason_rejected` text,
  `datetime_reject` datetime DEFAULT NULL,
  `status_reject` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_reject`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Table structure for table `content_tb` */

DROP TABLE IF EXISTS `content_tb`;

CREATE TABLE `content_tb` (
  `id_content` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `id_sub` int(11) DEFAULT NULL,
  `kind` varchar(10) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `content_describ` longtext,
  `content_video` text,
  `content_thumbnail` text,
  `content_link` text,
  `content_datetime` datetime DEFAULT NULL,
  `edited_status` varchar(10) DEFAULT NULL,
  `content_status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_content`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Table structure for table `email_tb` */

DROP TABLE IF EXISTS `email_tb`;

CREATE TABLE `email_tb` (
  `id_email` int(11) NOT NULL AUTO_INCREMENT,
  `send_to` varchar(250) DEFAULT NULL,
  `mail_subject` text,
  `mail_message` text,
  `send_datetime` datetime DEFAULT NULL,
  `send_status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `feeds_subscriber_tb` */

DROP TABLE IF EXISTS `feeds_subscriber_tb`;

CREATE TABLE `feeds_subscriber_tb` (
  `id_subscrib` int(11) NOT NULL AUTO_INCREMENT,
  `email_subscrib` varchar(250) DEFAULT NULL,
  `subscribe_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_subscrib`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `login_log_tb` */

DROP TABLE IF EXISTS `login_log_tb`;

CREATE TABLE `login_log_tb` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `ip_user` varchar(100) DEFAULT NULL,
  `browser_info` text,
  `datetime_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

/*Table structure for table `menu_sub_tb` */

DROP TABLE IF EXISTS `menu_sub_tb`;

CREATE TABLE `menu_sub_tb` (
  `id_sub` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) DEFAULT NULL,
  `sub_name` varchar(30) DEFAULT NULL,
  `sub_url` text,
  `sub_status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_sub`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

/*Table structure for table `menus_tb` */

DROP TABLE IF EXISTS `menus_tb`;

CREATE TABLE `menus_tb` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(30) DEFAULT NULL,
  `menu_url` text,
  `menu_status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Table structure for table `notif_tb` */

DROP TABLE IF EXISTS `notif_tb`;

CREATE TABLE `notif_tb` (
  `id_notif` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `kind_notif` varchar(100) DEFAULT NULL,
  `url_notif` text,
  `status_notif` int(11) DEFAULT NULL,
  `datetime_notif` datetime DEFAULT NULL,
  PRIMARY KEY (`id_notif`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `short_url_analytics_tb` */

DROP TABLE IF EXISTS `short_url_analytics_tb`;

CREATE TABLE `short_url_analytics_tb` (
  `id_analytic` int(11) NOT NULL AUTO_INCREMENT,
  `id_short` int(11) DEFAULT NULL,
  `url_code` varchar(100) DEFAULT NULL,
  `ip_client` varchar(100) DEFAULT NULL,
  `browser_client` text,
  `type_client` varchar(100) DEFAULT NULL,
  `analytic_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_analytic`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `short_url_tb` */

DROP TABLE IF EXISTS `short_url_tb`;

CREATE TABLE `short_url_tb` (
  `id_short` int(11) NOT NULL AUTO_INCREMENT,
  `url_code` varchar(100) DEFAULT NULL,
  `url_short` varchar(200) DEFAULT NULL,
  `url_long` text,
  `short_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_short`)
) ENGINE=InnoDB AUTO_INCREMENT=3696 DEFAULT CHARSET=latin1;

/*Table structure for table `tags_tb` */

DROP TABLE IF EXISTS `tags_tb`;

CREATE TABLE `tags_tb` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `content_link` text,
  `the_tags` text,
  `tag_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tag`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `user_reqpass_tb` */

DROP TABLE IF EXISTS `user_reqpass_tb`;

CREATE TABLE `user_reqpass_tb` (
  `id_req` int(11) NOT NULL AUTO_INCREMENT,
  `email_user` varchar(200) DEFAULT NULL,
  `code` varchar(30) DEFAULT NULL,
  `request_date` varchar(30) DEFAULT NULL,
  `end_date` varchar(30) DEFAULT NULL,
  `req_verify` varchar(10) DEFAULT NULL,
  `req_verify_date` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_req`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user_verify_tb` */

DROP TABLE IF EXISTS `user_verify_tb`;

CREATE TABLE `user_verify_tb` (
  `id_verify` int(11) NOT NULL AUTO_INCREMENT,
  `email_user` varchar(200) DEFAULT NULL,
  `verify_code` varchar(200) DEFAULT NULL,
  `register_date` varchar(30) DEFAULT NULL,
  `valid_date` varchar(30) DEFAULT NULL,
  `verify_date` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_verify`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Table structure for table `users_tb` */

DROP TABLE IF EXISTS `users_tb`;

CREATE TABLE `users_tb` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email_user` varchar(200) DEFAULT NULL,
  `password_user` varchar(200) DEFAULT NULL,
  `name_user` varchar(200) DEFAULT NULL,
  `bhirtday_user` varchar(30) DEFAULT NULL,
  `gender_user` varchar(10) DEFAULT NULL,
  `photo_user` text,
  `auth_by` varchar(20) DEFAULT NULL,
  `register_date` varchar(30) DEFAULT NULL,
  `verify` varchar(10) DEFAULT NULL,
  `user_status` varchar(10) DEFAULT NULL,
  `identity_card` text,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Table structure for table `visitor_tb` */

DROP TABLE IF EXISTS `visitor_tb`;

CREATE TABLE `visitor_tb` (
  `id_visitor` int(11) NOT NULL AUTO_INCREMENT,
  `ip_visitor` varchar(100) DEFAULT NULL,
  `browser_info` text,
  `datetime_visit` datetime DEFAULT NULL,
  PRIMARY KEY (`id_visitor`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Table structure for table `watch_content_tb` */

DROP TABLE IF EXISTS `watch_content_tb`;

CREATE TABLE `watch_content_tb` (
  `id_watch` int(11) NOT NULL AUTO_INCREMENT,
  `id_content` int(11) DEFAULT NULL,
  `ip_client` varchar(200) DEFAULT NULL,
  `watch_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_watch`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
