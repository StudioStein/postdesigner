<?php
	if (!isset($_SESSION)) {session_start();}
	isset($_SESSION['request-accounts']) or die('Direct access not permitted!');
    
	$accounts = array();
	
	$accounts['StudioStein'] =  array(
		"nome" => "Studio Stein",
		"password" => "a33cd1109cfb6c5ee4a8f1769a69fcf4",
		"profile-pic" => "imgs/profile-studiostein.png",
		"id" => "studiostein");
		
	$accounts['moschetta'] = array(
		"nome" => "Moschetta",
		"password" => "a33cd1109cfb6c5ee4a8f1769a69fcf4",
		"profile-pic" => "imgs/profile-moschetta.png",
		"id" => "moschetta");
	
	unset($_SESSION["request-accounts"]);
?>