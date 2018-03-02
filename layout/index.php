<?php 
	$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
	$url2 = explode('/', $url);

	$base = '/'.$url2[1];

	header("location: ".$base);

?>