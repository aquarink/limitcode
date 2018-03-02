<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller { 

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
		$this->session->set_userdata('referred_from', 'menu');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		if(empty($this->session->userdata('id_user'))) {
			redirect('signin');
		}

		if($this->session->userdata('user_status') == 1) {
			redirect('signin');
		}

		$menu = $this->Menu_Model->menuByStatus(1);
		$subMenu = $this->Menu_Model->subMenuByStatus(1);

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
			'sess' => $this->session->userdata(),
			
			'menu' => '$showMenu',
			'content' => 'listmenu',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'List of Menus',

			'menus' => $menu,
			'subs' => $subMenu
		);

    	$this->load->view('back/template/template',$data);
	}

	public function newmenu()
	{
		$this->session->set_userdata('referred_from', 'menu/new');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		if(empty($this->session->userdata('id_user'))) {
			redirect('signin');
		}

		if($this->session->userdata('user_status') == 1) {
			redirect('signin');
		}


		if ($this->input->post()) {

			if($this->input->post('submit') == 'menu') {
				if(!empty($this->input->post('menuname'))) {
					$menuName = $this->input->post('menuname');

					$urlMenu = strtolower(str_replace(' ', '-', $menuName));

					//Check URL
					$url = $this->Menu_Model->menuByUrl($urlMenu);
					if(count($url) > 0) {
						redirect('menu?ex');
					} else {
						$newMenu = $this->Menu_Model->insertNewMenu($menuName, $urlMenu, 1);
						if($newMenu > 0) {
							redirect('menu?ok');
						}
					}
				} else {
					redirect('menu?no');
				}				
			}


			if($this->input->post('submit') == 'submenu') {
				if(!empty($this->input->post('submenuname')) || !empty($this->input->post('menuname'))) {
					$menuId = $this->input->post('menuname');
					$subMenuName = $this->input->post('submenuname');

					$urlSubMenu = strtolower(str_replace(' ', '-', $subMenuName));

					//Check URL
					$url = $this->Menu_Model->menuByIdMenuUrl($menuId, $urlSubMenu);
					if(count($url) > 0) {
						redirect('menu?exs');
					} else {
						$newSubMenu = $this->Menu_Model->insertNewSubMenu($menuId, $subMenuName, $urlSubMenu, 1);
						if($newSubMenu > 0) {
							redirect('menu?yes');
						}
					}
				} else {
					redirect('menu?not');
				}
			}
		}
	}


	public function editmenu()
	{
		$this->session->set_userdata('referred_from', 'menu/edit');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		if(empty($this->session->userdata('id_user'))) {
			redirect('signin');
		}

		if($this->session->userdata('user_status') == 1) {
			redirect('signin');
		}


		if ($this->input->post()) {

			if($this->input->post('submit') == 'editmenu') {
				if(!empty($this->input->post('menuname')) || !empty($this->input->post('menuid'))) {

					$menuId = $this->input->post('menuid');
					$menuName = $this->input->post('menuname');

					$urlSubMenu = strtolower(str_replace(' ', '-', $menuName));

					//Check URL
					$url = $this->Menu_Model->menuByUrl($urlSubMenu);
					if(count($url) > 0) {
						redirect('menu?exE');
					} else {
						$updateMenu = $this->Menu_Model->updateMenu($menuId, $menuName, $urlSubMenu, 1);
						if($updateMenu > 0) {
							redirect('menu?okE');
						}
					}
				} else {
					redirect('menu?noE');
				}				
			}


			if($this->input->post('submit') == 'editsub') {
				if(!empty($this->input->post('subid')) || !empty($this->input->post('subname')) || !empty($this->input->post('menuname'))) {

					$menuId = $this->input->post('menuname');
					$subId = $this->input->post('subid');
					$subMenuName = $this->input->post('subname');

					$urlSubMenu = strtolower(str_replace(' ', '-', $subMenuName));

					//Check URL
					$url = $this->Menu_Model->menuByIdMenuUrl($menuId, $urlSubMenu);
					if(count($url) > 0) {
						redirect('menu?exsE');
					} else {
						$updateSubMenu = $this->Menu_Model->updateSubMenu($subId, $menuId, $subMenuName, $urlSubMenu, 1);
						if($updateSubMenu > 0) {
							redirect('menu?yesE');
						}
					}
				} else {
					redirect('menu?notE');
				}
			}
		}
	}
}
