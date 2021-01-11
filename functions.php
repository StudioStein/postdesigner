<?php

// Functions from app

function file_read($fileDir) {
		
		if (file_exists($fileDir)) { // Se o arquivo existe, envia as informações em Obj
			$file = fopen($fileDir, "r") or die("Unable to open file!");
			$json = fread($file, filesize($fileDir));
			fclose($file);
			return json_decode($json);
		} else { // Se não, envia false
			return false;
		}
		
	}

function check_log() {
		if(isset($_GET['logout'])) {
			unset($_SESSION["login-postdesigner"]); 
			unset($_GET);
			header('LOCATION:login.php');
			die();
		};
		
		if(!isset($_SESSION['login-postdesigner'])) {
			header('LOCATION:login.php'); die();
		}
	}
	
	
?>