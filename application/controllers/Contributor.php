<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contributor extends CI_Controller { 

	function __construct() 
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('pagination');
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
		$this->session->set_userdata('referred_from', 'contributor');

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
	}

	public function waiting() 
	{
		$this->session->set_userdata('referred_from', 'contributor/waiting');

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

		$userAll = $this->User_Model->userDataByStatus(array(0));

		// init params
        $params = array();
        $limit_per_page = 10;
        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
        $total_records = count($userAll);
        $showing = "Showing data from ".$total_records." entries";
     
        if ($total_records > 0)
        {
            // get current page records
            $dataLimit = $this->User_Model->userDataPagination(array(0), $limit_per_page, $page * $limit_per_page);
                 
            $config['base_url'] = base_url() . index_with() . 'contributor/waiting';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
            // custom paging configuration
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
             
            $config['first_link'] = 'First Page';
            $config['first_tag_open'] = '<li class="paginate_button previous">';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last Page';
            $config['last_tag_open'] = '<li class="paginate_button next">';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next Page';
            $config['next_tag_open'] = '<li class="paginate_button next">';
            $config['next_tag_close'] = '</li>';
 
            $config['prev_link'] = 'Prev Page';
            $config['prev_tag_open'] = '<li class="paginate_button previous">';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="paginate_button active"><a>';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="paginate_button">';
            $config['num_tag_close'] = '</li>';
             
            $this->pagination->initialize($config);
                 
            // build paging links
            $paging = $this->pagination->create_links();
        } else {
        	$dataLimit = $params;
        	$paging = '';
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
			'sess' => $this->session->userdata(),

			'userdata' => $dataLimit,

			'search' => true,
			'pagination' => $paging,
			'show' => $showing,

			'menu' => '$showMenu',
			'content' => 'contribwaiting',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'Waiting for Contributor Approval'
		);

    	$this->load->view('back/template/template',$data);
	}

	public function approved()
	{
		$this->session->set_userdata('referred_from', 'contributor/approved');

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

		$userAll = $this->User_Model->userDataByStatus(array(1,2));

		// init params
        $params = array();
        $limit_per_page = 10;
        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
        $total_records = count($userAll);
        $showing = "Showing data from ".$total_records." entries";
     
        if ($total_records > 0)
        {
            // get current page records
            $dataLimit = $this->User_Model->userDataPagination(array(1,2), $limit_per_page, $page * $limit_per_page);
                 
            $config['base_url'] = base_url() . index_with() . 'contributor/approved';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
            // custom paging configuration
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
             
            $config['first_link'] = 'First Page';
            $config['first_tag_open'] = '<li class="paginate_button previous">';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last Page';
            $config['last_tag_open'] = '<li class="paginate_button next">';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next Page';
            $config['next_tag_open'] = '<li class="paginate_button next">';
            $config['next_tag_close'] = '</li>';
 
            $config['prev_link'] = 'Prev Page';
            $config['prev_tag_open'] = '<li class="paginate_button previous">';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="paginate_button active"><a>';
            $config['cur_tag_close'] = '</a></li>';
 
            $config['num_tag_open'] = '<li class="paginate_button">';
            $config['num_tag_close'] = '</li>';
             
            $this->pagination->initialize($config);
                 
            // build paging links
            $paging = $this->pagination->create_links();
        } else {
        	$dataLimit = $params;
        	$paging = '';
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
			'sess' => $this->session->userdata(),

			'userdata' => $dataLimit,

			'search' => true,
			'pagination' => $paging,
			'show' => $showing,
			
			'menu' => '$showMenu',
			'content' => 'contribapproved',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'List of Contributor Approved'
		);

    	$this->load->view('back/template/template',$data);
	}

	public function verify()
	{
		if($this->uri->segment(2) == 'verify' || $this->uri->segment(2) == 'block' && $this->uri->segment(3) != '') {

			$id = $this->uri->segment(3);

			$userData = $this->User_Model->userById($id);

			if($this->uri->segment(2) == 'verify') {
				$v = 2;
			} elseif($this->uri->segment(2) == 'block') {
				$v = 4;
			} else {
				$v = '';
			}

			foreach ($userData as $key => $value) {

				if(!empty($value->id_user)) {

					$updateUser = $this->User_Model->updateVerifiedAccount($id,$v);

					if($updateUser > 0) {						
						redirect('contributor/approved?ok');
					} else {
						redirect('contributor/approved?no');
					}

				} else {

					redirect('contributor/approved?ex');

				}

			}

		} else {

			redirect('approval/'.$red.'');

		}
	}
}
