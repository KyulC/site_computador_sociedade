$(document).ready(function()
{
	$("#menuicon").click(function()
	{
		$(".menu-mobile ul").slideToggle("slow");
	});

	$("#form_login").submit(function()
	{
		if($("#login").val() == "")
		{
			$("#for-login").addClass("has-error");
			$('[data-toggle="bubble_login"]').fadeIn().delay(2000).fadeOut(500);			
			return false;
		}
		else
		{
			if($("#senha").val() == "")
			{
				$("#for-login").removeClass("has-error");
				$("#for-login").addClass("has-success");
				$("#for-senha").addClass("has-error");
				$('[data-toggle="bubble_senha"]').fadeIn().delay(2000).fadeOut(500);
				return false;
			}
			else
			{
				$("#for-senha").removeClass("has-error");
				$("#for-senha").addClass("has-success");
				return true;
			}
		}
	});


	$("#form_register").submit(function()
	{
		if($("#usuario").val() == "")
		{
			$("#reg_user").addClass("has-error");
			$(".bubble").empty();
			$('[data-toggle="bubble_user"]').append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);	
			return false;
		}
		else
		{
			var request = $.ajax(
			{
				method: "POST",
				url: "actions.php",
				data: { user: $("#usuario").val(), act: "verifyUser" }
			});

			request.done(function(result)
			{
				if(result == "_USER_EXISTS_")
				{
					$("#reg_user").addClass("has-error");
					$(".bubble").empty();
					$('[data-toggle="bubble_user"]').append("Este nome de usuário já existe!").fadeIn().delay(2000).fadeOut(500);	
					return false;
				}
			});

				$("#reg_user").removeClass("has-error");
				$("#reg_user").addClass("has-success");

				if($("#pass").val() == "")
				{
					
					$("#reg_pass").addClass("has-error");
					$(".bubble").empty();
					$('[data-toggle="bubble_pass"]').append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);	
					return false;
				}
				else
				{
					if($("#rep_senha").val() == "")
					{
						$("#reg_pass").addClass("has-success");
						$("#reg_reppass").addClass("has-error");
						$(".bubble").empty();
						$('[data-toggle="bubble_reppass"]').append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);	
						return false;
					}
					else
					{
						if($("#pass").val() != $("#rep_senha").val())
						{
							$("#reg_reppass").addClass("has-error");
							$(".bubble").empty();
							$('[data-toggle="bubble_reppass"]').append("As senhas não coincidem!").fadeIn().delay(2000).fadeOut(500);	
							return false;
						}
						else
						{
							$("#reg_pass").removeClass("has-error");
							$("#reg_reppass").removeClass("has-error");
							$("#reg_pass").addClass("has-success");
							$("#reg_reppass").addClass("has-success");
							return true;
						}
					}
				}
		}
	});

	$(".alert").fadeOut(4000);
})