<?php

defined('BASEPATH') OR exit('No direct script access allowed'); 



class Front extends CI_Controller { 



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

		$this->load->library('user_agent');



		$this->load->model('Article_Model'); 

		$this->load->model('Menu_Model'); 

		$this->load->model('Email_Model');

		$this->load->model('User_Model'); 

		$this->load->model('Banner_Model'); 

	}



	public function index()

	{

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		$showMenu = array();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}



		$articleByStatus = $this->Article_Model->articleByStatus(1);



		$meta = array(

			'author' => 'Limit Code Inc.',

			'description' => 'Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',

			'keywords' => 'Limit Code, Limit, Code, Sebuah Media, Media, Berbagi, Tulisan, Artikel, Article, Writer, Share, Video, Photo, Image, Audio, mp4, mp3',

			'articleAuthor' => 'Limit Code Landing Page',

			'articlePublisher' => 'Limit Code',

			'ogType' => 'article',

			'ogUrl' => base_url().index_with().'home',

			'ogTitle' => 'Limit Code Home | Welcome | Selamat Datang',

			'ogDescription' => 'Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',

			'ogImage' => base_url().'/layout/img/lc-welcome.jpg',			

			'ogImageSecureUrl' => base_url().'layout/img/lc-welcome.jpg',		

			'ogImageAlt' => 'Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar'		

		);



		$submenuCount = $this->Menu_Model->subMenuCount();



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



		$contenttoptoday = $this->Article_Model->contentBySeenToday();

		if (count($contenttoptoday) == 0) {

			$topcontents = $this->Article_Model->contentBySeenWeek();

		} else{

			$topcontents = $contenttoptoday;

		}



		 

		if (count($this->Article_Model->contentTopComment()) < 4) {

			$topcomments = $this->Article_Model->contentTopCommentWeek();

		} else{

			$topcomments = $this->Article_Model->contentTopComment();

		}



		$lastcomments = $this->Article_Model->lastComment();



		$lastvideos = $this->Article_Model->lastVideo();

		$recentContentBig = $this->Article_Model->articleByStatusLimit(1,4);
		$recentContent = $this->Article_Model->articleByStatusLimit(1,5);
		$popularContent = $this->Article_Model->articleByWatchStatusLimit(1,5);
		$reviewContent = $this->Article_Model->commentReview(1,5);
		$lastArticles = $this->Article_Model->lastArticleByKindStatus(1,1,16);
		$lastVideos = $this->Article_Model->lastArticleByKindStatus(2,1,9);

		$ads = $this->Banner_Model->bannerByStatus(1);

		$data = array(
			'advert' => $ads,
			'recentContent' => $recentContent,
			'recentContentBig' => $recentContentBig,
			'popularContent' => $popularContent,
			'reviewContent' => $reviewContent,
			
			'lastArticles' => $lastArticles,
			'lastVideos' => $lastVideos,


			'notifications' => $notifs,
			'ava' => $ava,
			'menus' => $showMenu,
			'submenu' => $submenuCount,
			'pages' => 'landing',
			'webtitle' => 'Selamat Datang | Limit Code',
			'meta'=> $meta,
			'contents' => $articleByStatus,
			'topcontents' => $topcontents,
			'topcomments' => $topcomments,
			'lastcomments' => $lastcomments,
			'lastvideos' => $lastvideos,
			'sessionData' => $this->session->userdata()
		);

		// if ( ! $landing_data_stored = $this->cache->get('landing_data_stored'))
		// 	{

		// 	$data = array(
		// 		'recentContent' => $recentContent,
		// 		'recentContentBig' => $recentContentBig,
		// 		'popularContent' => $popularContent,
		// 		'reviewContent' => $reviewContent,
				
		// 		'lastArticles' => $lastArticles,
		// 		'lastVideos' => $lastVideos,


		// 		'notifications' => $notifs,
		// 		'ava' => $ava,
		// 		'menus' => $showMenu,
		// 		'submenu' => $submenuCount,
		// 		'pages' => 'landing',
		// 		'webtitle' => 'Selamat Datang | Limit Code',
		// 		'meta'=> $meta,
		// 		'contents' => $articleByStatus,
		// 		'topcontents' => $topcontents,
		// 		'topcomments' => $topcomments,
		// 		'lastcomments' => $lastcomments,
		// 		'lastvideos' => $lastvideos,
		// 		'lastarticles' => $lastarticles
		// 	);

		// 	$this->cache->save('landing_data_stored', $data, 120);

  // 			$landing_data_stored = $data;

		// }



		$this->load->view('front/template/template',$data);

	}



	public function contentMenu()

	{

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}



		$getMenuName = $this->uri->segment(2);

		$menuNameRep = str_replace('-', ' ', $getMenuName);

		$menuForTitle = ucwords($menuNameRep); 



		$submenuCount = $this->Menu_Model->subMenuCount();

		$idUser = $this->session->userdata('id_user');

		$avatar = $this->User_Model->avatarById($idUser);



		$contents = $this->Article_Model->articleByMenu($getMenuName,1);



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



		// init params

        $params = array();

        $limit_per_page = 8 * 2;

        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

        $total_records = count($contents);

        $showing = "Showing data from ".$total_records." entries";

     

        if ($total_records > 0)

        {

            // get current page records

            $dataLimit = $this->Article_Model->articleByMenuPagination($getMenuName,1,$limit_per_page, $page * $limit_per_page);

                 

            $config['base_url'] = base_url() . index_with() . 'q/'.$getMenuName;

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



        $meta = array(

			'author' => $menuForTitle.' Limit Code Inc.',

			'description' => $menuForTitle.' Limit Code Inc. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',

			'keywords' => $menuForTitle.' Limit Code, Limit, Code, Sebuah Media, Media, Berbagi, Tulisan, Artikel, Article, Writer, Share, Video, Photo, Image, Audio, mp4, mp3',

			'articleAuthor' => 'Limit Code '.$menuForTitle.' Page',

			'articlePublisher' => $menuForTitle. ' Limit Code',

			'ogType' => 'article',

			'ogUrl' => base_url().index_with().$menuForTitle,

			'ogTitle' => $menuForTitle. ' Limit Code Home | '.$menuForTitle.' | Selamat Datang',

			'ogDescription' => $menuForTitle.' Limit Code Inc. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',

			'ogImage' => base_url().'/layout/img/lc-welcome.jpg',			

			'ogImageSecureUrl' => base_url().'layout/img/lc-welcome.jpg',		

			'ogImageAlt' => $menuForTitle.' Limit Code Inc. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar'		

		);



		$ads = $this->Banner_Model->bannerByStatus(1);

		$data = array(
			'advert' => $ads,

			'notifications' => $notifs,

			'ava' => $ava,

			'menus' => $showMenu,

			'submenu' => $submenuCount,

			'pages' => 'listbymenu',

			'webtitle' => $menuForTitle.' | Limit Code',

			'meta'=> $meta,

			'detailtitle' => $menuForTitle,



			'contents' => $dataLimit,

			'pagination' => $paging,

			'showing' => $showing,
			'sessionData' => $this->session->userdata()

		);



		$this->load->view('front/template/template',$data);

	}



	public function contentMenuSub()

	{

		// $menu = $this->Menu_Model->menuByStatus(1);

		// $submenu = $this->Menu_Model->subMenuByStatus(1);



		// foreach ($menu as $key => $value) {

		// 	$showMenu[$value->menu_name]['url'] = $value->menu_url;



		// 	foreach ($submenu as $keysub => $valuesub) {

		// 		if($value->id_menu == $valuesub->id_menu) {

		// 			$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;

		// 		}

		// 	}

		// }

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}



		$getMenuName = $this->uri->segment(2);

		$menuNameRep = str_replace('-', ' ', $getMenuName);

		$menuForTitle = ucwords($menuNameRep); 



		$getSubMenuName = $this->uri->segment(3);

		$subMenuNameRep = str_replace('-', ' ', $getSubMenuName);

		$subMenuForTitle = ucwords($subMenuNameRep);



		$submenuCount = $this->Menu_Model->subMenuCount();

		$idUser = $this->session->userdata('id_user');

		$avatar = $this->User_Model->avatarById($idUser);



		$contents = $this->Article_Model->articleByMenuSub($getMenuName,$getSubMenuName,1);



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



		// init params

        $params = array();

        $limit_per_page = 8 * 2;

        $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;

        $total_records = count($contents);

        $showing = "Showing data from ".$total_records." entries";

     

        if ($total_records > 0)

        {

            // get current page records

            $dataLimit = $this->Article_Model->articleByMenuSubPagination($getMenuName,$getSubMenuName,1,$limit_per_page, $page * $limit_per_page);

                 

            $config['base_url'] = base_url() . index_with() . 'q/'.$getMenuName.'/'.$getSubMenuName;

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



        $meta = array(

			'author' => $menuForTitle.' - '.$subMenuForTitle.' Limit Code Inc.',

			'description' => $menuForTitle.' - '.$subMenuForTitle.' Limit Code Inc. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',

			'keywords' => $menuForTitle.' - '.$subMenuForTitle.' Limit Code, Limit, Code, Sebuah Media, Media, Berbagi, Tulisan, Artikel, Article, Writer, Share, Video, Photo, Image, Audio, mp4, mp3',

			'articleAuthor' => 'Limit Code '.$menuForTitle.' - '.$subMenuForTitle.' Page',

			'articlePublisher' => $menuForTitle.' - '.$subMenuForTitle. ' Limit Code',

			'ogType' => 'article',

			'ogUrl' => base_url().index_with().$menuForTitle.' - '.$subMenuForTitle,

			'ogTitle' => $menuForTitle.' - '.$subMenuForTitle. ' Limit Code Home | '.$menuForTitle.' - '.$subMenuForTitle.' | Selamat Datang',

			'ogDescription' => $menuForTitle.' Limit Code Inc. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',

			'ogImage' => base_url().'/layout/img/lc-welcome.jpg',			

			'ogImageSecureUrl' => base_url().'layout/img/lc-welcome.jpg',		

			'ogImageAlt' => $menuForTitle.' - '.$subMenuForTitle.' Limit Code Inc. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar'		

		);



		$ads = $this->Banner_Model->bannerByStatus(1);

		$data = array(
			'advert' => $ads,

			'notifications' => $notifs,

			'ava' => $ava,

			'menus' => $showMenu,

			'submenu' => $submenuCount,

			'pages' => 'listbymenusub',

			'webtitle' => $menuForTitle.' | '.$subMenuForTitle.' | Limit Code',

			'meta' => $meta,

			'detailtitle' => $menuForTitle.' - '.$subMenuForTitle,



			'contents' => $dataLimit,

			'pagination' => $paging,

			'showing' => $showing,
			'sessionData' => $this->session->userdata()

		);



		$this->load->view('front/template/template',$data);

	}



	public function contentUser()

	{

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}





		$userID = $this->uri->segment(2);

		$contents = $this->Article_Model->articleByIdUser($userID,1);



		$menuForTitle = 'List Contents of '. ucwords($contents[0]->uname); 



		$submenuCount = $this->Menu_Model->subMenuCount();

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



		// init params

        $params = array();

        $limit_per_page = 8 * 2;

        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

        $total_records = count($contents);

        $showing = "Showing data from ".$total_records." entries";

     

        if ($total_records > 0)

        {

            // get current page records

            $dataLimit = $this->Article_Model->articleByIdUserPagination($userID,1,$limit_per_page, $page * $limit_per_page);

                 

            $config['base_url'] = base_url() . index_with() . 'user/'.$userID;

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



		$ads = $this->Banner_Model->bannerByStatus(1);

		$data = array(
			'advert' => $ads,

			'notifications' => $notifs,

			'ava' => $ava,

			'menus' => $showMenu,

			'submenu' => $submenuCount,

			'pages' => 'listbyuser',

			'webtitle' => $menuForTitle.' | Limit Code',

			'detailtitle' => $menuForTitle,



			'contents' => $dataLimit,

			'pagination' => $paging,

			'showing' => $showing,
			'sessionData' => $this->session->userdata()

		);



		$this->load->view('front/template/template',$data);

	}



	public function contentTag()

	{

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}







		$keyword = $this->uri->segment(2);

		$contents = $this->Article_Model->articleByTags(rawurldecode($keyword),1);



		if(empty($contents)) {

			redirect('home');

		}



		$menuForTitle = 'List Contents of '. ucwords($contents[0]->uname); 



		$submenuCount = $this->Menu_Model->subMenuCount();

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



		// init params

        $params = array();

        $limit_per_page = 1 * 2;

        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;

        $total_records = count($contents);

        $showing = "Showing data from ".$total_records." entries";

     

        if ($total_records > 0)

        {

            // get current page records

            $dataLimit = $this->Article_Model->articleByTagPagination(rawurldecode($keyword),1,$limit_per_page, $page * $limit_per_page);

                 

            $config['base_url'] = base_url() . index_with() . 'tag/'.$keyword;

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



		$ads = $this->Banner_Model->bannerByStatus(1);

		$data = array(
			'advert' => $ads,

			'notifications' => $notifs,

			'ava' => $ava,

			'menus' => $showMenu,

			'submenu' => $submenuCount,

			'pages' => 'listbytag',

			'webtitle' => $menuForTitle.' | Limit Code',

			'detailtitle' => $menuForTitle,



			'contents' => $dataLimit,

			'pagination' => $paging,

			'showing' => $showing,
			'sessionData' => $this->session->userdata()

		);



		$this->load->view('front/template/template',$data);

	}



	public function contentDetail()

	{

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}

		$articleByStatus = $this->Article_Model->articleByStatus(1);



		$singleContent = $this->Article_Model->articleByUrl($this->uri->segment(2)); 

		$idUser = $this->session->userdata('id_user');

		$tagContent = $this->Article_Model->getTagByContentLink($this->uri->segment(2));

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


		if ($this->input->post()) {

			if($this->input->post('sendComment') == 'sending') {
				$idContent = $singleContent[0]->id;
				$comment = $this->input->post('comment');

				$insComment = $this->Article_Model->insertComment($idContent, $idUser, $comment, $ipaddress, date('Y-m-d H:i:s'));
				if($insComment > 0) {
					header("Refresh:0");
				}
			}
		}



		if(!empty($tagContent[0]->the_tags)) {

			$tags = $tagContent[0]->the_tags;

		} else {

			$generateTag = str_replace(' ', ',', $singleContent[0]->title);

			$tags = $singleContent[0]->title.','.$generateTag;

		}



		$tagsExp = explode(',', $tags);
		$tagsLike = join('|',$tagsExp);

		$tagsReGEXP = $this->Article_Model->articleByTagsREGEXP($tagsLike);


		if($singleContent[0]->id != 0) {

			if($singleContent[0]->stat == 1) {

				// Publish

				if($this->uri->segment(1) == 'articles') {

					$kindProof = 1;

				} else {

					$kindProof = 2;

				}



				if($kindProof != $singleContent[0]->kind) {

					redirect('home');

				}



				if($singleContent[0]->kind == 1) {

					$kind = 'article';

				} else {

					$kind = 'video';

				}

				$meta = array(

					'author' => $singleContent[0]->uname,

					'description' => substr($singleContent[0]->describ,0,160),

					'keywords' => $tags,

					'articleAuthor' => $singleContent[0]->uname . '| Limit Code Author ',

					'articlePublisher' => 'Limit Code ',

					'ogUrl' => base_url().index_with().$singleContent[0]->link,

					'ogType' => $kind,

					'ogTitle' => $singleContent[0]->title.' | Limit Code ',

					'ogDescription' => substr($singleContent[0]->describ,0,160),

					'ogImage' => base_url().$singleContent[0]->thumbnail,			

					'ogImageSecureUrl' => base_url().$singleContent[0]->thumbnail,		

					'ogImageAlt' => $singleContent[0]->title		

				);



				$submenuCount = $this->Menu_Model->subMenuCount();

				

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



				$authorContent = $this->Article_Model->articleByIdUserAuthor($singleContent[0]->idUser,1,4);



				$commentContent = $this->Article_Model->commentById($singleContent[0]->id);



				$authorDetail = $this->Article_Model->articleByIdUser($singleContent[0]->idUser,1);



				if(!empty($authorDetail[0]->photo)) { 

					$pProfile = $authorDetail[0]->photo;

				} else {

					$pProfile = 'layout/img/NoAvatar.jpg';

				}

				$recentContent = $this->Article_Model->articleByStatusLimit(1,5);

				$popularContent = $this->Article_Model->articleByWatchStatusLimit(1,5);

				$reviewContent = $this->Article_Model->commentReview(1,5);


					$ads = $this->Banner_Model->bannerByStatus(1);

					$data = array(
						'advert' => $ads,

						'recentContent' => $recentContent,

						'popularContent' => $popularContent,

						'reviewContent' => $reviewContent,

						'imgResponsive' => true,


						'ava' => $ava,

						'menus' => $showMenu,

						'submenu' => $submenuCount,

						'pages' => 'detail',

						'webtitle' => ucwords($singleContent[0]->title).' | Limit Code',

						'meta'=> $meta,

						'detailtitle' => ucwords($singleContent[0]->title),



						'bounceArticle' => $singleContent[0]->id,

						'detail' => $singleContent[0],

						'tag' => $tagsExp,

						'author' => $authorContent,

						'comments' => $commentContent,

						'contentsLike' => $tagsReGEXP,


						'contents' => $articleByStatus,



						'authorId' => $authorDetail[0]->idUser,

						'authorName' => $authorDetail[0]->uname,

						'authorRegDate' => $authorDetail[0]->uRegDate,

						'authorPost' => count($authorDetail),

						'authorPhoto' => $pProfile,

						'sessionData' => $this->session->userdata()

					);

				$this->load->view('front/template/template',$data);

			} else {

				echo "Kontent mungkin ditangguhkan atau sudah dihapus, <a href=".base_url().index_with().">Kembali</a>";

			}

		} else {

			echo "Kontent mungkin ditangguhkan atau sudah dihapus, <a href=".base_url().index_with().">Kembali</a>";

		}

	}



	public function contentDetailVideo()

	{

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}



		$articleByStatus = $this->Article_Model->articleByStatus(1);



		$singleContent = $this->Article_Model->articleByUrl($this->uri->segment(2)); 



		$tagContent = $this->Article_Model->getTagByContentLink($this->uri->segment(2));



		if(!empty($tagContent[0]->the_tags)) {

			$tags = $tagContent[0]->the_tags;

		} else {

			$generateTag = str_replace(' ', ',', $singleContent[0]->title);

			$tags = $singleContent[0]->title.','.$generateTag;

		}



		$tagsExp = explode(',', $tags);
		$tagsLike = join('|',$tagsExp);

		$tagsReGEXP = $this->Article_Model->articleByTagsREGEXP($tagsLike);



		if($singleContent[0]->id != 0) {

			if($singleContent[0]->stat == 1) {

				// Publish

				if($this->uri->segment(1) == 'articles') {

					$kindProof = 1;

				} else {

					$kindProof = 2;

				}



				if($kindProof != $singleContent[0]->kind) {

					redirect('home');

				}



				if($singleContent[0]->kind == 1) {

					$kind = 'article';

				} else {

					$kind = 'video';

				}

				$meta = array(

					'author' => $singleContent[0]->uname,

					'description' => substr($singleContent[0]->describ,0,160),

					'keywords' => $tags,

					'articleAuthor' => $singleContent[0]->uname . '| Limit Code Author ',

					'articlePublisher' => 'Limit Code ',

					'ogUrl' => base_url().index_with().$singleContent[0]->link,

					'ogType' => $kind,

					'ogTitle' => $singleContent[0]->title.' | Limit Code ',

					'ogDescription' => substr($singleContent[0]->describ,0,160),

					'ogImage' => base_url().$singleContent[0]->thumbnail,			

					'ogImageSecureUrl' => base_url().$singleContent[0]->thumbnail,		

					'ogImageAlt' => $singleContent[0]->title		

				);



				$submenuCount = $this->Menu_Model->subMenuCount();

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



				$authorContent = $this->Article_Model->articleByIdUserAuthor($singleContent[0]->idUser,1,4);



				$commentContent = $this->Article_Model->commentById($singleContent[0]->id);



				$authorDetail = $this->Article_Model->articleByIdUser($singleContent[0]->idUser,1);



				if(!empty($authorDetail[0]->photo)) {

					$pProfile = $authorDetail[0]->photo;

				} else {

					$pProfile = 'layout/img/NoAvatar.jpg';

				}



				$recentContent = $this->Article_Model->articleByStatusLimit(1,5);

				$popularContent = $this->Article_Model->articleByWatchStatusLimit(1,5);

				$reviewContent = $this->Article_Model->commentReview(1,5);



				$ads = $this->Banner_Model->bannerByStatus(1);

				$data = array(
					'advert' => $ads,

					'recentContent' => $recentContent,

					'popularContent' => $popularContent,

					'reviewContent' => $reviewContent,

					'imgResponsive' => true,

					'ava' => $ava,

					'menus' => $showMenu,

					'submenu' => $submenuCount,

					'pages' => 'detailvideo',

					'webtitle' => ucwords($singleContent[0]->title).' | Limit Code',

					'meta'=> $meta,

					'detailtitle' => ucwords($singleContent[0]->title),



					'bounceArticle' => $singleContent[0]->id,

					'detail' => $singleContent[0],

					'tag' => $tagsExp,

					'author' => $authorContent,

					'comments' => $commentContent,

					'contentsLike' => $tagsReGEXP,

					'contents' => $articleByStatus,



					'authorId' => $authorDetail[0]->idUser,

					'authorName' => $authorDetail[0]->uname,

					'authorRegDate' => $authorDetail[0]->uRegDate,

					'authorPost' => count($authorDetail),

					'authorPhoto' => $pProfile,

					'sessionData' => $this->session->userdata()

				);



				$this->load->view('front/template/template',$data);

			} else {

				echo "Kontent mungkin ditangguhkan atau sudah dihapus, <a href=".base_url().index_with().">Kembali</a>";

			}

		} else {

			echo "redirect 404 / home";

		}

	}

	public function shorturl()
	{
		$showMenu = array();

		if($this->agent->is_mobile()) {
			$mobileUser = true;
		} else {
			$mobileUser = false;
		}

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}

		$articleByStatus = $this->Article_Model->articleByStatus(1);

		$submenuCount = $this->Menu_Model->subMenuCount();
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

		$meta = array(
			'author' => 'Short URL Powered By Limit Code Inc.',
			'description' => 'Short URL Powered By Limit Code. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',
			'keywords' => 'Short URL Powered By Limit Code, Short URL, Limit Code, Limit, Code, Sebuah Media, Media, Berbagi, Tulisan, Artikel, Article, Writer, Share, Video, Photo, Image, Audio, mp4, mp3',
			'articleAuthor' => 'Short URL Powered By Limit Code',
			'articlePublisher' => 'Short URL Powered By Limit Code',
			'ogType' => 'article',
			'ogUrl' => base_url().index_with().'short',
			'ogTitle' => 'Short URL Powered By Limit Code',
			'ogDescription' => 'Short URL Powered By Limit Code. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',
			'ogImage' => base_url().'/layout/img/lc-short-link.jpg',			
			'ogImageSecureUrl' => base_url().'layout/img/lc-short-link.jpg',		
			'ogImageAlt' => 'Short URL Powered By Limit Code'		
		);

		$data = array(
			'menus' => $showMenu,
			'submenu' => $submenuCount,
			'pages' => 'shorturl',
			'webtitle' => 'Short URL Powered By Limit Code',
			'meta'=> $meta,
			'detailtitle' => 'Short URL Powered By Limit Code',

			'mobile' => $mobileUser,

			'contents' => $articleByStatus,

			'sessionData' => $this->session->userdata()
		);



		$this->load->view('front/template/template',$data);
	}


	public function shortUrlGenerate()
	{
		if ($this->input->post()) {
			if($this->input->post('action') == 'generateurl') {

				$longUrl = $this->input->post('longurl');

				echo json_encode($this->generateShortURL($longUrl));
			}
		}
	}

	public function redirShortUrl()
	{
		if($this->uri->segment(1) == 'r' && $this->uri->segment(2) != '' || !empty($this->uri->segment(2))) {

			$code = $this->uri->segment(2);

			$shortDataByCode = $this->User_Model->shortUrlByCode($code);
			if(!empty($shortDataByCode)) {

				$baseForSubs = strlen(base_url().'uploads/screencapture');

				$getString = substr($shortDataByCode[0]->url_long, 34, 13);

				// GET IP
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

				// GET BROWSER DATA
				$clientBrowser = $_SERVER['HTTP_USER_AGENT'];

				// GET DESKTOP OR MOBILE
				if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$clientBrowser)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($clientBrowser,0,4))) {

					$clientType = 'mobile';
				} else {
					$clientType = 'desktop';
				}


				//PARSING
				if($getString == 'screencapture') {
					$errorRedir = 'paste';
					$trueRedir = '';

					$baseForSubs = strlen(base_url().'uploads/screencapture');

					$getString = substr($shortDataByCode[0]->url_long, 34, 13);

					
					$meta = array(
						'author' => 'Screen Capture Share Powered By Limit Code Inc.',
						'description' => 'Screen Capture Share By Limit Code. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',
						'keywords' => 'Screen Capture Share Powered By Limit Code, screen capture, preint screen, paste, Limit Code, Limit, Code, Sebuah Media, Media, Berbagi, Tulisan, Artikel, Article, Writer, Share, Video, Photo, Image, Audio, mp4, mp3',
						'articleAuthor' => 'Short URL Powered By Limit Code',
						'articlePublisher' => 'Short URL Powered By Limit Code',
						'ogType' => 'image',
						'ogUrl' => base_url().index_with().'paste',
						'ogTitle' => 'Screen Capture Share Powered By Limit Code',
						'ogDescription' => 'Screen Capture Share Powered By Limit Code. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',
						'ogImage' => base_url().index_with().'showsecurepaste/'.$code,			
						'ogImageSecureUrl' => base_url().index_with().'showsecurepaste/'.$code,	
						'ogImageType' => "image/png",
						'ogImageAlt' => 'Screen Capture Share Powered By Limit Code'		
					);

					$data = array(
						'webtitle' => 'Screen Capture Share Powered By Limit Code',
						'meta'=> $meta,
						'detailtitle' => 'Screen Capture Share Powered By Limit Code',

						'contents' => base_url().index_with().'showsecurepaste/'.$code,

						'sessionData' => $this->session->userdata()
					);

					$this->load->view('front/showpaste',$data);

				} else {
					$errorRedir = 'short';
					$trueRedir = $shortDataByCode[0]->url_long;
				}

				$insertAnalytic = $this->User_Model->insertAnalyticShortUrl($shortDataByCode[0]->id_short, $shortDataByCode[0]->url_code, $ipaddress, $clientBrowser, $clientType);

				if($insertAnalytic > 0) {
					if(!empty($trueRedir) || $trueRedir != '') {
						header("Location: ".$trueRedir);
					}					
				} else {
					redirect($errorRedir);
				}
			}

		} else {
			redirect('home?redirShortUrl');
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

	public function screnShootCapture()
	{

		if($this->uri->segment(1) == 'showsecurepaste') {
			redirect('paste');
		}

		$showMenu = array();
		if($this->agent->is_mobile()) {
			$mobileUser = true;
		} else {
			$mobileUser = false;
		}

		$menu = $this->Menu_Model->menuByStatus(1);

		$submenu = $this->Menu_Model->subMenuByStatus(1);

		$menuArticle = $this->Menu_Model->menuFromArticle();
		$subMenuArticle = $this->Menu_Model->subMenuFromArticle();

		foreach ($menu as $key => $value) {

			// Article Menu
			foreach ($menuArticle as $art => $mArt) {

				if($value->id_menu == $mArt->id_category) {

					$showMenu[$value->menu_name]['url'] = $value->menu_url;


					foreach ($submenu as $keysub => $valuesub) {

						if($value->id_menu == $valuesub->id_menu) {

							// Article Sub Menu
							foreach ($subMenuArticle as $sart => $smArt) {

								if($smArt->id_sub == $valuesub->id_sub) {
									$showMenu[$value->menu_name][$valuesub->sub_name]['url'] = $valuesub->sub_url;
								}
							}

						}

					}
				}
			}

		}


		$articleByStatus = $this->Article_Model->articleByStatus(1);

		$submenuCount = $this->Menu_Model->subMenuCount();
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

		$meta = array(
			'author' => 'Screen Capture Share Powered By Limit Code Inc.',
			'description' => 'Screen Capture Share By Limit Code. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',
			'keywords' => 'Screen Capture Share Powered By Limit Code, screen capture, preint screen, paste, Limit Code, Limit, Code, Sebuah Media, Media, Berbagi, Tulisan, Artikel, Article, Writer, Share, Video, Photo, Image, Audio, mp4, mp3',
			'articleAuthor' => 'Short URL Powered By Limit Code',
			'articlePublisher' => 'Short URL Powered By Limit Code',
			'ogType' => 'article',
			'ogUrl' => base_url().index_with().'paste',
			'ogTitle' => 'Screen Capture Share Powered By Limit Code',
			'ogDescription' => 'Screen Capture Share Powered By Limit Code. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',
			'ogImage' => base_url().'/layout/img/lc-short-link.jpg',			
			'ogImageSecureUrl' => base_url().'layout/img/lc-short-link.jpg',		
			'ogImageAlt' => 'Screen Capture Share Powered By Limit Code'		
		);

		$data = array(
			'menus' => $showMenu,
			'submenu' => $submenuCount,
			'pages' => 'paste',
			'webtitle' => 'Screen Capture Share Powered By Limit Code',
			'meta'=> $meta,
			'detailtitle' => 'Screen Capture Share Powered By Limit Code',

			'mobile' => $mobileUser,

			'contents' => $articleByStatus,

			'sessionData' => $this->session->userdata()
		);



		$this->load->view('front/template/template',$data);
	}

	public function getScreenCapture()
	{
		if ($this->input->post()) {
			if($this->input->post('action') == 'sendpaste') {
				if(!empty($this->input->post('base64'))) {
					$imageBase64 = $this->input->post('base64');

					$removeBase = str_replace('data:image/png;base64,', '', $imageBase64);
					$img = str_replace(' ', '+', $removeBase);
					$data = base64_decode($img);

					$scFolder = 'uploads/screencapture/'.date('Y').'/'.date('F').'/'; 
					$scDir = path_with().$scFolder;
					if (!is_dir($scDir))
				    {
				        mkdir($scDir, 0777, true);
				    }

				    $nameRand = date('YmdHis');

				    $file = $scDir.$nameRand.'.png';
					
				    if(file_put_contents($file, $data)) {
						$config['image_library'] = 'gd2';  
						$config['source_image'] = $file;  
						$config['create_thumb'] = TRUE;  
						$config['maintain_ratio'] = TRUE;  
						$config['width'] = 600;  

						$this->load->library('image_lib', $config);  

						if ($this->image_lib->resize()) {
							if(unlink($file)) {
								$newNameAfterResize = $scDir.$nameRand.'_thumb.png';

								$longUrl = base_url().$scFolder.$nameRand.'_thumb.png';

								$shortUrl = $this->generateShortURL($longUrl);

								$message = array('status' => 1, 'linkto' => $shortUrl['shotrurl']);
								echo json_encode($message);
							}
						} else {
							echo $this->image_lib->display_errors();
						}
					}
				}
			}
		}
	}

	public function showSecureScrenShootCapture()
	{
		if($this->uri->segment(1) == 'paste' && $this->uri->segment(2) != '' || !empty($this->uri->segment(2))) {

			$code = $this->uri->segment(2);

			$shortDataByCode = $this->User_Model->shortUrlByCode($code);
			if(!empty($shortDataByCode)) {

				$baseForSubs = strlen(base_url().'uploads/screencapture');

				$getString = substr($shortDataByCode[0]->url_long, 34, 13);

				//PARSING
				if($getString != 'screencapture') {
					$errorRedir = 'short';
					redirect($errorRedir);
				} else {

					header('Content-type: image/jpeg');
					echo file_get_contents($shortDataByCode[0]->url_long);
					
				}
			}

		} else {
			redirect('home?showSecureScrenShootCapture');
		}
	}

	public function showScrenShootCapture()
	{
		if($this->uri->segment(1) == 'paste' && $this->uri->segment(2) != '' || !empty($this->uri->segment(2))) {

			$code = $this->uri->segment(2);

			$shortDataByCode = $this->User_Model->shortUrlByCode($code);
			if(!empty($shortDataByCode)) {

				$baseForSubs = strlen(base_url().'uploads/screencapture');

				$getString = substr($shortDataByCode[0]->url_long, 34, 13);

				//PARSING
				if($getString != 'screencapture') {
					$errorRedir = 'short';
					redirect($errorRedir);
				} else {
					$meta = array(
						'author' => 'Screen Capture Share Powered By Limit Code Inc.',
						'description' => 'Screen Capture Share By Limit Code. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',
						'keywords' => 'Screen Capture Share Powered By Limit Code, screen capture, preint screen, paste, Limit Code, Limit, Code, Sebuah Media, Media, Berbagi, Tulisan, Artikel, Article, Writer, Share, Video, Photo, Image, Audio, mp4, mp3',
						'articleAuthor' => 'Short URL Powered By Limit Code',
						'articlePublisher' => 'Short URL Powered By Limit Code',
						'ogType' => 'image',
						'ogUrl' => base_url().index_with().'paste',
						'ogTitle' => 'Screen Capture Share Powered By Limit Code',
						'ogDescription' => 'Screen Capture Share Powered By Limit Code. Limit Code adalah sebuah media untuk berbagi tulisan, video, audio dan gambar.',
						'ogImage' => base_url().index_with().'showsecurepaste/'.$code,			
						'ogImageSecureUrl' => base_url().index_with().'showsecurepaste/'.$code,		
						'ogImageAlt' => 'Screen Capture Share Powered By Limit Code'		
					);

					$data = array(
						'webtitle' => 'Screen Capture Share Powered By Limit Code',
						'meta'=> $meta,
						'detailtitle' => 'Screen Capture Share Powered By Limit Code',

						'contents' => base_url().index_with().'showsecurepaste/'.$code,

						'sessionData' => $this->session->userdata()
					);

					$this->load->view('front/showpaste',$data);
					
				}
			}

		} else {
			redirect('home?showScrenShootCapture');
		}
	}

}

