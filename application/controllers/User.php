<?php

defined('BASEPATH') OR exit('No direct script access allowed');



// include APPPATH . 'libraries/facebook/graph-sdk/src/Facebook/autoload.php'; 

require FCPATH . 'vendor/autoload.php';





class User extends CI_Controller {



	function __construct()  

	{

		parent::__construct();



		$this->load->helper('url');

		$this->load->helper('language');

		$this->load->library('session');

		$this->load->helper('cookie');

		$this->load->helper('captcha');

		$this->load->library('user_agent');

		$this->load->helper(array('form', 'url', 'html'));

		$this->load->library('form_validation');



		$this->load->model('User_Model');

		$this->load->model('Email_Model');

	}



	public function index()

	{

		echo "Index User";

	}



	public function signin()

	{

		$this->session->set_userdata('referred_from', 'signin');



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		if(!empty($this->session->userdata('id_user'))) {

			redirect('dashboard');

		}



		if(isset($_COOKIE['email'])) {

			if(!empty($_COOKIE['email'])) {

			    $check = $this->User_Model->userByEmail($_COOKIE['email']);

				if(!empty($check) || count($check) > 0) {

					foreach ($check as $key => $value) {



						$logData = $this->User_Model->lastLoginById($value->id_user);

					    $userData = array(

			                'id_user'  => $value->id_user,

			                'email_user'     => $value->email_user,

			                'name_user' => $value->name_user,

			                'bhirtday_user' => $value->bhirtday_user,

			                'gender_user' => $value->gender_user,

			                'photo_user' => $value->photo_user,

			                'auth_by' => $value->auth_by,

			                'register_date' => $value->register_date,

			                'verify' => $value->verify,

			                'user_status' => $value->user_status,

			                'last_login' => $logData[0]->datetime_login

				        );

				        $this->session->set_userdata($userData);

				        redirect('dashboard');

				    }

				}

			}

		}



		$captcha = "";

		$msg = '';

		for($i=0; $i < 6; $i++){

			$x = mt_rand(0, 2);

			switch($x){

				case 0: $captcha.= chr(mt_rand(97,122));break;

				case 1: $captcha.= chr(mt_rand(65,90));break;

				case 2: $captcha.= chr(mt_rand(48,57));break;

			}

		}



		$capData = array(

			'ip_address'    => $this->input->ip_address(),

			'word'          => $captcha

		);



		// $query = $this->db->insert_string('captcha', $data);

		$loginData = array();

		$loginData['email'] = '';

		$loginData['password'] = '';



		// LOGIN SELF

		if ($this->input->post('submit') == 'signin') {



			$this->form_validation->set_rules('email', 'Email', 'trim|required');

			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			$this->form_validation->set_rules('captcaInput', 'Captca', 'trim|required');

			$this->form_validation->set_rules('captcaOriginal', 'Captca', 'trim|required');



			if ($this->form_validation->run() == true) {

				$email = $this->input->post('email');

				$password = md5($this->input->post('password'));

				$captcaInput = strtolower($this->input->post('captcaInput'));

				$captcaOriginal = $this->input->post('captcaOriginal');



				if($captcaInput == $captcaOriginal) {

					$check = $this->User_Model->userLogin($email,$password);

					// print_r($check); exit();

					if(!empty($check) || count($check) > 0) {

						foreach ($check as $key => $value) {

							if($value->password_user == $password && $value->auth_by == 'self') {

								if($value->verify == 0) {

									$msg = "You not yet verification your email";

								} 

								// elseif($value->verify == 1) {

								// 	$msg = "You not yet verification by admin";

								// } 

								else {



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



									$browser_info = $_SERVER['HTTP_USER_AGENT'];



									$logData = $this->User_Model->lastLoginById($value->id_user);



									$logIn = $this->User_Model->insertLogin($value->id_user, $ipaddress, $browser_info, date('Y-m-d H:i:s'));



									if($logIn > 0) {



										if($this->input->post('keepsignin') == 1) {

								       		setcookie('email', $email, time() + (86400 * 30), "/");

									   }





										$userData = array(

							                'id_user'  => $value->id_user,

							                'email_user'     => $value->email_user,

							                'name_user' => $value->name_user,

							                'bhirtday_user' => $value->bhirtday_user,

							                'gender_user' => $value->gender_user,

							                'photo_user' => $value->photo_user,

							                'auth_by' => $value->auth_by,

							                'register_date' => $value->register_date,

							                'verify' => $value->verify,

							                'user_status' => $value->user_status,

							                'last_login' => $logData[0]->datetime_login

								        );

								        $this->session->set_userdata($userData);

										redirect('dashboard');

									} else {

										$msg = "Failed get user information";

									}

								}

							} else {

								$msg = "Email or Password worng";

							}

						}

					} else {

						$msg = "Email or Password worng";

					}

				} else {

					$loginData = array();

					$loginData['email'] = $email;

					$loginData['password'] = $this->input->post('password');



					$msg = "Wrong captcha";

				}



			} else {

				$msg = "Form must be filled";

			}

		}



		// LOGIN WITH FACEBOOK

		$app_id = '570962756574024';

		$app_secret = 'e0b74d5b90da6e05ce94a98b3b170cc2';



		$fb = new Facebook\Facebook([

			'app_id' => $app_id,

			'app_secret' => $app_secret,

			'default_graph_version' => 'v2.2',

		]); 



		$helper = $fb->getRedirectLoginHelper();



		$permissions = ['email'];

		$loginUrlFacebook = $helper->getLoginUrl(base_url().index_with().'signin/f', $permissions);



		$data = array(

			'sess' => $this->session->userdata(),



			'cIp' => $capData['ip_address'],

			'cWord' => $capData['word'],

			'signinFacebook' => $loginUrlFacebook,



			'msg' => $msg,

			'loginData' => $loginData

		);

 

		$this->load->view('back/account/signin',$data); 

	}



	public function signinFacebook()

	{

		$account = $this->session->userdata('referred_from');



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		$app_id = '570962756574024';

		$app_secret = 'e0b74d5b90da6e05ce94a98b3b170cc2';



		$fb = new Facebook\Facebook([

			'app_id' => $app_id,

			'app_secret' => $app_secret,

			'default_graph_version' => 'v2.2',

		]);



		$helper = $fb->getRedirectLoginHelper();



		try {

			$accessToken = $helper->getAccessToken();

		} catch(Facebook\Exceptions\FacebookResponseException $e) {

  			// When Graph returns an error

			echo 'Graph returned an error: ' . $e->getMessage();

			exit;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {

  			// When validation fails or other local issues

			echo 'Facebook SDK returned an error: ' . $e->getMessage();

			exit;

		}



		$response = $fb->get('/me?fields=id,name,email,gender',  $accessToken);

		$graphNode = $response->getGraphNode();

		$user = $response->getGraphUser();



		// check user by email

		$check = $this->User_Model->userByEmail($user['email']);

		if(!empty($check) || count($check) > 0) {

			// Ada 

			redirect('dashboard');

		} else {

			// Kosong



			// Save data dan redirect ke home

			$insert = $this->User_Model->insertNewUser($user['email'], '', $user['name'], '', $user['gender'], '', 'facebook', date('Y-m-d H:i:s'), 1, 1);



			if($insert > 0) {

				redirect('dashboard');

			}

		}

	}



	public function signup()

	{

		$this->session->set_userdata('referred_from', 'signup');



		$msg = '';



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		$captcha = "";

		for($i=0; $i < 6; $i++){

			$x = mt_rand(0, 2);

			switch($x){

				case 0: $captcha.= chr(mt_rand(97,122));break;

				case 1: $captcha.= chr(mt_rand(65,90));break;

				case 2: $captcha.= chr(mt_rand(48,57));break;

			}

		}



		$capData = array(

			'ip_address'    => $this->input->ip_address(),

			'word'          => $captcha

		);



		// $query = $this->db->insert_string('captcha', $data);



		if ($this->input->post('submit') == 'signup') {



			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');

			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');

			$this->form_validation->set_rules('email', 'Email', 'trim|required');

			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			$this->form_validation->set_rules('repassword', 'Retype Password', 'trim|required');

			$this->form_validation->set_rules('birth_month', 'Month', 'trim|required');

			$this->form_validation->set_rules('birth_day', 'Day', 'trim|required');

			$this->form_validation->set_rules('birth_year', 'Year', 'trim|required');

			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');

			$this->form_validation->set_rules('captcaInput', 'Captca', 'trim|required');

			$this->form_validation->set_rules('captcaOriginal', 'Captca', 'trim|required');



			if ($this->form_validation->run() == true) {

				$nFirst = $this->input->post('first_name');

				$nLast = $this->input->post('last_name');

				$name = $nFirst.' '.$nLast;

				$email = $this->input->post('email');

				$password = md5($this->input->post('password'));

				$repassword = md5($this->input->post('repassword'));

				$bMonth = $this->input->post('birth_month');

				$bDay = $this->input->post('birth_day');

				$bYear = $this->input->post('birth_year');

				$birthdate = $bYear.'-'.$bMonth.'-'.$bDay;

				$gender = $this->input->post('gender');

				$captcaInput = strtolower($this->input->post('captcaInput'));

				$captcaOriginal = $this->input->post('captcaOriginal');



				if($password == $repassword) {

					if($captcaInput == $captcaOriginal) {

						$check = $this->User_Model->userByEmail($email);

						if(empty($check) || count($check) == 0) {

							$insert = $this->User_Model->insertNewUser($email, $password, $name, $birthdate, $gender,'', 'self', date('Y-m-d H:i:s'), 0, 1);



							if($insert > 0) {

								$vCode = md5($email.'-'.date('YmdHis'));

								$insertVerify = $this->User_Model->insertVerify($email, $vCode, date('Y-m-d H:i:s'), date('Y-m-d H:i:s', strtotime("+30 minutes")));

								if($insertVerify > 0) {

									$button = "verify/".$vCode;


									$emailMessage = $this->Email_Model->emailBody('successregister',$button,'');

									$sendEmail = $this->Email_Model->sendmail($email,'Verification Email For Limit Code Account',$emailMessage);


									if($sendEmail == true) {

										$msg = "Check $email for verification account";

									} else {

										$msg = "Send email to $email failed";

									}

								}

							}

						} else {

							foreach ($check as $key => $value) {

								if($value->auth_by == 'facebook') {

									$msg = "Email has been connected with Facebook";

								} else {

									$msg = "Email already registered";

								}

							}

						}

					} else {

						$msg = "Wrong captcha";

					}

				} else {

					$msg = "Password and Repassword not match";

				}



			} else {

				$msg = "Form must be filled";

			}

		}



		// LOGIN WITH FACEBOOK

		$app_id = '570962756574024';

		$app_secret = 'e0b74d5b90da6e05ce94a98b3b170cc2';



		$fb = new Facebook\Facebook([

			'app_id' => $app_id,

			'app_secret' => $app_secret,

			'default_graph_version' => 'v2.2',

		]);



		$helper = $fb->getRedirectLoginHelper();



		$permissions = ['email'];

		$loginUrlFacebook = $helper->getLoginUrl(base_url().index_with().'signin/f', $permissions);



		$data = array(

			'sess' => $this->session->userdata(),



			'cIp' => $capData['ip_address'],

			'cWord' => $capData['word'],

			'signinFacebook' => $loginUrlFacebook,



			'msg' => $msg

		);



		$this->load->view('back/account/signup',$data); 

	}



	public function forgotpass()

	{

		$this->session->set_userdata('referred_from', 'forgotpass');



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		$captcha = "";

		$msg = '';

		for($i=0; $i < 6; $i++){

			$x = mt_rand(0, 2);

			switch($x){

				case 0: $captcha.= chr(mt_rand(97,122));break;

				case 1: $captcha.= chr(mt_rand(65,90));break;

				case 2: $captcha.= chr(mt_rand(48,57));break;

			}

		}



		$capData = array(

			'ip_address'    => $this->input->ip_address(),

			'word'          => $captcha

		);



		// $query = $this->db->insert_string('captcha', $data);



		// LOGIN SELF

		if ($this->input->post('submit') == 'resetpass') {



			$this->form_validation->set_rules('email', 'Email', 'trim|required');

			$this->form_validation->set_rules('captcaInput', 'Captca', 'trim|required');

			$this->form_validation->set_rules('captcaOriginal', 'Captca', 'trim|required');



			if ($this->form_validation->run() == true) {

				$email = $this->input->post('email');

				$captcaInput = strtolower($this->input->post('captcaInput'));

				$captcaOriginal = $this->input->post('captcaOriginal');



				if($captcaInput == $captcaOriginal) {

					$check = $this->User_Model->userByEmail($email);

					if(!empty($check) || count($check) > 0) {

						foreach ($check as $key => $value) {

							if($value->auth_by == 'facebook') {

								$msg = "Email has been connected with Facebook, please login with Facebook";

							} else {

								$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

								$code = '';

								for ($i = 0; $i < 20; $i++) {

									$code .= $characters[rand(0, strlen($characters) - 1)];

								}



								$request = $this->User_Model->insertReqPass($email, $code, date('Y-m-d H:i:s'),date('Y-m-d H:i:s', strtotime("+30 minutes")),0);

								if($request > 0) {

									$validUrl = 'newpassword/'.$code;

									$emailMessage = $this->Email_Model->emailBody('resetpassword',$validUrl,'');

									$sendingEmail = $this->Email_Model->sendmail($email,'Limit Code Account Reset Password',$emailMessage);


									if($sendingEmail == true) {
										$msg = "Check $email for reset your password account";
									} else {
										$msg = "Sending email to $email failed";
									}

								}

							}

						}

					} else {

						$msg = "Email not yet registerd";

					}

				} else {

					$msg = "Wrong captcha";

				}



			} else {

				$msg = "Form must be filled";

			}

		}



		// LOGIN WITH FACEBOOK

		$app_id = '570962756574024';

		$app_secret = 'e0b74d5b90da6e05ce94a98b3b170cc2';



		$fb = new Facebook\Facebook([

			'app_id' => $app_id,

			'app_secret' => $app_secret,

			'default_graph_version' => 'v2.2',

		]);



		$helper = $fb->getRedirectLoginHelper();



		$permissions = ['email'];

		$loginUrlFacebook = $helper->getLoginUrl(base_url().index_with().'signin/f', $permissions);



		$data = array(

			'sess' => $this->session->userdata(),



			'cIp' => $capData['ip_address'],

			'cWord' => $capData['word'],

			'signinFacebook' => $loginUrlFacebook,



			'msg' => $msg

		);



		$this->load->view('back/account/forgotpass',$data); 

	}



	public function newpassword()

	{

		$this->session->set_userdata('referred_from', 'signin');



		$get_lang = $this->session->userdata('language');

		if($get_lang == 'bahasa') {

			$this->lang->load('bahasa_lang', 'bahasa');

		} else {

			$this->lang->load('english_lang', 'bahasa');

		}



		$captcha = "";

		$msg = "";

		for($i=0; $i < 6; $i++){

			$x = mt_rand(0, 2);

			switch($x){

				case 0: $captcha.= chr(mt_rand(97,122));break;

				case 1: $captcha.= chr(mt_rand(65,90));break;

				case 2: $captcha.= chr(mt_rand(48,57));break;

			}

		}



		$capData = array(

			'ip_address'    => $this->input->ip_address(),

			'word'          => $captcha

		);



		// $query = $this->db->insert_string('captcha', $data);



		if($this->uri->segment(1) == 'newpassword' && $this->uri->segment(2) != '') {

			$code = $this->uri->segment(2);

			$check= $this->User_Model->reqpassByCode($code);

				if(!empty($check)) {

				$ck = strtotime($check[0]->end_date) - strtotime(date('Y-m-d H:i:s'));

				if($ck <= 0) {

					$msg = "Request new password is expired <br>

					<small><a href=".base_url().index_with()."forgotpass>Request Again</a></small>";

				} else {



					if(count($check) > 0 && $check[0]->req_verify == 0) {

						//ADA



						// LOGIN SELF

						if ($this->input->post('submit') == 'newpassword') {



							$this->form_validation->set_rules('password', 'Password', 'trim|required');

							$this->form_validation->set_rules('repassword', 'Retype Password', 'trim|required');

							$this->form_validation->set_rules('captcaInput', 'Captca', 'trim|required');

							$this->form_validation->set_rules('captcaOriginal', 'Captca', 'trim|required');



							if ($this->form_validation->run() == true) {

								$password = md5($this->input->post('password'));

								$repassword = md5($this->input->post('repassword'));

								$captcaInput = strtolower($this->input->post('captcaInput'));

								$captcaOriginal = $this->input->post('captcaOriginal');



								if($password == $repassword) {

									if($captcaInput == $captcaOriginal) {


										foreach ($check as $key => $value) {

											$updateReq = $this->User_Model->updateReqPass($value->email_user, $code, 1, date('Y-m-d H:i:s'));



											if($updateReq > 0) {

												// Update New User Password

												$updatePass = $this->User_Model->updatePassUser($value->email_user, $password);



												if($updatePass > 0) {

													redirect('signin?npOk');

												} else {

													$msg = "Update password failed";

												}

											} else {

												$msg = "Update request password status failed";

											}

										}

									} else {

										$msg = "Wrong captcha";

									}

								} else {

									$msg = "Password and Repassword not match";

								}



							} else {

								$msg = "Form must be filled";

							}

						}

					} else {

						//GAK

						redirect('signin?npNo');

					}

				}
			} else {
				$display = true;
				echo "Your link is invalid, please check instruction on your email";
				// redirect('signin?Your link is invalid, please check instruction');
			}
		} else {

			redirect('signin?npNot');

		}



		// LOGIN WITH FACEBOOK

		$app_id = '570962756574024';

		$app_secret = 'e0b74d5b90da6e05ce94a98b3b170cc2';



		$fb = new Facebook\Facebook([

			'app_id' => $app_id,

			'app_secret' => $app_secret,

			'default_graph_version' => 'v2.2',

		]);



		$helper = $fb->getRedirectLoginHelper();



		$permissions = ['email'];

		$loginUrlFacebook = $helper->getLoginUrl(base_url().index_with().'signin/f', $permissions);



		$data = array(

			'sess' => $this->session->userdata(),

			

			'cIp' => $capData['ip_address'],

			'cWord' => $capData['word'],

			'signinFacebook' => $loginUrlFacebook,



			'msg' => $msg

		);


		if(isset($display)) {

		} else {
			$this->load->view('back/account/newpassword',$data);
		}
		 

	}



	public function verify()

	{

		$this->session->set_userdata('referred_from', 'signin');



		// PATCH

		$verifyString = $this->uri->segment(2);

		if(!empty($verifyString)) {

			// get data by code

			$valid = $this->User_Model->verifyByCode($verifyString);



			if(!empty($valid) || count($valid) > 0) {

				foreach ($valid as $key => $value) {

					$calc = strtotime($value->valid_date) - strtotime(date('Y-m-d H:i:s'));

					// exit();

					if($calc <= 0) {

						echo "Verification link has expired, <a href='".base_url().index_with()."reqverify/".$value->id_verify."'>please request again</a>";

					} else {

						$updateTableVerify = $this->User_Model->updateVerifyTable($value->id_verify, date('Y-m-d H:i:s'));

						if($updateTableVerify > 0) {

							$verifyUser = $this->User_Model->updateVerifyUser(1, $value->email_user);

							if($verifyUser > 0) {

								echo "Verification success, <a href='".base_url().index_with()."signin'>please sigin</a>";

							} else {

								echo "Email already verified , <a href='".base_url().index_with()."signin'>please sigin</a>";

							}

						} else {

							echo "Update verified status failed";

						}

					}

				}

			} else {

				echo "Verificarion link invalid";

			}

		} else {

			redirect('signin');

		}

	}



	public function reqverify()

	{

		// PATCH

		$idVerify = $this->uri->segment(2);

		if(!empty($idVerify)) {



			$verifyCheck = $this->User_Model->verifyById($idVerify);

			if(!empty($verifyCheck) || count($verifyCheck) > 0) {

				foreach ($verifyCheck as $k => $v) {

					$userCheck = $this->User_Model->userByEmail($v->email_user);

					if(!empty($userCheck) || count($userCheck) > 0) {

						foreach ($userCheck as $key => $value) {

							$email = $v->email_user;

							if($value->verify == 1) {

								echo "email anda sudah terverifikasi sebelumnya";

							} else {

								$insertVerify = $this->User_Model->insertVerify($email, md5($email.'-'.date('YmdHis')), date('Y-m-d H:i:s'), date('Y-m-d H:i:s', strtotime("+30 minutes")));

								if($insertVerify > 0) {

									echo "silahkan melakukan verifikasi pada email : $email";

								}

							}

						}

					} else {

						echo "email belum terdaftar";

					}

				}

			} else {

				echo "data tidak ditemukan";

			}

		} else {

			echo "redirect ke login";

		}

	}



	public function notif()

	{

		if($this->input->post('getnotif')) {

			$notify = $this->User_Model->notifById($this->input->post('getnotif'));



			echo json_encode($notify);

		}

	}



	public function language()

	{

		$set_lang = $this->uri->segment(2);

		$redir = $this->session->userdata('referred_from');



		$this->session->set_userdata('language', $set_lang);



		redirect($redir);

	}

}

