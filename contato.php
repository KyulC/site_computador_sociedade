<style type="text/css">
#mensagem
{
	resize: vertical;
}
</style>

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#form-contact").submit(function()
		{
			var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;

			if($("#nome").val() == "")
			{
				$("#for-nome").addClass("has-error");
				$("[data-toggle='bubble_nome']").empty();
				$("[data-toggle='bubble_nome']").append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);
				return false;
			}
			else
			{
				$("#for-nome").removeClass("has-error");
				$("#for-nome").addClass("has-success");

				if($("#email").val() == "")
				{
					$("#for-email").addClass("has-error");
					$("[data-toggle='bubble_email']").empty();
					$("[data-toggle='bubble_email']").append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);
					return false;
				}
				else
				{
					if(pattern.test($("#email").val()) != true)
					{
						$("#for-email").addClass("has-error");
						$("[data-toggle='bubble_email']").empty();
						$("[data-toggle='bubble_email']").append("Digite um email válido!").fadeIn().delay(2000).fadeOut(500);
						return false;
					}
					else
					{
						$("#for-email").removeClass("has-error");
						$("#for-email").addClass("has-success");

						if($("#assunto").val() == "")
						{
							("#for-assunto").addClass("has-error");
							$("[data-toggle='bubble_assunto']").empty();
							$("[data-toggle='bubble_assunto']").append("Digite um assunto!").fadeIn().delay(2000).fadeOut(500);
							return false;
						}
						else
						{
							$("#for-assunto").removeClass("has-error");
							$("#for-assunto").addClass("has-success");

							if($("#mensagem").val() == "")
							{
								$("#for-mensagem").addClass("has-error");
								$("[data-toggle='bubble_mensagem']").empty();
								$("[data-toggle='bubble_mensagem']").append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);
								return false;
							}
							else
							{
								$("#for-mensagem").removeClass("has-error");
								$("#for-mensagem").addClass("has-success");
								return true;
							}
						}
					}
				}
			}
		});
	});
</script>
<h1>Contato</h1>
	<p>Encontrou algum problema no site e deseja reportá-lo?</p>
	<p>Tem alguma dúvida, sugestão ou crítica?</p>
	<p>Entre em contato conosco :)</p>

	<br>
	<br>

	<?php
		if(isset($_GET['status']))
		{
			$status = $_GET['status'];
			if($status == "sucess")
			{
				?>
					<div class="alert alert-success" role="alert"><b>Sucesso!</b> Email enviado com sucesso!</div>
				<?php
			}
			else
			{
				?>
					<div class="alert alert-danger" role="alert"><b>Erro!</b> Ocorreu um erro ao tentar enviar o email!</div>
				<?php
			}
		}
		else
		{

		}
	?>

	<form action="actions.php?action=send_email" id="form-contact" method="POST">
		<div class="form-group" id="for-nome">
			<label for="nome">Nome</label>
				<input type="text" name="nome" id="nome" maxlength="60" class="form-control" placeholder="Nome">
					<div class="bubble" data-toggle="bubble_nome"></div>
		</div>
		<div class="form-group" id="for-email">
			<label for="email">Email</label>
				<input type="text" name="email" id="email" maxlength="60" class="form-control" placeholder="Email">
					<div class="bubble" data-toggle="bubble_email"></div>
		</div>
		<div class="form-group" id="for-assunto">
			<label for="assunto">Assunto</label>
				<input type="text" name="assunto" id="assunto" maxlength="60" class="form-control" placeholder="Assunto">
					<div class="bubble" data-toggle="bubble_assunto"></div>
		</div>
		<div class="form-group" id="for-mensagem">
			<label for="mensagem">Mensagem</label>
				<textarea name="mensagem" id="mensagem" maxlength="60" class="form-control"></textarea>
					<div class="bubble" data-toggle="bubble_mensagem"></div>
		</div>
			<button type="submit" class="btn btn-primary">Enviar</button>
	</form>