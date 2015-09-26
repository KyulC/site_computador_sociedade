<?php 

	//BlowFish function
	function blowFishCrypt($pass)
	{
		$custo = '08';
		$seed = uniqid(mt_rand(), true);
		$salt = base64_encode($seed);
		if($pass != "")
		{
			return crypt($pass, "$2a$" .$custo. "$" .$salt. "$");
		}
		else
		{
			echo "pass is empty";
		}
	}
	//Connection
	$connection = new mysqli("localhost", "root", "jackass", "ecolixo");

	if($connection->connect_error)
	{
		echo "Not connected to db!";
	}

	if(isset($_POST['act']) != FALSE)
	{
		$act = $_POST['act'];
		if($act == "verifyUser")
		{
			if(isset($_POST['user']) != FALSE)
			{
				$user = $_POST['user'];
				$stmt = $connection->prepare("SELECT user FROM users WHERE user = ?");
				$stmt->bind_param("s", $user);
				$stmt->execute();
				$stmt->bind_result($usuario);
				$stmt->fetch();

				if($usuario != "")
				{
					echo "_USER_EXISTS_";
				}
				else
				{
					echo "_USER_NOT_EXISTS_";
				}

				$stmt->close();
			}
			else
			{
				echo "Variable user is not set!";
			}
		}
		else
		{
			if($act == "getCity")
			{
				if(isset($_POST['state']) != FALSE)
				{
					$state = $_POST['state'];
					$c = array();
					$i = 0;
					$stmt = $connection->prepare("SELECT DISTINCT cidade FROM locals WHERE estado = ?");
					$stmt->bind_param("s", $state);
					$stmt->execute();
					$stmt->bind_result($city);
					while($stmt->fetch())
					{
						$c[$i] = $city;
						$i++;
					}
					echo json_encode($c);
					exit();
				}
				else
				{
					echo "Variable state is not set!";
				}
			}
			else
			{
				if($act == "getLocal")
				{
					if(isset($_POST['city']) != FALSE)
					{
						$city = $_POST['city'];
						$l = array();
						$i = 0;
						$stmt =  $connection->prepare("SELECT nome_local FROM locals WHERE cidade = ?");
						$stmt->bind_param("s", $city);
						$stmt->execute();
						$stmt->bind_result($local);
						while($stmt->fetch())
						{
							$l[$i] = $local;
							$i++;
						}
						echo json_encode($l);
						exit();
					}
					else
					{
						echo "Variable city is not set!";
					}
				}
				else
				{
					if($act == "getCoordinates")
					{
						if(isset($_POST['local']) != FALSE)
						{
							$local = $_POST['local'];
							$loc = array();
							$i = 0;
							$stmt = $connection->prepare("SELECT latitude, longitude FROM locals WHERE nome_local = ?");
							$stmt->bind_param("s", $local);
							$stmt->execute();
							$stmt->bind_result($lat, $lng);
							while($stmt->fetch())
							{
								$loc[$i] = $lat;
								$loc[$i + 1] = $lng;
								$i++;
							}

							echo json_encode($loc);
							exit();
						}
						else
						{
							echo "Variable local is not set!";
						}
					}
				}
			}
		}
	}

	if(isset($_GET['action']) != FALSE)
	{
		$action = $_GET['action'];

		if($action == "register") // Registrar
		{
			$user = $_POST['usuario'];
			$pass = $_POST['pass'];

			$stmt = $connection->prepare("INSERT INTO users (user, password) VALUES (?, ?)");
			$stmt->bind_param("ss", $user, blowFishCrypt($pass));
			if($stmt->execute())
			{
				$stmt->close();
				header("Location: index.php?page=registrar&status=sucess");
			}
			else
			{
				$stmt->close();
				header("Location: index.php?page=registrar&status=error");
			}
		}
		else
		{
			if($action == "login") // Login
			{
				if(isset($_GET['l']))
				{
					$link_previous = $_GET['l'];
				}
				$login = $_POST['login'];
				$senha = $_POST['senha'];

				$stmt = $connection->prepare("SELECT password FROM users WHERE user = ?");
				$stmt->bind_param("s", $login);
				$stmt->execute();
				$stmt->bind_result($s);
				$res = $stmt->fetch();
				if($res == true && $res != NULL)
				{
					if(crypt($senha, $s) == $s)
					{
						$stmt->close();
						session_name("_LOGIN");
						session_start();
						$_SESSION['usuario'] = $login;
						$_SESSION['senha'] = $s;
						session_write_close();
						echo "<script>history.go(-1);</script>";
					}
					else
					{
						echo "<script>alert('Senha não válida!');history.go(-1);</script>";
					}
				}
				else
				{
					echo "No rows finded or data truncated!";
				}
			}
			else
			{
				if($action == "reg_local")
				{
					$nome_local = $_POST['nome_local'];
					$logradouro = $_POST['logradouro'];
					$cidade = $_POST['cidade'];
					$estado = $_POST['estado'];
					$lat = $_POST['latitude'];
					$lng = $_POST['longitude'];

					$stmt = $connection->prepare("INSERT INTO locals (nome_local, logradouro, estado, cidade, latitude, longitude) VALUES(?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("ssssdd", $nome_local, $logradouro, $estado, $cidade, $lat, $lng);
					if($stmt->execute())
					{
						header("Location: index.php?page=register_local&status=sucess");
					}
					else
					{
						header("Location: index.php?page=register_local&status=error");
					}

					$stmt->close();
				}
				else
				{
					if($action == "logout")
					{
						session_name("_LOGIN");
						session_start();
						if(isset($_SESSION['usuario']) && isset($_SESSION['senha']))
						{
							unset($_SESSION['usuario'], $_SESSION['senha']);
							session_destroy();
							echo "<script>history.go(-1);</script>";
						}
						else
						{
							echo "Você não está logado para fazer logout!";
						}
					}
					else
					{
						if($action == "send_email")
						{
							$to = "kyul@hotmail.com.br";
							$nome = $_POST['nome'];
							$email = $_POST['email'];
							$assunto = $_POST['assunto'];
							$mensagem = nl2br($_POST['mensagem']);
							$headers =  'From: '.$email.' ' . "\r\n" .
									    'Reply-To: '.$email.' ' . "\r\n" .
									    'X-Mailer: PHP/' . phpversion();

							if(mail($to, $assunto, $mensagem, $headers) == TRUE)
							{
								header("Location:index.php?page=contato&status=sucess");
							}
							else
							{
								header("Location:index.php?page=contato&status=error");
							}

						}
						else
						{
							echo "Dont permitted!";
						}
					}
				}
			}
		}
	}

?>