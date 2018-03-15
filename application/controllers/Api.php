<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller { 

	function __construct() 
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->model('Article_Model');
	}

	public function index()
	{
		echo "<h1>Call the Developer for using Limit Code Api's";
	}

	public function getContents()
	{
		if ($this->input->post()) {
			$contents = $this->Article_Model->articles();

			if(count($contents) > 0) {

				foreach($contents as $content) {

					if($content->kind == 1) {
						$kind = 'article';
					} else {
						$kind = 'video';
					}

					$dataOut[] = array(
						'id_content' => $content->id,
						'title_content' => $content->title,
						'kind_content' => $kind,
						'thumbnail_content' => base_url().$content->thumbnail,
						'the_content' => $content->describ,
						'date_content' => $content->datearticle
					);
				}

				$msg = array('error' => 0, 'message' => 'Contents found', 'data' => $dataOut);
			} else {
				$msg = array('error' => 1, 'message' => 'Contents not found', 'data' => '0');
			}

			echo json_encode($msg);
		}
	}

	public function getContentById()
	{
		if ($this->input->post()) {
			$id_content = $this->uri->segment(3);
			$byId = $this->Article_Model->articleById($id_content);
			if(count($byId) > 0) {

				foreach($byId as $cId) {

					if($cId->kind == 1) {
						$kind = 'article';
					} else {
						$kind = 'video';
					}

					$dataOut = array(
						'id_content' => $cId->id,
						'title_content' => $cId->title,
						'kind_content' => $kind,
						'thumbnail_content' => base_url().$cId->thumbnail,
						'the_content' => $cId->describ,
						'date_content' => $cId->datearticle
					);
				}

				$msg = array('error' => 0, 'message' => 'Content found', 'data' => $dataOut);
			} else {
				$msg = array('error' => 1, 'message' => 'Content not found', 'data' => '0');
			}

			echo json_encode($msg);
		}
	}
}
