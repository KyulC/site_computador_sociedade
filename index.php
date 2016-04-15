<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/main.css">
		<meta charset="UTF-8"> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<script src="js/jquery-1.11.3.min.js"></script>
   		<script src="js/bootstrap.min.js"></script>
   		<script src="js/eecolixo.js"></script>
   		<script>
   			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
   		</script>
		<title>E-EcoLixo</title>
	</head>

	<body>
		<div id="fb-root"></div>
		<div class="top">
			<div class="container">
				<?php 
					session_name("_LOGIN");
					session_start();
					if(isset($_SESSION['usuario']) && isset($_SESSION['senha']))
					{
						$connection = new mysqli("localhost", "user", "password", "database_name");
						$stmt = $connection->prepare("SELECT user, password FROM users WHERE user = ?");
						$stmt->bind_param("s", $_SESSION['usuario']);
						$stmt->execute();
						$stmt->bind_result($log_user, $log_pass);
						$stmt->fetch();
						if($log_user != "")
						{
							if($log_pass == $_SESSION['senha'])
							{
								?>
									<div class="navbar">
										<div class="navbar-right login-panel">
											<b>Seja bem-vindo <?php echo $log_user; ?></b>
											<br>
											<a href="?page=register_local">Cadastrar Local</a>
											<br>
											<a href="actions.php?action=logout">Sair<a>
										</div>
									</div>
								<?php
							}
							else
							{
								unset($_SESSION['usuario'], $_SESSION['senha']);
								session_destroy();
							}
						}
						else
						{
							unset($_SESSION['usuario'], $_SESSION['senha']);
							session_destroy();
						}
					}
					else
					{
				?>
						<form class="navbar-form navbar-right" action="actions.php?action=login" method="POST" id="form_login">
							<div class="form-group" id="for-login">
								<input type="text" name="login" id="login" class="form-control" placeholder="Usuário"></input>
									<div class="bubble" data-toggle="bubble_login">
										Você não pode deixar este campo vazio!
									</div>
							</div>
							<div class="form-group" id="for-senha">
								<input type="password" name="senha" id="senha" class="form-control" placeholder="Senha"></input>
									<div class="bubble" data-toggle="bubble_senha">
										Você não pode deixar este campo vazio!
									</div>
							</div>
							<button class="btn btn-primary" type="submit">Entrar</button>
						</form>
				<?php

					}

				?>
			</div>
		</div>
		<div class="line-top"></div>

		<div class="banner">
			<div class="container">
				<img src="imgs/banner/1.jpg" class="img-responsive" width="1200" height="350">
			</div>
		</div>

		<div class="menu">
			<!--<div class="menu-indicator"></div> -->
				<a href="#"><img src="imgs/menu-mobile-icon.png" class="img-responsive mobile-icon" id="menuicon"></a>
					<ul>
						<li><a href="?page=home" id="home">HOME</a></li>
						<li><a href="?page=voce-sabia" id="voce-sabia">VOCÊ SABIA?</a></li>
						<li><a href="?page=procurar" id="procurar">PROCURAR</a></li>
						<li><a href="?page=registrar" id="registrar">REGISTRAR</a></li>
						<li><a href="?page=contato" id="contato">CONTATO</a></li>
					</ul>
		</div>
			<div class="menu-mobile">
				<ul>
					<li><a href="?page=home" id="home">HOME</a></li>
					<li><a href="?page=voce-sabia" id="voce-sabia">VOCÊ SABIA?</a></li>
					<li><a href="?page=procurar" id="procurar">PROCURAR</a></li>
					<li><a href="?page=registrar" id="registrar">REGISTRAR</a></li>
					<li><a href="?page=contato" id="contato">CONTATO</a></li>
				</ul>
			</div>

		<div class="wrapper container">
			<div class="content">
				<?php
					$permited_pages = array('home', 'voce-sabia', 'procurar', 'registrar', 'contato', 'register_local');
					if(isset($_GET['page']))
					{
						$page = $_GET['page'];
						if(in_array($page, $permited_pages) != FALSE)
						{
							if(file_exists($page . ".php") != FALSE)
							{
								include($page . ".php");
							}
							else
							{
								echo "This page isn't exists!";
								//include("errors/404.html");
							}
						}
						else
						{
							echo "This page isn't permitted!";
						}
					}
					else
					{
						include("home.php");
					}
				?>
			</div>
				<div class="panel-eco">
					<div class="panel-heading eco-style">Facebook</div>
						<div class="panel-body">
							<div class="fb-page" data-href="https://www.facebook.com/facebook" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
								<div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div>
							</div>
						</div>
				</div>
				<div class="panel-eco">
					<div class="panel-heading eco-style">Twitter</div>
						<div class="panel-body">
							 <a class="twitter-timeline"  href="https://twitter.com/Linux" data-widget-id="604826809784483840">Tweets de @Linux</a>
						</div>
				</div>
		</div>

		<div class="footer">
			<div class="footer-content">
				Rodapé
			</div>
		</div>
   	</body>
</html>
