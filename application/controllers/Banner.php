<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller { 

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
		$this->load->model('Banner_Model');
		$this->load->model('User_Model');
	}

	public function index()
	{
		$this->session->set_userdata('referred_from', 'banner');

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

	public function newbanner()
	{
		$this->session->set_userdata('referred_from', 'banner/new');

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
		
		$errors = '';

		if ($this->input->post()) {
			if($this->input->post('submit') == 'uploadbanner') {
				if(isset($_FILES["thebanner"]["name"])) {
					if(empty($_FILES["thebanner"]["name"]) || empty($this->input->post('titlebanner')) || empty($this->input->post('advertiserbanner')) || empty($this->input->post('sizebanner'))) {

						$errors = 'Title, Advertiser, Potition Or Banner Image may be empty';

					} else {
						$type = $_FILES['thebanner']['type'];
						$expType = explode('/', $type);

						if($expType[1] == 'gif' || $expType[1] == 'jpg' || $expType[1] == 'png' || $expType[1] == 'jpeg') {
							//config
							$config['upload_path'] = './uploads/'.date('Y').'/'.date('F').'/ads/banner/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';

							$title = $this->input->post('titlebanner');
							$advertiser = $this->input->post('advertiserbanner');
							$size = $this->input->post('sizebanner');

							$expSize = explode('x', $size);

							$ad_width = $expSize[0];
							$ad_height = $expSize[1];
							$position = $expSize[2];

							$newTitle1 = strtolower(str_replace('.', ' ', $title));
							$newTitle2 = strtolower(str_replace(',', ' ', $newTitle1));
							$newTitle3 = strtolower(str_replace('-', ' ', $newTitle2));
							$newTitle4 = strtolower(str_replace(':', ' ', $newTitle3));
							$newTitle5 = strtolower(str_replace(' ', '_', $newTitle4));

							$content_link = $newTitle5.'_'.date('YmdHis');					

							$nameRand = $content_link.'_'.rand(1,99999);					
							$newName = $nameRand.'.'.$expType[1];

							$config['file_name'] = $newName;

							$path = getcwd();

							if (!is_dir($path.'/uploads/'.date('Y').'/'.date('F').'/ads/banner'))
						    {
						        mkdir($path.'/uploads/'.date('Y').'/'.date('F').'/ads/banner', 0777, true);
						    }

						    $ad_path = 'uploads/'.date('Y').'/'.date('F').'/ads/banner/'.$newName;

							$this->load->library('upload', $config);

							if (! $this->upload->do_upload('thebanner'))
							{
								$error = array('error' => $this->upload->display_errors());

								$errors = 'Banner Image can not uploaded';
							}
							else 
							{
								$datas = array('upload_data' => $this->upload->data());

								$cekPosition = $this->Banner_Model->bannerByPosition($position);
								if(count($cekPosition) > 0) {
									$UpdateStatus = $this->Banner_Model->updateStatusPosition($position,0);

									if($UpdateStatus > 0) {
										$insertNewAd = $this->Banner_Model->insertNewAds($title, $advertiser, $position, $ad_width, $ad_height, $ad_path, date('Y-m-d H:i:s'), 1);

										if($insertNewAd > 0) {
											redirect('banner/list');
										} else {
											$errors = 'Banner Image failed to upload';
										}
									} else {
										$errors = 'Update Banner Status failed';
									}
								} else {
									$insertNewAd = $this->Banner_Model->insertNewAds($title, $advertiser, $position, $ad_width, $ad_height, $ad_path, date('Y-m-d H:i:s'), 1);

									if($insertNewAd > 0) {
										redirect('banner/list');
									} else {
										$errors = 'Banner Image failed to upload';
									}
								}
								
							}
						} else {
							$errors = 'Banner Image fromat wrong please use format gif, jpg, png or jpeg, this format is '.$expType[1];
						}
					}
				}
			}
		}

		echo $errors;

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
			'content' => 'newbanner',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'Upload New Banner',

			'msg' => $errors
		);

		$this->load->view('back/template/template',$data);
	}

	public function listbanner()
	{
		$this->session->set_userdata('referred_from', 'banner/list');

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
		
		$ads = $this->Banner_Model->bannerList();

		// init params
        $params = array();
        $limit_per_page = 10;
        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
        $total_records = count($ads);
        $showing = "Showing data from ".$total_records." entries";
     
        if ($total_records > 0)
        {
            // get current page records
            $dataLimit = $this->Banner_Model->bannerListPagination($limit_per_page, $page * $limit_per_page);
                 
            $config['base_url'] = base_url() . index_with() . 'banner/list';
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

			'ads' => $dataLimit,

			'pagination' => $paging,
			'show' => $showing,

			'search' => true,
			
			'menu' => '$showMenu',
			'content' => 'listbanner',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'List of Banners'
		);

		$this->load->view('back/template/template',$data);
	}

	public function banneraction()
	{	
		// active
		// delete
		// disable
		$action = $this->uri->segment(2);
		$idAd = $this->uri->segment(3);

		$bannerId = $this->Banner_Model->bannerById($idAd);

		if(count($bannerId) > 0) {

			if($action == 'active') {
				$updateStatusPosition = $this->Banner_Model->updateStatusPosition($bannerId[0]->ad_postition,0);

				if($updateStatusPosition > 0) {
					$updateStatusId = $this->Banner_Model->updateStatusId($idAd,1);

					if($updateStatusId > 0) {
						redirect('banner/list?ok');
					} else {
						redirect('banner/list?no');
					}
				}
			} elseif($action == 'disable') {
				$updateStatusId = $this->Banner_Model->updateStatusId($idAd,0);

				if($updateStatusId > 0) {
					redirect('banner/list?ok');
				} else {
					redirect('banner/list?no');
				}
			}

		} else {
			redirect('banner/list');
		}
	}
}
