<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller { 

	function __construct() 
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('language');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('captcha');
		$this->load->library('user_agent');
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->library('form_validation');

		$this->load->model('Menu_Model');
		$this->load->model('User_Model');
		$this->load->model('Article_Model');
	}

	public function index()
	{
		$this->session->set_userdata('referred_from', 'admin'); 

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

	public function dashboard()
	{
		$this->session->set_userdata('referred_from', 'dashboard');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		if(empty($this->session->userdata('id_user'))) {
			redirect('signin');
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


		$analytic = $this->Article_Model->analyticContent($this->session->userdata('id_user'));

		// init params
        $params = array();
        $limit_per_page = 5;
        $page = ($this->uri->segment(2)) ? ($this->uri->segment(2) - 1) : 0;
        $total_records = count($analytic);
        $showing = "Showing data from ".$total_records." entries";
     
        if ($total_records > 0)
        {
            $dataLimit = $this->Article_Model->analyticContentPagination($this->session->userdata('id_user'),$limit_per_page, $page * $limit_per_page);
                 
            $config['base_url'] = base_url() . index_with() . 'dashboard';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 2;
             
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

            foreach ($dataLimit as $key => $value) {
	        	$labels[] = substr(ucwords($value->title), 0,10);
	        	$views[] = $value->watch;
	        	$bounces[] = $value->bounce;
	        }
                 
            // build paging links
            $paging = $this->pagination->create_links();
        } else {
        	$dataLimit = $params;
        	$paging = '';


	        $labels = $params;
	        $views = $params;
	        $bounces = $params;
        }

        

        $label = '"'.join('","',$labels).'"';
        $view = join(',',$views);
        $bounce = join(',',$bounces);

		$data = array(
			'notifications' => $notifs,
			'ava' => $ava,
			'sess' => $this->session->userdata(),

			'chart' => true,
			'dataLimit' => $dataLimit,
			'label' => $label,
			'view' => $view,
			'bounce' => $bounce,
			'pagination' => $paging,
			'show' => $showing,

			'menu' => '$showMenu',
			'content' => 'dashboard',
			'active' => strtolower($this->uri->segment(1)),
			'webtitle' => 'Dashboard'
		);

    	$this->load->view('back/template/template',$data); 
	}

	public function signout()
	{
		$this->session->sess_destroy();
		$this->session->unset_userdata('__ci_last_regenerate');
		$this->session->unset_userdata('FBRLH_state');

		unset($_COOKIE['email']);
		
		setcookie('email', '', time() + (86400 * 30), "/");
		
		redirect('signin');
	}

	public function editprofile()
	{
		$this->session->set_userdata('referred_from', 'editprofile');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		if(empty($this->session->userdata('id_user'))) {
			redirect('signin');
		}

		if(isset($_GET['true'])) {
			$msgModals = 'true';
		} else {
			$msgModals = '';
		}

		$errors = '';

		$idUser = $this->session->userdata('id_user');

		$userByEmail = $this->User_Model->userByEmail($this->session->userdata('email_user'));

		if(empty($userByEmail[0]->identity_card)) {
			$ktp = 'layout/img/NoAvatar.jpg';
		} else {
			$ktp = $userByEmail[0]->identity_card;
		}

		if ($this->input->post()) {
			if($this->input->post('submit') == 'updateprofile') {

				if(isset($_FILES["avatar"]["name"])) {

					$path = getcwd();

					if(empty($_FILES["avatar"]["name"]) && !empty($this->input->post('nameuser'))) {
						$updateName = $this->User_Model->updateNameUser($this->session->userdata('email_user'), $this->input->post('nameuser'));
						if($updateName > 0) {

							$this->session->set_userdata('name_user', ucwords($this->input->post('nameuser')));

							redirect('editprofile?true');
						} else {
							redirect('editprofile?false');
						}

					} elseif(empty($_FILES["avatar"]["name"]) || empty($this->input->post('nameuser'))) {
						$errors = 'Avatar or Name may be empty';
					}else {
						$type = $_FILES['avatar']['type'];
						$expType = explode('/', $type);

						if($expType[1] == 'gif' || $expType[1] == 'jpg' || $expType[1] == 'png' || $expType[1] == 'jpeg') {
							//config
							$config['upload_path'] = './layout/img/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';
							$nameuser = $this->input->post('nameuser');	

							$getUserById = $this->User_Model->userById($idUser);

							$hashName = md5($getUserById[0]->email_user);

							$newName = $hashName.'.'.$expType[1];

							$newNameAfterResize = '/layout/img/'.$hashName.'_thumb.'.$expType[1];

							$config['file_name'] = $newName;
							

							if (!is_dir($path.'/layout/img/'))
						    {
						        mkdir($path.'/layout/img/', 0777, true);
						    }

							$this->load->library('upload', $config);

							if (! $this->upload->do_upload('avatar'))
							{
								$error = array('error' => $this->upload->display_errors());

								$errors = 'Thumbnail can not uploaded';
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());

								$config['image_library'] = 'gd2';  
								$config['source_image'] = './layout/img/'.$newName;  
								$config['create_thumb'] = TRUE;  
								$config['maintain_ratio'] = TRUE;  
								  
								$config['width'] = 800;  

								$this->load->library('image_lib', $config);  
								$this->image_lib->resize();

								if(unlink($path.'/layout/img/'.$newName)) 	{
									$insertAvatar = $this->User_Model->insertAvatar($idUser, $newNameAfterResize, date('Y-m-d H:i:s'));

									if($insertAvatar > 0) {
										 $updateNamePhoto = $this->User_Model->updateNamePhotoUser($this->session->userdata('email_user'), $this->input->post('nameuser'), $newNameAfterResize);

										if($updateNamePhoto > 0) {

											$this->session->set_userdata('name_user', ucwords($this->input->post('nameuser')));
											
											redirect('editprofile?true');
										} else {
											redirect('editprofile?false');
										}
									} else {
										redirect('editprofile?false');
									}
								} else {
									$errors = 'Can not create thumbnail';
								}

							// $this->load->view('upload_success', $data);
							// print_r($data);
							}
						} else {
							$errors = 'Thumbnail fromat wrong please use format gif, jpg, png or jpeg, this format is '.$expType[1];
						}
					}
				} else {
					$errors = 'Title, Thumbnail, Article, Parent Menu or Sub Menu may be empty';
				}
			}	

			if($this->input->post('submit') == 'ktp') {

				if(isset($_FILES["ktpImage"]["name"])) {

					$path = getcwd();

					if(empty($_FILES["ktpImage"]["name"])) {
						redirect('editprofile?false');

					} else {
						$type = $_FILES['ktpImage']['type'];
						$expType = explode('/', $type);

						if($expType[1] == 'gif' || $expType[1] == 'jpg' || $expType[1] == 'png' || $expType[1] == 'jpeg') {
							//config
							$config['upload_path'] = './uploads/ktp/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';

							$getUserById = $this->User_Model->userById($idUser);

							$hashName = md5($getUserById[0]->email_user);

							$newName = $hashName.'.'.$expType[1];

							$newNameAfterResize = '/uploads/ktp/'.$hashName.'_thumb.'.$expType[1];

							$config['file_name'] = $newName;
							

							if (!is_dir($path.'/uploads/ktp/'))
						    {
						        mkdir($path.'/uploads/ktp/', 0777, true);
						    }

							$this->load->library('upload', $config);

							if (! $this->upload->do_upload('ktpImage'))
							{
								$error = array('error' => $this->upload->display_errors());

								$errors = 'ID Card can not uploaded';
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());

								$config['image_library'] = 'gd2';  
								$config['source_image'] = './uploads/ktp/'.$newName;  
								$config['create_thumb'] = TRUE;  
								$config['maintain_ratio'] = TRUE;  
								  
								$config['width'] = 800;  

								$this->load->library('image_lib', $config);  
								$this->image_lib->resize();

								if(unlink($path.'/uploads/ktp/'.$newName)) 	{

									$updateKtp = $this->User_Model->updateKtp($this->session->userdata('email_user'), $newNameAfterResize);

									if($updateKtp > 0) {										
										redirect('editprofile?true');
									} else {
										redirect('editprofile?false');
									}
								} else {
									$errors = 'Can not create thumbnail';
								}
							}
						} else {
							$errors = 'ID Card Image fromat wrong please use format gif, jpg, png or jpeg, this format is '.$expType[1];
						}
					}
				} else {
					$errors = 'ID Card Image you choose may be empty';
				}
			}

			// Change Password
			if($this->input->post('submit') == 'changepassword') {
				if($this->input->post('passworduser') == $this->input->post('repassworduser')) {
					$updatePass = $this->User_Model->updatePassUser($this->session->userdata('email_user'), md5($this->input->post('passworduser')));
					if($updatePass > 0) {
						redirect('signout');
					} else {
						redirect('editprofile?nmatchFalse');
					}
				} else {
					redirect('editprofile?nmatch');
				}
			}	
		}

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

			'modals' => $msgModals,
			'errors' => $errors,

			'ktp' => $ktp,

			'menu' => '$showMenu',
			'content' => 'editprofile',
			'active' => strtolower($this->uri->segment(1)),
			'webtitle' => 'Edit Profile'
		);

    	$this->load->view('back/template/template',$data);
	}

	public function newadmin()
	{
		$this->session->set_userdata('referred_from', 'admin/new');

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
			'content' => 'newadmin',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'Register New Admin'
		);

    	$this->load->view('back/template/template',$data);
	}

	public function listadmin()
	{
		$this->session->set_userdata('referred_from', 'admin/list');

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
			'content' => 'listadmin',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'List of Admin Registered'
		);

    	$this->load->view('back/template/template',$data);
	}
}
