<h1 class="page-title">Registro</h1>

<p>Registre-se para ajudar-nos a adicionar mais locais que coletam lixo eletrônico.</p>
<p>Todos os campos são de preenchimento obrigatório.</p>

<br>
	<?php
		if(isset($_GET['status']))
		{
			$status = $_GET['status'];
			if($status == "sucess")
			{
				?>
					<div class="alert alert-success" role="alert"><b>Sucesso!</b> Você foi registrado com sucesso!</div>
				<?php
			}
			else
			{
				?>
					<div class="alert alert-danger" role="alert"><b>Erro!</b> Ocorreu um erro ao tentar se registrar!</div>
				<?php
			}
		}
		else
		{

		}
	?>

<br>

	<form action="actions.php?action=register" method="post" id="form_register">
		<div class="form-group" id="reg_user">
			<label for="usuario">Usuário</label>
				<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite seu usuario" maxlength="30">
					<div class="bubble" data-toggle="bubble_user"></div>
		</div>
		<div class="form-group" id="reg_pass">
			<label for="senha">Senha</label>
				<input type="password" class="form-control" id="pass" name="pass" placeholder="Digite sua senha" maxlength="30">
					<div class="bubble" data-toggle="bubble_pass"></div>
		</div>
		<div class="form-group" id="reg_reppass">
			<label for="rep_senha">Repetir Senha</label>
				<input type="password" class="form-control" id="rep_senha" name="rep_senha" placeholder="Repita sua senha" maxlength="30">
					<div class="bubble" data-toggle="bubble_reppass"></div>
		</div>
			<button class="btn btn-primary" type="submit">Concluir</button>
	</form>