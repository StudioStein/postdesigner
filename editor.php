<?php

session_start();

include "functions.php";

check_log();

?>

<html>
	<head>
	
		<title>Post Designer - Studio Stein</title>
		
		<link rel="shortcut icon" href="favicon.png" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<link rel="stylesheet" href="https://unpkg.com/cirrus-ui">
		<script src="https://unpkg.com/canvas-txt"></script>
		
		
		<script>
			template = JSON.parse(<?php 
			
			$obj = file_read("templates.json");
			$obj2 = $obj->{$_SESSION["login-postdesigner"]["id"]}->templates[$_GET["id"]]->arte;
			echo "'".json_encode($obj2)."'"; 
			
			?>);
	 
			userColors = [<?php
			
			$obj3 = $obj->{$_SESSION["login-postdesigner"]["id"]}->cores;
			echo '"'.implode('","', $obj3).'"';
			
			?>];
		</script>
		
		<script src="editor.js"></script>
		
		<style>
		@keyframes fadein {
			from { opacity: 0; }
			to   { opacity: 1; }
		}
		@keyframes fadeout {
			from { opacity: 1; }
			to   { opacity: 0; }
		}
		</style>
		
	</head>
	
	<body onload="loadedPage=true">
	
	<div id="loader">
		<span class="u-center-alt">Carregando...</span>
	</div>
	
	<style>
		#loader {
			position:fixed;
			left:0; top:0;
			right:0; bottom:0;
			z-index:1000;
			background: rgba(246, 249, 252,0.75);
			backdrop-filter: blur(8px);
		}
	</style>
	
	<div id="screen-editor">
	
		<div class="u-flex u-justify-space-between" style="width:100%;position:fixed;">
			<div class="tab-container" style="flex-grow:1">
				<ul class="bg-gray-100 m-0">
					<li>
						<div class="tab-item-content bg-gray-100" onclick="window.location='dashboard.php'">
							<i class="material-icons">home</i>
							<span class="u-none-xs"><span class="p-1"></span>Voltar</span>
						</div>
					</li>
				</ul>
			</div>
			<div class="tab-container tabs-right" style="flex-grow:1">
				<ul class="bg-gray-100 m-0">
					<li>
						<div class="tab-item-content bg-gray-100" onClick="renderImg()">
							<i class="material-icons">save_alt</i>
							<span class="u-none-xs"><span class="p-1"></span>Salvar Imagem</span>
						</div>
					</li>
				</ul>
			</div>
		</div>
		
		<div style="height:50px;"></div>
		
		<div class="p-2 u-center" style="max-width: 500px;">
			<div class="bg-gray-100">
				<canvas id="myCanvas" width="1080" height="1080" class="u-shadow" style="max-width:100%;"></canvas>
			</div>
			
			<div class="space large"></div>
		
		<!-- Main Menu -->
		
			<div id="elements" style="width:100%">
				<p class="text-gray-600 u-text-center">Escolha um elemento para editar</p>
				<div id="elementsContainer" style="overflow:auto; white-space: nowrap;text-align:center">
					
					
					
				</div>
			</div>
			
			<div id="menus" style="width:100%">
				
			</div>
			
			<div id="content" style="overflow: hidden;  width: 0;  height: 0;">
				<img id="placeholder" src="imgs/placeholder.png" crossOrigin="Anonymous" onload="loadedContent[0]=true">
			</div>
			
		</div>
	
	</div>
	
	<div id="screen-save" style="display:none">
		
		<div class="u-flex u-justify-space-between" style="width:100%;position:fixed;">
			<div class="tab-container" style="flex-grow:1">
				<ul class="bg-gray-100 m-0">
					<li>
						<div class="tab-item-content bg-gray-100" onclick="gotoMenu(this)" data-id1="screen-save" data-id2="screen-editor">
							<i class="material-icons">arrow_back</i>
							<span class="u-none-xs"><span class="p-1"></span>Voltar ao editor</span>
						</div>
					</li>
				</ul>
			</div>
		</div>
		
		<div style="height:50px;"></div>
		
		<div class="p-2 u-center" style="max-width: 500px;">
			<div class="bg-gray-100">
				<img id="imageSave" src="imgs/placeholder.png" width="1080" height="1080" class="u-shadow" style="max-width:100%; animation: fadein .5s;">
			</div>
			
			<div class="space large"></div>
			
			<p class="text-gray-600 u-text-center">Clique e segure a imagem para salvar.</p>
		</div>
		
		
	</div>
		
	<script>
		start();
	</script>

	</body>
	
</html>