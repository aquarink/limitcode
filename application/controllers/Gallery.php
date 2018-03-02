<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller { 

	function __construct() 
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('language');
		$this->load->library('session');
		$this->load->helper('captcha');
		$this->load->library('user_agent');
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->library('form_validation');

		$this->load->model('Menu_Model');
		$this->load->model('User_Model');
	}

	public function index()
	{
		echo "Index Gallery";
	}

	public function newgallery()
	{
		$this->session->set_userdata('referred_from', 'article');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		$idUser = $this->session->userdata('id_user');
		$avatar = $this->User_Model->avatarById($idUser);

		if(!empty($avatar)) {
			if(file_exists(getcwd().$avatar[0]->avatar_path)) {
				$ava = $avatar[0]->avatar_path;
			} else {
				$ava = '/layout/img/NoAvatar.jpg';
			}
		} else {
			$ava = '/layout/img/NoAvatar.jpg';
		}

		$notifs = $this->User_Model->notifById($this->session->userdata('id_user'));

		$data = array(
			'notifications' => $notifs,
			'ava' => $ava,
			'menu' => '$showMenu',
			'content' => 'newgallery',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'Create New Gallery'
		);

    	$this->load->view('back/template/template',$data);
	}

	public function listgallery()
	{
		$this->session->set_userdata('referred_from', 'article');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		$idUser = $this->session->userdata('id_user');
		$avatar = $this->User_Model->avatarById($idUser);

		if(!empty($avatar)) {
			if(file_exists(getcwd().$avatar[0]->avatar_path)) {
				$ava = $avatar[0]->avatar_path;
			} else {
				$ava = '/layout/img/NoAvatar.jpg';
			}
		} else {
			$ava = '/layout/img/NoAvatar.jpg';
		}

		$notifs = $this->User_Model->notifById($this->session->userdata('id_user'));

		$data = array(
			'notifications' => $notifs,
			'ava' => $ava,
			'menu' => '$showMenu',
			'content' => 'listgallery',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'List of Gallerys'
		);

    	$this->load->view('back/template/template',$data);
	}

	public function newalbum()
	{
		$this->session->set_userdata('referred_from', 'article');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		$idUser = $this->session->userdata('id_user');
		$avatar = $this->User_Model->avatarById($idUser);

		if(!empty($avatar)) {
			if(file_exists(getcwd().$avatar[0]->avatar_path)) {
				$ava = $avatar[0]->avatar_path;
			} else {
				$ava = '/layout/img/NoAvatar.jpg';
			}
		} else {
			$ava = '/layout/img/NoAvatar.jpg';
		}

		$notifs = $this->User_Model->notifById($this->session->userdata('id_user'));

		$data = array(
			'notifications' => $notifs,
			'ava' => $ava,
			'menu' => '$showMenu',
			'content' => 'newalbum',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'Create New Album'
		);

    	$this->load->view('back/template/template',$data);
	}
}
