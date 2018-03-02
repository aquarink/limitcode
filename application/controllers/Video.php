<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Video extends CI_Controller { 



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

	}



	public function index()

	{

		$this->session->set_userdata('referred_from', 'video');



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		if(empty($this->session->userdata('id_user'))) {

			redirect('signin');

		}

	}



	public function newvideo()

	{

		$this->session->set_userdata('referred_from', 'video/new');



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





		if ($this->input->post()) {

			if($this->input->post('submit') == 'uploadvideo') {



				if(isset($_FILES["thumbnailarticle"]["name"])) {

					if(empty($_FILES["thumbnailarticle"]["name"])) {

						$thumb = $this->input->post('thumbnailarticleOri');

					} else {

						$thumb = $_FILES["thumbnailarticle"]["name"];

					}



					if(empty($thumb) || empty($this->input->post('idvid')) || empty($this->input->post('titlearticle')) || empty($this->input->post('article')) || $this->input->post('parentmenu') == '0' || $this->input->post('childmenu') == '0' || empty($this->input->post('filename')) || empty($this->input->post('fileoriname')) || empty($this->input->post('filemetaname'))) {



						$errors = 'Title, Thumbnail, Article, Parent Menu or Sub Menu may be empty';



					} else {

						$idUser = $this->session->userdata('id_user');

						$idnya = $this->input->post('idvid');

						$hidName = $this->input->post('filename');

						$nameSave = '/uploads/'.date('Y').'/'.date('F').'/videos/'.$hidName;

						$hidOri = $this->input->post('fileoriname');

						$hidMeta = $this->input->post('filemetaname');



						$title = $this->input->post('titlearticle');

						$article = $this->input->post('article');

						$parentMenu = $this->input->post('parentmenu');

						$childMenu = $this->input->post('childmenu');

						$the_tags = $this->input->post('tagscontent'); 



						$tagsParsing = str_replace(',', ', ', $the_tags);



						$cleanChar = str_replace(array('','!',' ',',','.','~','/',':','*','?','"','<','>','|',"'"),'-',$title);

						$content_link = strip_tags($cleanChar).'-'.date('Y-m-d-H-i-s');

						$nameRand = $content_link.'_'.rand(1,99999);						



						$type = $_FILES['thumbnailarticle']['type'];

						$expType = explode('/', $type);



						if($expType[1] == 'gif' || $expType[1] == 'jpg' || $expType[1] == 'png' || $expType[1] == 'jpeg') {

								//config

							$newName = $nameRand.'.'.$expType[1];



							$config['upload_path'] = './uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/';

							$config['allowed_types'] = 'gif|jpg|png|jpeg';					



							$newNameAfterResize = '/uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$nameRand.'_thumb.'.$expType[1];



							$config['file_name'] = $newName;



							$path = getcwd();



							if (!is_dir($path.'/uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'))

						    {

						        mkdir($path.'/uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/', 0777, true);

						    }



							$this->load->library('upload', $config);



							if (! $this->upload->do_upload('thumbnailarticle'))

							{

								$error = array('error' => $this->upload->display_errors());



								$errors = 'Thumbnail can not uploaded';

							}

							else

							{

								$data = array('upload_data' => $this->upload->data());



								$config['image_library'] = 'gd2';  

								$config['source_image'] = './uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$newName;  

								$config['create_thumb'] = TRUE;  

								$config['maintain_ratio'] = TRUE;  

								$config['quality'] = '60%';  

								$config['width'] = 265;  



								$this->load->library('image_lib', $config);  

								$this->image_lib->resize();



								if(unlink('./uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$newName)) {



									$updateArticle = $this->Article_Model->updateArticle($idnya, $idUser, $parentMenu, $childMenu, '2', $title, $article, $nameSave, $newNameAfterResize, $content_link, date('Y-m-d H:i:s'), 1, 1);



									if($updateArticle > 0) {



										if(!empty($the_tags) || $the_tags != '') {

											$cekLinkTag = $this->Article_Model->getTagByContentLink($content_link);

											if(count($cekLinkTag) > 0) {

												// UPDATE

												$updateTags = $this->Article_Model->updateTag($tagsParsing, $content_link);

											} else {

												// INSERT

												$insertTags = $this->Article_Model->insertTags($content_link, $tagsParsing, date('Y-m-d H:i:s'));

											}

										}



										redirect('video/preview/'.$idnya.'?true');



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

		}





		$menu = $this->Menu_Model->menuByStatus(1);



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



			'menu' => $menu,

			'content' => 'newvideo',

			'active' => strtolower($this->uri->segment(1)),

			'sub' => strtolower($this->uri->segment(2)),

			'webtitle' => 'Upload New Video',

			'modals' => $msgModals,



			'msg' => $errors

		);



		$this->load->view('back/template/template',$data);

	}



	public function listvideo()

	{

		$this->session->set_userdata('referred_from', 'video/list');



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		if(empty($this->session->userdata('id_user'))) {

			redirect('signin');

		}



		$videos = $this->Article_Model->articleByIdUserKind($this->session->userdata('id_user'),2);



		$v = array();



		// init params

        $params = array();

        $limit_per_page = 1;

        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

        $total_records = count($videos);

        $showing = "Showing data from ".$total_records." entries";

     

        if ($total_records > 0)

        {

            // get current page records

            $dataLimit = $this->Article_Model->articleByIdUserKindPagination($this->session->userdata('id_user'),2,$limit_per_page, $page * $limit_per_page);

                 

            $config['base_url'] = base_url() . index_with() . 'video/list';

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



		foreach ($dataLimit as $key => $value) {



			$comment = $this->Article_Model->articleCommentByIdUserKind($this->session->userdata('id_user'),$value->id);



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

				$v[$value->id]['describ'] = $value->describ;

			}

			

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

			'content' => 'listvideo',

			'active' => strtolower($this->uri->segment(1)),

			'sub' => strtolower($this->uri->segment(2)),

			'webtitle' => 'List of Videos',



			'videos' => $v

		);



		$this->load->view('back/template/template',$data);

	}



	public function preview()

	{

		$this->session->set_userdata('referred_from', 'video/preview');



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		if(empty($this->session->userdata('id_user'))) {

			redirect('signin');

		}



		if($this->uri->segment(2) == 'preview' && $this->uri->segment(3) != '') {

			$id = $this->uri->segment(3);



			$errors = '';



			if ($this->input->post()) {

				if($this->input->post('submit') == 'replybtn') {



					$ipaddress = '';

					if (isset($_SERVER['HTTP_CLIENT_IP'])) {

						$ipaddress = $_SERVER['HTTP_CLIENT_IP'];

					}

					else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {

						$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

					}

					else if(isset($_SERVER['HTTP_X_FORWARDED'])) {

						$ipaddress = $_SERVER['HTTP_X_FORWARDED'];

					}

					else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {

						$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

					}

					else if(isset($_SERVER['HTTP_FORWARDED'])) {

						$ipaddress = $_SERVER['HTTP_FORWARDED'];

					}

					else if(isset($_SERVER['REMOTE_ADDR'])) {

						$ipaddress = $_SERVER['REMOTE_ADDR'];

					}

					else {

						$ipaddress = 'UNKNOWN';

					}



					$reply = $this->input->post('reply');

					$iduser = $this->input->post('iduser');



					if(empty($this->input->post('reply')) || empty($this->input->post('iduser'))) {



						$errors = 'Comment reply can ot be empty';



					} else {

						$insertComments = $this->Article_Model->insertComment($id, $iduser, $reply, $ipaddress, date('Y-m-d H:i:s'));



						if($insertComments > 0) {

							redirect('video/preview/'.$id.'?true');

						} else {

							redirect('video/preview/'.$id.'?false');

						}

					}

				}

			}



			if(!empty($this->input->get('see'))) {

				$this->User_Model->updateStatusNotif($this->input->get('see'));

			}



			$contents = $this->Article_Model->articleByIdContentIdUser($id,$this->session->userdata('id_user'));

			foreach ($contents as $key => $value) {

				if(!empty($value->id)) {



					if($value->kind == 2) {

						$comments = $this->Article_Model->commentById($id);



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

							'content' => 'videopreview',

							'active' => strtolower($this->uri->segment(1)),

							'sub' => strtolower($this->uri->segment(2)),

							'webtitle' => 'Preview of '.$contents[0]->title,



							'errors' => $errors,



							'id' => $contents[0]->id,

							'content_create' => $contents[0]->datearticle,

							'menu_sub' => $contents[0]->menu.' - '.$contents[0]->sub,

							'stat' => $contents[0]->stat,

							'contents' => $contents[0]->describ,

							'kind' => $contents[0]->kind,	

							'video' => $contents[0]->video,

							'comments' => $comments

						);



						$this->load->view('back/template/template',$data);

					} else {

						redirect('article/list');

					}					

				} else {

					redirect('video/list');

				}

			}

		} else {

			// redirect('approval/waiting');

			print_r($this->uri->segment(3 ));

		}

	}



	public function edit()

	{

		$this->session->set_userdata('referred_from', 'video/edit');



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		if(empty($this->session->userdata('id_user'))) {

			redirect('signin');

		}



		if($this->uri->segment(2) == 'edit' && $this->uri->segment(3) != '') {

			$id = $this->uri->segment(3);

			$menu = $this->Menu_Model->menuByStatus(1);

			$subMenu = $this->Menu_Model->subMenuByStatus(1);



			if(isset($_GET['true'])) {

				$msgModals = 'true';

			} else {

				$msgModals = '';

			}



			$errors = '';		



			if ($this->input->post()) {

				if($this->input->post('submit') == 'uploadvideo') {



					if(empty($_FILES["thumbnailarticle"]["name"])) {

						$thumb = $this->input->post('thumbnailarticleOri');

					} else {

						$thumb = $_FILES["thumbnailarticle"]["name"];

					}



					if(empty($thumb) || empty($this->input->post('titlearticle')) || empty($this->input->post('article')) || $this->input->post('parentmenu') == '0' || $this->input->post('childmenu') == '0') {



						$errors = 'Title, Thumbnail, Article, Parent Menu or Sub Menu may be empty';



					} else {

						$title = $this->input->post('titlearticle');

						$article = $this->input->post('article');

						$parentMenu = $this->input->post('parentmenu');

						$childMenu = $this->input->post('childmenu');

						$the_tags = $this->input->post('tagscontent'); 



						$tagsParsing = str_replace(',', ', ', $the_tags);



						$cleanChar = str_replace(array('',' ','/',':','*','?','"','<','>','|'),'-',$title);

						$content_link = strip_tags($cleanChar).'-'.date('Y-m-d-H-i-s');

						$nameRand = $content_link.'_'.rand(1,99999);	



						if(empty($_FILES["thumbnailarticle"]["name"])) {

							$updateArticle = $this->Article_Model->updateVideo($id, $this->session->userdata('id_user'), $parentMenu, $childMenu, '2', $title, $article, $thumb, $content_link, date('Y-m-d H:i:s'), 1, 1);



							if($updateArticle > 0) {



								if(!empty($the_tags) || $the_tags != '') {

									$cekLinkTag = $this->Article_Model->getTagByContentLink($content_link);

									if(count($cekLinkTag) > 0) {

										// UPDATE

										$updateTags = $this->Article_Model->updateTag($tagsParsing, $content_link);

									} else {

										// INSERT

										$insertTags = $this->Article_Model->insertTags($content_link, $tagsParsing, date('Y-m-d H:i:s'));

									}

								}





								redirect('video/preview/'.$id.'?true');



							} else {

								$errors = 'ppppp';

							}

						} else {



							$type = $_FILES['thumbnailarticle']['type'];

							$expType = explode('/', $type);



							if($expType[1] == 'gif' || $expType[1] == 'jpg' || $expType[1] == 'png' || $expType[1] == 'jpeg') {

									//config

								$newName = $nameRand.'.'.$expType[1];



								$config['upload_path'] = './uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/';

								$config['allowed_types'] = 'gif|jpg|png|jpeg';					



								$newNameAfterResize = '/uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$nameRand.'_thumb.'.$expType[1];



								$config['file_name'] = $newName;



								$this->load->library('upload', $config);



								if (! $this->upload->do_upload('thumbnailarticle'))

								{

									$error = array('error' => $this->upload->display_errors());



									$errors = 'Thumbnail can not uploaded';

								}

								else

								{

									$data = array('upload_data' => $this->upload->data());



									$config['image_library'] = 'gd2';  

									$config['source_image'] = './uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$newName;  

									$config['create_thumb'] = TRUE;  

									$config['maintain_ratio'] = TRUE;  

									$config['quality'] = '60%';  

									$config['width'] = 265;  



									$this->load->library('image_lib', $config);  

									$this->image_lib->resize();



									if(unlink('./uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$newName)) {



										$updateArticle = $this->Article_Model->updateVideo($id, $this->session->userdata('id_user'), $parentMenu, $childMenu, '2', $title, $article, $newNameAfterResize, $content_link, date('Y-m-d H:i:s'), 1, 1);



										if($updateArticle > 0) {



											if(!empty($the_tags) || $the_tags != '') {

												$cekLinkTag = $this->Article_Model->getTagByContentLink($content_link);

												if(count($cekLinkTag) > 0) {

													// UPDATE

													$updateTags = $this->Article_Model->updateTag($tagsParsing, $content_link);

												} else {

													// INSERT

													$insertTags = $this->Article_Model->insertTags($content_link, $tagsParsing, date('Y-m-d H:i:s'));

												}

											}

											

											redirect('video/preview/'.$id.'?true');



										} else {

											$errors = 'Failed to save video';

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



					}

				} else {

					$errors = 'asasasa';

				}		

			}



			$contents = $this->Article_Model->articleById($id);

			foreach ($contents as $key => $value) {

				if(!empty($value->id)) {



					if($value->kind == 2) {

						$comments = $this->Article_Model->commentById($id);



						$idUser = $this->session->userdata('id_user');

						$avatar = $this->User_Model->avatarById($idUser);



						if(file_exists(getcwd().$avatar[0]->avatar_path)) {

							$ava = $avatar[0]->avatar_path;

						} else {

							$ava = getcwd().'/layout/img/NoAvatar.jpg';

						}



						$data = array(

							'ava' => $ava,

							'sess' => $this->session->userdata(),



							'menu' => $menu,

							'submenu' => $subMenu,

							'content' => 'editvideo',

							'active' => strtolower($this->uri->segment(1)),

							'sub' => strtolower($this->uri->segment(2)),

							'webtitle' => 'Edit Video of '.$contents[0]->title,

							'modals' => $msgModals,

							'article' => $contents,



							'errors' => $errors,



							'id' => $contents[0]->id,

							'content_create' => $contents[0]->datearticle,

							'menu_sub' => $contents[0]->menu.' - '.$contents[0]->sub,

							'stat' => $contents[0]->stat,

							'contents' => $contents[0]->describ,

							'kind' => $contents[0]->kind,	

							'video' => $contents[0]->video,

							'comments' => $comments

						);



						$this->load->view('back/template/template',$data);

					} else {

						redirect('article/list');

					}					

				} else {

					redirect('video/list');

				}

			}

		} else {

			// redirect('approval/waiting');

			print_r($this->uri->segment(3 ));

		}

	}



	public function fileupload()

	{

		error_reporting(E_ALL | E_STRICT);

		$this->load->library("UploadHandler");

	}



	public function insertvideo()

	{

		if ($this->input->post()) {

			if($this->input->post('submit') == 'videotemp') {

				$oriname = $this->input->post('oriname');

				$video = $this->input->post('video');



				$path = "/uploads/".date('Y')."/".date('F')."/videos/".$video;



				$id = $this->session->userdata('id_user');



				// INSERT

				$insertNewArticle = $this->Article_Model->insertNewArticle($id, '', '', '2', $oriname, $oriname, $path, '', '', date('Y-m-d H:i:s'), 0, 6);



				if($insertNewArticle > 0) {



					$comments = $this->Article_Model->articleByVideoPath($path);



					echo json_encode($comments[0]);



				}

			} 

		}

	}

}

