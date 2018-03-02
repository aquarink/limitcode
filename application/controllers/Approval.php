<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Approval extends CI_Controller { 



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

		$this->load->model('Article_Model');

		$this->load->model('User_Model');

		$this->load->model('Email_Model');

	}



	public function index()

	{

		$this->session->set_userdata('referred_from', 'approval');



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



	public function waitapproval()

	{

		$this->session->set_userdata('referred_from', 'approval/wait');



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



		$contents = $this->Article_Model->articleByStatus(0);



		// init params

        $params = array();

        $limit_per_page = 10;

        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

        $total_records = count($contents);

        $showing = "Showing data from ".$total_records." entries";

     

        if ($total_records > 0)

        {

            // get current page records

            $dataLimit = $this->Article_Model->articlePagination(0,$limit_per_page, $page * $limit_per_page);

                 

            $config['base_url'] = base_url() . index_with() . 'approval/waiting';

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



		if(count($dataLimit) > 0) {

			foreach ($dataLimit as $key => $value) {



				$comment = $this->Article_Model->articleCommentByIdUserKind(1,$value->id);



				foreach ($comment as $k => $cm) {

				// print_r($value);

					$v[$value->id]['wtch'] = $value->wtch;

					$v[$value->id]['title'] = $value->title;

					$v[$value->id]['menu'] = $value->menu;

					$v[$value->id]['sub'] = $value->sub;

					$v[$value->id]['kind'] = $value->kind;

					$v[$value->id]['video'] = $value->video;

					$v[$value->id]['thumbnail'] = $value->thumbnail;

					$v[$value->id]['uname'] = $value->uname;

					$v[$value->id]['stat'] = $value->stat;

					$v[$value->id]['datearticle'] = $value->datearticle;

					$v[$value->id]['cmnt'] = $cm->cmnt;

				}



			}

		} else {

			$v = array();

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



			'from' => $this->uri->segment(2),

			'e' => $this->input->get('e'),



			'search' => true,

			'pagination' => $paging,

			'show' => $showing,



			'menu' => '$showMenu',

			'content' => 'waitapproval',

			'active' => strtolower($this->uri->segment(1)),

			'sub' => strtolower($this->uri->segment(2)),

			'webtitle' => 'Waiting fo Approval',



			'contents' => $v

		);



		$this->load->view('back/template/template',$data);

	}



	public function contentapproved()

	{

		$this->session->set_userdata('referred_from', 'approval/approved');



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



		$contents = $this->Article_Model->articleByStatus(1);



		// init params

        $params = array();

        $limit_per_page = 5;

        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

        $total_records = count($contents);

        $showing = "Showing data from ".$total_records." entries";

     

        if ($total_records > 0)

        {

            // get current page records

            $dataLimit = $this->Article_Model->articlePagination(1,$limit_per_page, $page * $limit_per_page);

                 

            $config['base_url'] = base_url() . index_with() . 'approval/approved';

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



		if(count($dataLimit) > 0) {

			foreach ($dataLimit as $key => $value) {



				$comment = $this->Article_Model->articleCommentByIdUserKind(1,$value->id);



				foreach ($comment as $k => $cm) {

					// print_r($value);

					$v[$value->id]['wtch'] = $value->wtch;

					$v[$value->id]['title'] = $value->title;

					$v[$value->id]['menu'] = $value->menu;

					$v[$value->id]['sub'] = $value->sub;

					$v[$value->id]['kind'] = $value->kind;

					$v[$value->id]['video'] = $value->video;

					$v[$value->id]['thumbnail'] = $value->thumbnail;

					$v[$value->id]['uname'] = $value->uname;

					$v[$value->id]['stat'] = $value->stat;

					$v[$value->id]['datearticle'] = $value->datearticle;

					$v[$value->id]['cmnt'] = $cm->cmnt;

				}

				

			}

		} else {

			$v = array();

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



			'search' => true,

			'pagination' => $paging,

			'show' => $showing,



			'menu' => '$showMenu',

			'content' => 'contentapproved',

			'active' => strtolower($this->uri->segment(1)),

			'sub' => strtolower($this->uri->segment(2)),

			'webtitle' => 'List of Content Approved',



			'contents' => $v

		);



		$this->load->view('back/template/template',$data);

	}



	public function contentblock()

	{

		$this->session->set_userdata('referred_from', 'approval/blocked');



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



		$contents = $this->Article_Model->articleByStatus(3);



		// init params

        $params = array();

        $limit_per_page = 10;

        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

        $total_records = count($contents);

        $showing = "Showing data from ".$total_records." entries";

     

        if ($total_records > 0)

        {

            // get current page records

            $dataLimit = $this->Article_Model->articlePagination(3,$limit_per_page, $page * $limit_per_page);

                 

            $config['base_url'] = base_url() . index_with() . 'approval/blocked';

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



		if(count($contents) > 0) {

			foreach ($contents as $key => $value) {



				$comment = $this->Article_Model->articleCommentByIdUserKind(1,$value->id);



				foreach ($comment as $k => $cm) {

					// print_r($value);

					$v[$value->id]['wtch'] = $value->wtch;

					$v[$value->id]['title'] = $value->title;

					$v[$value->id]['menu'] = $value->menu;

					$v[$value->id]['sub'] = $value->sub;

					$v[$value->id]['kind'] = $value->kind;

					$v[$value->id]['video'] = $value->video;

					$v[$value->id]['thumbnail'] = $value->thumbnail;

					$v[$value->id]['uname'] = $value->uname;

					$v[$value->id]['stat'] = $value->stat;

					$v[$value->id]['datearticle'] = $value->datearticle;

					$v[$value->id]['cmnt'] = $cm->cmnt;

				}

				

			}

		} else {

			$v = array();

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



			'search' => true,

			'pagination' => $paging,

			'show' => $showing,



			'menu' => '$showMenu',

			'content' => 'contentblock',

			'active' => strtolower($this->uri->segment(1)),

			'sub' => strtolower($this->uri->segment(2)),

			'webtitle' => 'List of Content Blocked',



			'contents' => $v

		);



		$this->load->view('back/template/template',$data);

	}



	public function preview()

	{



		$this->session->set_userdata('referred_from', 'approval/waiting');



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



		if($this->uri->segment(2) == 'preview' && $this->uri->segment(3) != '') {

			$id = $this->uri->segment(3);



			$contents = $this->Article_Model->articleById($id);

			$idUser = $this->session->userdata('id_user');

			$avatar = $this->User_Model->avatarById($idUser);



			if(file_exists(getcwd().$avatar[0]->avatar_path)) {

				$ava = $avatar[0]->avatar_path;

			} else {

				$ava = getcwd().'/layout/img/NoAvatar.jpg';

			}



			$notifs = $this->User_Model->notifById($this->session->userdata('id_user'));



			$data = array(

				'notifications' => $notifs,

				'ava' => $ava,

				'sess' => $this->session->userdata(),



				'from' => $this->uri->segment(2),

				'e' => $this->input->get('e'),

				

				'menu' => '$showMenu',

				'content' => 'admpreview',

				'active' => strtolower($this->uri->segment(1)),

				'sub' => strtolower($this->uri->segment(2)),

				'webtitle' => 'Preview of '.$contents[0]->title,



				'id' => $contents[0]->id,

				'content_create' => $contents[0]->datearticle,

				'menu_sub' => $contents[0]->menu.' - '.$contents[0]->sub,

				'stat' => $contents[0]->stat,

				'contents' => $contents[0]->describ,

				'kind' => $contents[0]->kind,	

				'video' => $contents[0]->video	

			);



			$this->load->view('back/template/template',$data);

		} else {

			redirect('approval/waiting');

		}

	}



	public function unblock()

	{

		$this->session->set_userdata('referred_from', 'approval/waiting');



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



		if($this->uri->segment(2) == 'unblock' || $this->uri->segment(2) == 'publish' && $this->uri->segment(3) != '') {

			$id = $this->uri->segment(3);



			if($this->uri->segment(2) == 'unblock') {

				$for = 'unblockcontent';

				$subject = 'Your content has been unblock';

				$red = 'blocked';

				$stat = 'Your Article Blocked';

			} else {

				$for = 'publishcontent';

				$subject = 'Your content has been publish';

				$red = 'waiting';

				$stat = 'Your Article Published';

			}



			$contents = $this->Article_Model->articleById($id);

			foreach ($contents as $key => $value) {

				if(!empty($value->id)) {

					$update = $this->Article_Model->updateContentStatus($id, 1);

					if($update > 0) {

						if($value->kind == 1) {

							$kind = 'article';
							$frontKind = 'articles/';

						} else {

							$kind = 'video';
							$frontKind = 'videos/';

						}

						$url_notif = $kind.'/preview/'.$value->id;

						$notifInsert = $this->User_Model->insertNotif($value->idUser,$stat, $url_notif, 0, date('Y-m-d H:i:s'));

						if($notifInsert > 0) {



							// SEND EMAIL

							// UNBLOCK CONTENT

							$longUrlData = $this->User_Model->shortUrlByLongUrl(base_url().index_with().$frontKind.$value->link);

							if(!empty($longUrlData)) {
								$validUrl = $longUrlData[0]->url_short;
							} else {
								$validUrl = base_url().index_with().$frontKind.$value->link;
							}

							$emailMessage = $this->Email_Model->emailBody($for,$validUrl,ucwords($value->title));



							$sendingEmail = $this->Email_Model->sendmail($value->email,$subject,$emailMessage);



							if($sendingEmail == true) {

								redirect('approval/'.$red.'?okU');

							} else {

								redirect('approval/'.$red.'?emailFailed');

							}

							

						} else {

							redirect('approval/'.$red.'?notifFailed');

						}

					} else {

						redirect('approval/'.$red.'?noU');

					}

				} else {

					redirect('approval/'.$red.'?exU');

				}

			}



		} else {

			redirect('approval/'.$red.'');

		}

	}



	public function block()

	{

		$this->session->set_userdata('referred_from', 'approval/waiting');



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



		if($this->uri->segment(2) == 'block' && $this->uri->segment(3) != '') {

			$id = $this->uri->segment(3);



			$contents = $this->Article_Model->articleById($id);



			foreach ($contents as $key => $value) {

				if(!empty($value->id)) {

					$update = $this->Article_Model->updateContentStatus($id, 3);

					if($update > 0) {



						// SEND EMAIL

						// BLOCKED CONTENT

						redirect('approval/approved?okU');

					} else {

						redirect('approval/approved?noU');

					}

				} else {

					redirect('approval/approved?exU');

				}

			}



		} else {

			redirect('approval/approved');

		}

	}



	public function reject()

	{

		$this->session->set_userdata('referred_from', 'approval/waiting');



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

			if($this->input->post('submit') == 'sendreject') {



				if(empty($this->input->post('from')) || empty($this->input->post('reason')) || empty($this->input->post('reasonid'))) {



					if($this->input->post('from') == 'waiting') {

						redirect('approval/waiting?e=Fild can not be empty.');

					} elseif($this->input->post('from') == 'preview') {

						redirect('approval/preview/'.$this->input->post('reasonid').'?e=Fild can not be empty.');

					} else {

						redirect('approval/waiting?e=1');

					}



				} else {

					$page = $this->input->post('from');

					$reason = $this->input->post('reason');

					$idContent = $this->input->post('reasonid');



					$contents = $this->Article_Model->articleById($idContent);

					foreach ($contents as $key => $value) {



						$reject = $this->Article_Model->insertRejected($idContent, $reason, date('Y-m-d H:i:s'), 1);

						if($reject > 0) {

							$updateReject = $this->Article_Model->updateContentStatus($idContent, 2);

							if($updateReject > 0) {



								if($value->kind == 1) {

									$kind = 'article';

								} else {

									$kind = 'video';

								}

								$url_notif = $kind.'/preview/'.$value->id;

								$notifInsert = $this->User_Model->insertNotif($value->idUser,'Your Article Rejected', $url_notif, 0, date('Y-m-d H:i:s'));

								if($notifInsert > 0) {



									if($this->input->post('from') == 'waiting') {



										// SEND EMAIL

										// REJECTED CONTENT

										redirect('approval/waiting?e=Content has been rejected.');

									} elseif($this->input->post('from') == 'preview') {



										// SEND EMAIL

										// REJECTED CONTENT

										redirect('approval/preview/'.$idContent.'?e=Content has been rejected.');

									} else {

										redirect('approval/waiting?e=2');

									}

								} else {

									redirect('approval/waiting?e=Content failed rejected.');

								}

							} else {

								if($this->input->post('from') == 'waiting') {

									redirect('approval/waiting?e=Failed fetch reject content.');

								} elseif($this->input->post('from') == 'preview') {

									redirect('approval/preview/'.$idContent.'?e=Failed fetch reject content.');

								} else {

									redirect('approval/waiting?e=3');

								}

							}

						} else {

							if($this->input->post('from') == 'waiting') {

								redirect('approval/waiting?e=Failed reject content.');

							} elseif($this->input->post('from') == 'preview') {

								redirect('approval/preview/'.$idContent.'?e=Failed reject content.');

							} else {

								redirect('approval/waiting?e=4');

							}

						}

					}

				}

			}

		}

	}

}

