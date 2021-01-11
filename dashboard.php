<?php

session_start();

include "functions.php";

check_log();

?>

<html>
	<head>
	
		<title>Post Designer - Studio Stein</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<link rel="stylesheet" href="https://unpkg.com/cirrus-ui">
		
		<link rel="shortcut icon" href="favicon.png" />
		
	</head>
	
	<body>

		<div class="u-flex u-justify-space-between" style="width:100%">
			<div class="tab-container" style="flex-grow:1">
				<ul class="bg-gray-100 m-0">
					<li>
						<div class="tab-item-content bg-gray-100">
							<i class="material-icons">design_services</i>
							<span class="p-1"></span><span class="strong">Post Designer</span>
						</div>
					</li>
				</ul>
			</div>
			<div class="tab-container tabs-right" style="flex-grow:1">
				<ul class="bg-gray-100 m-0">
					<li>
						<div class="tab-item-content bg-gray-100" onclick="window.location.href='dashboard.php?logout=1'">
							<i class="material-icons">power_settings_new</i>
							<span class="u-none-xs"><span class="p-1"></span>Logout<span>
						</div>
					</li>
				</ul>
			</div>
		</div>
		
		<div style="height:50px;"></div>
		
		<div class="p-2" style="max-width: 500px; margin-left:auto; margin-right:auto;">
		
				<div class="space"></div>
				
				<figure class="avatar avatar--xlarge bg-light u-shadow"><img src="<?php echo $_SESSION["login-postdesigner"]["profile-pic"]; ?>"></figure>
				
				<div class="space large"></div>
				
				<h3 class="u-center"><?php echo $_SESSION["login-postdesigner"]["nome"]; ?></h3>
				
				<div class="space xlarge"></div>
				
				<div class="faded u-center">Templates</div>
				
				<div class="space"></div>
				
				<div class="templatesList">
				
					<?php
					
						$obj = file_read("templates.json");
						$obj = $obj->{$_SESSION["login-postdesigner"]["id"]};
						for($i=0; $i<count($obj->templates); $i++) {
							echo '<a href="editor.php?id='.$i.'"><img src="'.$obj->templates[$i]->cover.'" crossOrigin="Anonymous"></a>';
						};
						
					?>
					
					
				
				</div>
				
				<style>
					.templatesList {
					}
					.templatesList img {
						max-width:31%;
					}
				</style>

		</div>
		

	</body>
	
</html>