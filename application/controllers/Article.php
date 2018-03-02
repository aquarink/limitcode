<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller { 

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
		$this->load->helper('file');
		$this->load->helper('directory');

		$this->load->model('Menu_Model');
		$this->load->model('Article_Model');
		$this->load->model('User_Model');
	}

	public function index()
	{
		$brwoser = $_SERVER['HTTP_USER_AGENT'];

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

		$visitor = $this->User_Model->insertVisitor($ipaddress, $brwoser, date('Y-m-d H:i:s'));

		$this->load->view('landing');
	}

	public function submenu()
	{
		if ($this->input->post('vals') == 'getsubmenu') {
			$id = $this->input->post('id');
			$subMenu = $this->Menu_Model->subMenuByIdMenu($id);
			echo json_encode($subMenu);
		}
	}

	public function newarticle()
	{
		$this->session->set_userdata('referred_from', 'article/new'); 

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

		$randomPageId = date('YmdHis');

		$fileEdit = '';
		$fileExist = FALSE;
		$fileName = $this->uri->segment(3).'.txt';

		$drafDir = path_with().'uploads/drafs/'.$this->session->userdata('id_user').'/';

		 if (!is_readable($drafDir) || count(scandir($drafDir)) == 2) {
		 	
		 } else {
		 	$fileExist = TRUE;
		 	if(!empty($this->uri->segment(3))) {
			 	$filenya = $drafDir.$this->uri->segment(3).'.txt';
			 	if(file_exists($filenya)) {
			 		$fileEdit = read_file($filenya);
			 	} else {
			 		redirect('article/new');
			 	}			 	
		 	}
		}
		

		$errors = ''; 


		if ($this->input->post()) {
			if($this->input->post('submit') == 'createarticle') {

				if(isset($_FILES["thumbnailarticle"]["name"])) {

					if(empty($_FILES["thumbnailarticle"]["name"]) || empty($this->input->post('titlearticle')) || empty($this->input->post('article')) || $this->input->post('parentmenu') == '0' || $this->input->post('childmenu') == '0') {

						$errors = 'Title, Thumbnail, Article, Parent Menu or Sub Menu may be empty';

					} else {
						$type = $_FILES['thumbnailarticle']['type'];
						$expType = explode('/', $type);

						if($expType[1] == 'gif' || $expType[1] == 'jpg' || $expType[1] == 'png' || $expType[1] == 'jpeg') {
							//config
							$config['upload_path'] = './uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';

							$idUser = $this->session->userdata('id_user');

							$title = $this->input->post('titlearticle');
							$article = $this->input->post('article');
							$parentMenu = $this->input->post('parentmenu');
							$childMenu = $this->input->post('childmenu');
							$the_tags = $this->input->post('tagscontent');  

							$tagsParsing = str_replace(',', ', ', $the_tags);

							$cleanChar = str_replace(array('','!',' ',',','.','~','/',':','*','?','"','<','>','|',"'"),'-',$title);
							$content_link = strip_tags($cleanChar).'-'.date('Y-m-d-H-i-s');
							$nameRand = $content_link.'_'.rand(1,99999);
					
							$newName = $nameRand.'.'.$expType[1];

							$newNameAfterResize = '/uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$nameRand.'_thumb.'.$expType[1];

							$config['file_name'] = $newName;

							$path = path_with();

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
								// $config['quality'] = '60%';  
								$config['width'] = 750;  

								$this->load->library('image_lib', $config);  
								$this->image_lib->resize();

								if(unlink('./uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$newName)) {

									$insertNewArticle = $this->Article_Model->insertNewArticle($idUser, $parentMenu, $childMenu, '1', $title, $article, '', $newNameAfterResize, $content_link, date('Y-m-d H:i:s'), 0, 0);

									if($insertNewArticle > 0) {

										if(!empty($the_tags) || $the_tags != '') {
											$insertTags = $this->Article_Model->insertTags($content_link, $tagsParsing, date('Y-m-d H:i:s'));
										}

										$longUrl = base_url().index_with().'articles/'.$content_link;

										$this->generateShortURL($longUrl);

										// DELETE FILE DRAF
										$delFile = path_with().'uploads/drafs/'.$this->session->userdata('id_user').'/'.$this->input->post('filenameTxt').'.txt';

										unlink($delFile);

										redirect('article/new?true');

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
			if(file_exists(path_with().$avatar[0]->avatar_path)) {
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
			'content' => 'newarticle',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'Create New Article',
			'modals' => $msgModals,

			'draf' => $fileEdit,
			'filename' => $fileName,
			'fileexist' => $fileExist,
			'randompageid' => $randomPageId,

			'msg' => $errors
		);

		// $this->load->view('back/template/template',$data);
		$this->load->view('back/admin/newarticle',$data);
	}

	public function edit()
	{
		$this->session->set_userdata('referred_from', 'article');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		if(isset($_GET['true'])) {
			$msgModals = 'true';
		} else {
			$msgModals = '';
		}

		$errors = '';

		if($this->uri->segment(2) == 'edit' && $this->uri->segment(3) != '') {

			$id = $this->uri->segment(3);
			$idUser = $this->session->userdata('id_user');

			//

			if ($this->input->post()) {
				if($this->input->post('submit') == 'updatearticle') {

					if(isset($_FILES["thumbnailarticle"]["name"])) {
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

							$newTitle1 = strtolower(str_replace('.', ' ', $title));
							$newTitle2 = strtolower(str_replace(',', ' ', $newTitle1));
							$newTitle4 = strtolower(str_replace(':', ' ', $newTitle2));
							$newTitle5 = strtolower(str_replace(' ', '-', $newTitle4));

							$link = strip_tags($newTitle5).'-'.date('Y-m-d-H-i-s');
							$cleanChar = str_replace(array('','!',' ',',','.','~','/',':','*','?','"','<','>','|',"'"),'-',$title);
							$nameRand = $content_link.'_'.rand(1,99999);	

							if(empty($_FILES["thumbnailarticle"]["name"])) {
								$updateArticle = $this->Article_Model->updateArticle($id, $idUser, $parentMenu, $childMenu, '1', $title, $article, '', $thumb, $content_link, date('Y-m-d H:i:s'), 1, 0);

								if($updateArticle > 0) {

									$rejectMessage = $this->Article_Model->rejectByIdContent($id);

									$idReject = $rejectMessage[0]->id_reject;

									$updateReject = $this->Article_Model->updateRejectByStatus($idReject, 0);

									if($updateReject > 0) {

										redirect('article/preview/'.$id.'?true');
									}

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

									$path = path_with();

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
										// $config['quality'] = '60%';  
										$config['width'] = 750;  

										$this->load->library('image_lib', $config);  
										$this->image_lib->resize();

										if(unlink('./uploads/'.date('Y').'/'.date('F').'/thumbnails/article_thumbnail/'.$newName)) {

											$updateArticle = $this->Article_Model->updateArticle($id, '1', $parentMenu, $childMenu, '1', $title, $article, '', $newNameAfterResize, $content_link, date('Y-m-d H:i:s'), 1, 0);

											if($updateArticle > 0) {

												$rejectMessage = $this->Article_Model->rejectByIdContent($id);

												$idReject = $rejectMessage[0]->id_reject;

												$updateReject = $this->Article_Model->updateRejectByStatus($idReject, 0);

												if($updateReject > 0) {

													redirect('article/preview/'.$id.'?true');
												}

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
						$errors = 'Title, Thumbnail, Article, Parent Menu or Sub Menu may be empty';
					}

				}		
			}

			//

			$contents = $this->Article_Model->articleById($id);
			$rjct = $this->Article_Model->rejectByIdContent($id);

			foreach ($contents as $key => $value) {
				if(!empty($value->id)) {
					$menu = $this->Menu_Model->menuByStatus(1);
					$subMenu = $this->Menu_Model->subMenuByStatus(1);

					$idUser = $this->session->userdata('id_user');
					$avatar = $this->User_Model->avatarById($idUser);

					if(file_exists(path_with().$avatar[0]->avatar_path)) {
						$ava = $avatar[0]->avatar_path;
					} else {
						$ava = path_with().'/layout/img/NoAvatar.jpg';
					}

					$data = array(
						'ava' => $ava,
						'sess' => $this->session->userdata(),

						'reject' => $rjct,

						'menu' => $menu,
						'submenu' => $subMenu,
						'content' => 'editarticle',
						'active' => strtolower($this->uri->segment(1)),
						'sub' => strtolower($this->uri->segment(2)),
						'webtitle' => 'Edit Article '.$contents[0]->title ,
						'modals' => $msgModals,

						'msg' => $errors,
						'article' => $contents
					);

					$this->load->view('back/admin/editarticle',$data);
				} else {
					redirect('article/list');
				}
			}
		} else {
			redirect('article/list');
		}
	}

	public function listarticle()
	{
		$this->session->set_userdata('referred_from', 'article');

		$get_lang = $this->session->userdata('language');
		if($get_lang == 'bahasa') {
			$this->lang->load('bahasa_lang', 'bahasa');
		} else {
			$this->lang->load('english_lang', 'bahasa');
		}

		$articles = $this->Article_Model->articleByIdUserKind($this->session->userdata('id_user'),1);

		// init params
        $params = array();
        $limit_per_page = 10;
        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
        $total_records = count($articles);
        $showing = "Showing data from ".$total_records." entries";


        $drafDir = path_with().'uploads/drafs/'.$this->session->userdata('id_user').'/';
        $mapDir = directory_map($drafDir);
     
        if ($total_records > 0)
        {
            // get current page records
            // $dataLimit = $this->Banner_Model->bannerPagination(1, $limit_per_page, $page * $limit_per_page);
            $dataLimit = $this->Article_Model->articleByIdUserKindPagination($this->session->userdata('id_user'),1,$limit_per_page, $page * $limit_per_page);
                 
            $config['base_url'] = base_url() . index_with() . 'article/list';
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

				$comment = $this->Article_Model->articleCommentByIdUserKind($this->session->userdata('id_user'),$value->id);

				foreach ($comment as $k => $cm) {

					if($value->kind == 1) {
						$k = 'articles/';
					} else {
						$k = 'videos/';
					}

					$long = base_url().index_with().$k.$value->link;
					$shortUrl = $this->User_Model->shortUrlByLongUrl($long);

					if(!empty($shortUrl)) {
						foreach($shortUrl as $lnk) {

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

							$v[$value->id]['link'] = $lnk->url_short;
						}
					} else {
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

						$v[$value->id]['link'] = base_url().index_with().$k.$value->link;
					}
				}

			}
		} else {
			$v = array();
		}

		$idUser = $this->session->userdata('id_user');
		$avatar = $this->User_Model->avatarById($idUser);

		if(!empty($avatar)) {
			if(file_exists(path_with().$avatar[0]->avatar_path)) {
				$ava = $avatar[0]->avatar_path;
			} else {
				$ava = '/layout/img/NoAvatar.jpg';
			}
		} else {
			$ava = '/layout/img/NoAvatar.jpg';
		}

		$notifs = $this->User_Model->notifById($this->session->userdata('id_user'));

		if(empty($mapDir)) {
			$mDir = array();
		} else {
			$mDir = $mapDir;
		}

		$data = array(
			'notifications' => $notifs,
			'ava' => $ava,
			'sess' => $this->session->userdata(),

			'forderMap' => $mDir,

			'search' => true,

			'pagination' => $paging,
			'show' => $showing,

			'menu' => '$showMenu',
			'content' => 'listarticle',
			'active' => strtolower($this->uri->segment(1)),
			'sub' => strtolower($this->uri->segment(2)),
			'webtitle' => 'List of Article',

			'articles' => $v
		);

		$this->load->view('back/template/template',$data);
	}

	public function uploadimage()
	{ 
		if(!empty($_FILES["image"]["name"])) {
			$type = $_FILES['image']['type'];
			$expType = explode('/', $type);

			if($expType[1] == 'gif' || $expType[1] == 'jpg' || $expType[1] == 'png' || $expType[1] == 'jpeg') {
				//config
				$newName = date('YmdHis').'_limitcode_article_image';
				
				$config['upload_path'] = './uploads/'.date('Y').'/'.date('F').'/article_images/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';					

				$newNameAfterResize = '/uploads/'.date('Y').'/'.date('F').'/article_images/'.$newName.'_thumb.'.$expType[1];

				$config['file_name'] = $newName.'.'.$expType[1];

				$path = path_with();

				if (!is_dir($path.'/uploads/'.date('Y').'/'.date('F').'/article_images/'))
			    {
			        mkdir($path.'/uploads/'.date('Y').'/'.date('F').'/article_images/', 0777, true);
			    }

				$this->load->library('upload', $config);

				if (! $this->upload->do_upload('image'))
				{
					$error = array('error' => $this->upload->display_errors());

					$errors = 'Thumbnail can not uploaded';
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());

					$config['image_library'] = 'gd2';  
					$config['source_image'] = './uploads/'.date('Y').'/'.date('F').'/article_images/'.$newName.'.'.$expType[1];  
					$config['create_thumb'] = TRUE;  
					$config['maintain_ratio'] = TRUE;  
					// $config['quality'] = '60%';  
					$config['width'] = 750;  

					$this->load->library('image_lib', $config);  
					$this->image_lib->resize();

					if(unlink('./uploads/'.date('Y').'/'.date('F').'/article_images/'.$newName.'.'.$expType[1])) {

						$data = getimagesize(path_with().$newNameAfterResize);
						$data = array(
			                'width'=> $data[0],
			                'height'=>$data[1],
			                'file_name'=>$this->upload->data('file_name')
			            );

						$res = array("data" => array(
				                'link' => base_url().$newNameAfterResize,
				                'width' => $data['width'],
				                'height' => $data['height'])
				            );
				        echo json_encode($res);
						
					} else {
						$res = array("data" => array('error' => 'failed create thumbnail'));
        				echo json_encode($res);
					}
				}
			} else {
				$res = array("data" => array('error' => 'image format invalid'));
        		echo json_encode($res);
			}
		}
	}

	public function uploadvideo()
	{
		if ($this->input->post()) {
			
			$type = $_FILES['video_param']['type'];
			$tmp_name = $_FILES['video_param']['tmp_name'];

			$expType = explode('/', $type);

			$newName = date('YmdHis').'_limitcode_article_video.'.$expType[1];

			$path = path_with();

			if (!is_dir($path.'/uploads/'.date('Y').'/'.date('F').'/article_video/'))
		    {
		        mkdir($path.'/uploads/'.date('Y').'/'.date('F').'/article_video/', 0777, true);
		    }

			if(move_uploaded_file($tmp_name, 'uploads/article_video/'.$newName)) {
				$urlPath = base_url().'uploads/article_video/'.$newName;
				$imageLink = array('link' => $urlPath);
			} else {
				$imageLink = array('link' => 'error');
			}

			echo json_encode($imageLink);

		} else {
			print_r($this->input->get());
		}
	}

	public function preview()
	{
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
					$idUser = $this->session->userdata('id_user');

					if(empty($this->input->post('reply'))) {

						$errors = 'Comment reply can ot be empty';

					} else {
						$insertComments = $this->Article_Model->insertComment($id, $idUser, $reply, $ipaddress, date('Y-m-d H:i:s'));

						if($insertComments > 0) {

							$articleByIdData = $this->Article_Model->articleById($id);

							foreach($articleByIdData as $dataById) {
								$url_notif = 'article/preview/'.$id;
								$notifInsert = $this->User_Model->insertNotif($idUser,'Someone Comment', $url_notif, 0, date('Y-m-d H:i:s'));
								if($notifInsert > 0) {
									redirect('article/preview/'.$id.'?true');
								} else {
									redirect('article/preview/'.$id.'?notifFailed');
								}
							}
						} else {
							redirect('article/preview/'.$id.'?false');
						}
					}
				}
			}

			if(!empty($this->input->get('see'))) {
				$this->User_Model->updateStatusNotif($this->input->get('see'));
			}

			
			$rejectMessage = $this->Article_Model->rejectByIdContent($id);
			$contents = $this->Article_Model->articleByIdContentIdUser($id,$this->session->userdata('id_user'));

			foreach ($contents as $key => $value) {
				if(!empty($value->id)) {
					if($value->kind == 1) {

						$comments = $this->Article_Model->commentById($id);

						$idUser = $this->session->userdata('id_user');
						$avatar = $this->User_Model->avatarById($idUser);

						if(!empty($avatar)) {
							if(file_exists($avatar[0]->avatar_path)) {
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

							'reject' => $rejectMessage,
							
							'menu' => '$showMenu',
							'content' => 'preview',
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
						redirect('video/list');
					}
				} else {
					redirect('article/list');
				}
			}
			
		} else {
			redirect('article/list');
		}
	}

	public function impressview()
	{
		if ($this->input->post()) {
			if($this->input->post('action') == 'view') {

				$id_content = $this->input->post('articleid');
				$ip_client = $this->input->post('client');
				$watch_datetime = date('Y-m-d H:i:s');
				
				$insertView = $this->Article_Model->insertView($id_content, $ip_client, $watch_datetime);
				if($insertView > 0) { 

				} else {
					echo "somethink wrong";
				}
			} else {
				echo "access forbidden";
			}
		} else {
			echo "access forbidden";
		}
	}

	public function impressbounce()
	{
		if ($this->input->post()) {
			if($this->input->post('action') == 'bounce') {

				$random_page_id = $this->input->post('pageid');
				$id_content = $this->input->post('articleid');
				$ip_client = $this->input->post('client');
				$id_user = $this->input->post('user');
				$bounce_datetime = date('Y-m-d H:i:s');

				//check data 
				$check = $this->Article_Model->getBounceBy($random_page_id, $id_content, $ip_client);

				if(count($check) > 0) {
					//Update
					$bounce = $check[0]->bounce_sc + 10;
					$updateBounce = $this->Article_Model->updateBounce($random_page_id, $id_content, $ip_client, $bounce);
					if($updateBounce > 0) {

					} else {
						echo "somethink wrong update bounce";
					}
				} else {
					//Insert
					$insertBounce = $this->Article_Model->insertBounce($random_page_id, $id_content, $ip_client,$id_user, $bounce_datetime, $bounce_sc);
					if($insertBounce > 0) {

					} else {
						echo "somethink wrong insert bounce";
					}
				}
			} else {
				echo "access forbidden";
			}
		} else {
			echo "access forbidden";
		}
	}

	public function redirecturl()
	{
		if($this->uri->segment(1) == 'u' && !empty($this->input->get('r'))) {

			$url = $this->input->get('r');

			echo "Do you want to leave ".base_url()." for visit <a href=".$url.">this link</a>";

		} else {
			echo $this->uri->segment(1);
		}
	}

	// GENERATE CODE
	public function generateShortURL($longUrl) {

		$longData = $this->User_Model->shortUrlByLongUrl($longUrl);

		$shortData = $this->User_Model->shortUrlByShortUrl($longUrl);

		if(empty($longData)) {

			if(empty($shortData)) {

				do {
					// GET CAPTCHA
					$captcha = "";
					for($i=0; $i < 6; $i++){
						$x = mt_rand(0, 2);
						switch($x){
							case 0: $captcha.= chr(mt_rand(97,122));break;
							case 1: $captcha.= chr(mt_rand(65,90));break;
							case 2: $captcha.= chr(mt_rand(48,57));break;
						}
					}

					//CHECK CODE
					$shortDataByCode = $this->User_Model->shortUrlByCode($captcha);

					if(empty($shortDataByCode)) {
						$code_url = $captcha;
						$short_url = base_url().index_with().'r/'.$captcha;

						$insertShorUrl = $this->User_Model->insertShortUrl($code_url, $short_url, $longUrl);

						if($insertShorUrl > 0) {
							$shortJson = array('error' => 0,'shotrurl' => $short_url);
						} else {
							$shortJson = array('error' => 1);
						}

						return $shortJson;
					}
				} while (!empty($shortDataByCode));
			} else {
				return array('error' => 0,'shotrurl' => $shortData[0]->url_short);
			}

		} else {
			return array('error' => 0,'shotrurl' => $longData[0]->url_short);
		}
	}

	public function autosave()
    {
    	if ($this->input->post()) {

			if(!empty($this->input->post('rand')) && !empty($this->input->post('id')) && !empty($this->input->post('vals'))) {

				$random_page_id = $this->input->post('rand');
				$id_user = $this->input->post('id');
				$textarea = $this->input->post('vals');

				$drafDir = path_with().'/uploads/drafs/'.$id_user.'/';
				if (!is_dir($drafDir))
			    {
			        mkdir($drafDir, 0777, true);
			    }

			    if (write_file($drafDir.$random_page_id.'.txt', $textarea))
			    {
		         	$input = array('randomid' => $random_page_id, 'iduser' => $id_user, 'content' => $textarea);

		         	echo json_encode($input);
			    }
			} else {
				print_r($this->input->post());
			}
		} else {
			echo "string";
		}
    }

    public function deleteDraf()
    {
    	if($this->uri->segment(2) == 'deldraf' && !empty($this->uri->segment(3))) {
    		$filename = $this->uri->segment(3).'.txt';
			$filePath = path_with().'uploads/drafs/'.$this->session->userdata('id_user').'/'.$filename;

			if(file_exists($filePath)) {
			 	if(unlink($filePath)) {
			 		redirect('article/list?ulOk');
			 	} else {
			 		redirect('article/list?ulNo');
			 	}
		 	} else {
		 		redirect('article/list');
		 	}
		} else {
			redirect('article/list');
		}
    }
}
