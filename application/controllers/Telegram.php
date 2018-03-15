<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram extends CI_Controller { 

	function __construct() 
	{
		parent::__construct();

		$this->load->helper('language');
		$this->load->library('session');
		$this->load->helper('captcha');
		$this->load->library('user_agent');
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->library('form_validation');
		$this->load->helper('file');

		$this->load->model('Menu_Model');
		$this->load->model('Article_Model');
		$this->load->model('User_Model');
	}

	public function getUpdate()
	{

		$urlApi = "https://api.telegram.org/";
		$tokenApi = "bot530065763:AAEY1QQQJLdIQ7VupfO1T3pBxxS0qf8gwzs";
		$commandApi = "/getUpdates";

		$hit = $urlApi.$tokenApi.$commandApi;

		// $paramsCommand = "postvar1=value1&postvar2=value2&postvar3=value3";
		$paramsCommand = "";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $hit);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$paramsCommand);

		// in real life you should use something like:
		// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('postvar1' => 'value1')));

		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		$json = json_decode($server_output, true);

		if($json['ok'] == 1) {

	 		//pebri 353594164

			foreach ($json['result'] as $key => $value) {
				$toWrite['id'] 			= date('YmdHis');
				$toWrite['updateId'] 	= $value['update_id'];
				$toWrite['messageId'] 	= $value['message']['message_id'];
				$toWrite['userId'] 		= $value['message']['from']['id'];
				$toWrite['isBot'] 		= $value['message']['from']['is_bot'];
				$toWrite['firstName']	= $value['message']['from']['first_name'];
				$toWrite['lastName']	= $value['message']['from']['last_name'];

				if(empty($value['message']['from']['username'])) {
					$username = '';
				} else {
					$username = $value['message']['from']['username'];
				}

				$toWrite['userName']	= $username;
				$toWrite['chatTxt']		= $value['message']['text'];
				$toWrite['chatDate']	= date('Y-m-d H:i:s', $value['message']['date']);

				$telegramDir = path_with().'/uploads/telegram/chats/'.date('Y').'/'.date('F').'/';
				if (!is_dir($telegramDir))
				{
					mkdir($telegramDir, 0777, true);
				}

				$filename = $telegramDir.$value['update_id'].'.json';
				if(!file_exists($filename)) {

					if (write_file($filename,  json_encode($toWrite)))
					{
						$getReply = $this->commandFor($value['message']['text']);

						// echo "$getReply";

						// return array
						$sendReply = $this->sendMessage($value['message']['from']['id'],$getReply);

						if($sendReply['ok'] == 1) {
							echo "ok";
						}
					}

				}

			}

		}
	}


	private function commandFor($command) {

		$theCommand = strtolower($command);
		$theCommand = str_replace('/', '', $theCommand);

		switch ($theCommand) {
			case 'kontent':

			$randomContent = $this->Article_Model->articleRandom();

			$msg = "Limit Code Content \n";
			$msg .= "------------------------------- \n\n";
			foreach ($randomContent as $key => $value) {

				if($value->kind == 1) {
					$knd = 'articles/';
				} else {
					$knd = 'videos/';
				}

				$msg .= ucwords($value->title)."\n";

				$shortUrl = $this->User_Model->shortUrlByLongUrl(base_url().index_with().$knd.$value->content_link);

				if(empty($shortUrl)) {
					$longUrl = base_url().index_with().$knd.$value->content_link;

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
							$msg .= $short_url."\n\n\n";
						}
					}

				} else {
					$msg .= $shortUrl[0]->url_short."\n\n\n";
				}
			}		


			return $msg;
			break;

			case 'jualbeli':
			return 'promo product jual beli dari http://limitcode.xyz';
			break;

			case 'pulsa':
			return 'penjualan self service pulsa hp, PLN dll http://limitcode.xyz';
			break;

			case 'support':
			return 'contact service';
			break;
			
			default:
			return 'menu tidak tersedia';
			break;
		}

	}


	private function sendMessage($to,$message) {

		$urlApi = "https://api.telegram.org/";
		$tokenApi = "bot530065763:AAEY1QQQJLdIQ7VupfO1T3pBxxS0qf8gwzs";
		$commandApi = "/sendMessage";

		$hit = $urlApi.$tokenApi.$commandApi;

		// $paramsCommand = "postvar1=value1&postvar2=value2&postvar3=value3";
		$paramsCommand = "chat_id=".$to."&text=".$message."";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $hit);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$paramsCommand);

		// in real life you should use something like:
		// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('postvar1' => 'value1')));

		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		$json = json_decode($server_output, true);

		return $json;
	}
}
