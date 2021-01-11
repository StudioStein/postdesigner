<?php
	session_start();
    if(isset($_SESSION['login-postdesigner'])) {
        header('LOCATION:dashboard.php'); die();
    }
	
	// define variables and set to empty values
	$user = $pass = $error = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["user"]) or empty($_POST["pass"])) {
			$error = "Preencha todos os campos";
		} else {
			$user = test_input($_POST["user"]); // Clean name input
			$pass = test_input($_POST["pass"]); // Clean pass input
			
			$_SESSION['request-accounts'] = true;
			include 'accounts.php';
			
			if (!isset($accounts[$user])) {
				$error = "<code>Usuário ou Senha invalidos</code>";
			} else {
				if (md5($pass) == $accounts[$user]["password"]) {
					$_SESSION["login-postdesigner"] = $accounts["$user"];
					
					header('LOCATION:dashboard.php'); die();
				} else {
					$error = "<code>Usuário ou Senha invalidos</code>";
				}
			}
		}
	}
			  
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<html>
	<head>
	
		<title>Post Designer - Studio Stein</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<script src="https://kit.fontawesome.com/2699c07835.js" crossorigin="anonymous"></script>
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<link rel="stylesheet" href="https://unpkg.com/cirrus-ui">
		
		<link rel="shortcut icon" href="favicon.png" />
	</head>
	
	<body>
	
		<div class="hero fullscreen bg-light">
			<div class="hero-body">
				<div class="mx-auto">
					<div class="card bg-white p-4">
						<div className="card-container p-4">
							<h1 class="u-text-center">Post Designer</h1>
						</div>
						<div className="content">
							<div className="space"></div>	
							
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
								<div class="input-control">
									<input type="text" class="input-contains-icon" placeholder="Usuário" name="user" value="<?php echo $user; ?>"/><span class="icon"><i class="fa fa-wrapper fa-user"></i></span>
								</div>
								<div class="input-control">
									<input type="password" class="input-contains-icon" placeholder="Senha" name="pass" value="<?php echo $pass; ?>"/><span class="icon"><i class="fa fa-wrapper fa-lock"></i></span>
								</div>
								
								<input type="submit" class="btn-primary" name="submit" value="Login">
								
								<div className="card-footer">
									<div className="u-text-center"><?php echo $error; ?></div>
								</div>
								
							</form>
						</div>
					</div>
			</div>
		</div>
		
	</body>
	
</html>