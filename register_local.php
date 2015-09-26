<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>

<style type="text/css">
	#map-canvas
	{
		width: 100%;
		height: 350px;
		border-radius: 8px;
		box-shadow: 0px 0px 3px #000;
	}
	#place-in
	{
		margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 4px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        width: 400px;
        padding:5px;
	}
	#place-in:focus
	{
		border-color: #4d90fe;
	}
</style>

<script type="text/javascript">

	$(document).ready(function()
	{
		var control = 0;
		var canvas_mapa = document.getElementById('map-canvas');
		var input = (document.getElementById('place-in'));

		var marcador;
		var lat_long = new google.maps.LatLng(-23.5458, -46.6246);
		var options = { center: lat_long, zoom: 10, mapTypeId: google.maps.MapTypeId.ROADMAP };
		var mapa = new google.maps.Map(canvas_mapa, options);
		var bounds = new google.maps.LatLngBounds();

		mapa.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		var searchBox = new google.maps.places.SearchBox((input));

		google.maps.event.addListener(searchBox, "places_changed", function()
		{
			var places = searchBox.getPlaces();

			for (var i = 0, place; place = places[i]; i++)
			{
				bounds.extend(place.geometry.location);
			}

			mapa.fitBounds(bounds);
		});

			google.maps.event.addListener(mapa, 'bounds_changed', function()
			{
				var bounds = mapa.getBounds();
				searchBox.setBounds(bounds);
			});

			$("#create").click(function()
			{
				if(control == 1)
				{
					return false;
				}
				else
				{
					control = 1;
					addMarker(mapa.getCenter());
				}
			});

			$("#delete").click(function()
			{
				remMarker();
			});

			function addMarker(location)
			{
				marcador = new google.maps.Marker(
				{
					position: location,
					draggable: true,
					map: mapa
				});

				google.maps.event.addListener(marcador, "dragend", function()
				{
					$("#latitude").val(marcador.getPosition().lat());
					$("#longitude").val(marcador.getPosition().lng());
				});
			}

			function remMarker()
			{
				marcador.setMap(null);
				$("#latitude").val("");
				$("#longitude").val("");
				control = 0;
			}

			$('#form_reg_local').submit(function()
			{
				if($("#nome_local").val() == "")
				{
					$("#for-nome_local").addClass("has-error");
					$(".bubble").empty();
					$('[data-toggle="bubble_nome_local"]').append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);	
					return false;
				}
				else
				{
					if($("#logradouro").val() == "")
					{
						$("#for-nome_local").removeClass("has-error");
						$("#for-nome_local").addClass("has-success");
						$("#for-logradouro").addClass("has-error");
						$(".bubble").empty();
						$('[data-toggle="bubble_logradouro"]').append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);	
						return false;
					}
					else
					{
						if($("#cidade").val() == "")
						{
							$("#for-logradouro").removeClass("has-error");
							$("#for-logradouro").addClass("has-success");
							$("#for-cidade").addClass("has-error");
							$(".bubble").empty();
							$('[data-toggle="bubble_cidade"]').append("Este campo não pode ficar vazio!").fadeIn().delay(2000).fadeOut(500);	
							return false;
						}
						else
						{
							if($("#estado").val() == "")
							{
								alert("Escolha um estado!");	
								return false;
							}
							else
							{
								if($("#latitude").val() == "")
								{
									$("#for-latitude").addClass("has-error");
									$(".bubble").empty();
									$('[data-toggle="bubble_latitude"]').append("Adicione um marcador e mova-o para alterar a latitude!").fadeIn().delay(2000).fadeOut(500);	
									return false;
								}
								else
								{
									$("#for-latitude").removeClass("has-error");
									$("#for-latitude").addClass("has-success");

									if($("#longitude").val() == "")
									{
										$("#for-longitude").addClass("has-error");
										$(".bubble").empty();
										$('[data-toggle="bubble_longitude"]').append("Adicione um marcador e mova-o para alterar a longitude!").fadeIn().delay(2000).fadeOut(500);	
										return false;
									}
									else
									{
										$("#for-longitude").removeClass("has-error");
										$("#for-longitude").addClass("has-success");
										return true;
									}
								}
							}
						}
					}
				}
			});
	});
</script>


<h1>Cadastro de local</h1>
	<p>
		Nesta página você pode cadastrar o local que faz a coleta de lixo eletrônico.
	</p>
	<p>
		Para cadastrar um local, preencha os campos corretamente e adcione um marcador no mapa para, posteriormente, ser mostrado na página "procurar".
	</p>
	<p>
		<strong>Lembrando que você só pode cadastrar um local por vez.</strong>
	</p>
	<p>Os campos com o símbolo (*) é de preenchimento obrigatório</p>

	<br>
	<br>
		<?php
			if(isset($_GET['status']))
			{
				$status = $_GET['status'];
				if($status == "sucess")
				{
					?>
						<div class="alert alert-success" role="alert"><b>Sucesso!</b> Local registrado com sucesso!</div>
					<?php
				}
				else
				{
					?>
						<div class="alert alert-danger" role="alert"><b>Erro!</b> Ocorreu um erro ao tentar se registrar o local!</div>
					<?php
				}
			}
			else
			{

			}
		?>

	<form action="actions.php?action=reg_local" method="POST" id="form_reg_local">
		<div class="form-group" id="for-nome_local">
			<label for="nome_local">Nome do Local*</label>
				<input type="text" id="nome_local" name="nome_local" maxlength="60" class="form-control" placeholder="Nome do Local">
					<div class="bubble" data-toggle="bubble_nome_local"></div>
		</div> 
		<div class="form-group" id="for-logradouro">
			<label for="logradouro">Logradouro*</label>
				<input type="text" id="logradouro" name="logradouro" maxlength="60" class="form-control" placeholder="Complemento do local">
					<div class="bubble" data-toggle="bubble_logradouro"></div>
		</div> 
		<div class="form-group" id="for-cidade">
			<label for="cidade">Cidade*</label>
				<input type="text" id="cidade" name="cidade" maxlength="60" class="form-control" placeholder="Cidade do local">
					<div class="bubble" data-toggle="bubble_cidade"></div>
		</div> 
		<div class="form-group">
			<label for="estado">Estado*</label>
				<select id="estado" name="estado">
					<option value="">Selecione</option>
					<option value="AC">Acre</option>
					<option value="AL">Alagoas</option>
					<option value="AP">Amapá</option>
					<option value="AM">Amazonas</option>
					<option value="BA">Bahia</option>
					<option value="CE">Ceará</option>
					<option value="DF">Distrito Federal</option>
					<option value="ES">Espirito Santo</option>
					<option value="GO">Goiás</option>
					<option value="MA">Maranhão</option>
					<option value="MS">Mato Grosso do Sul</option>
					<option value="MT">Mato Grosso</option>
					<option value="MG">Minas Gerais</option>
					<option value="PA">Pará</option>
					<option value="PB">Paraíba</option>
					<option value="PR">Paraná</option>
					<option value="PE">Pernambuco</option>
					<option value="PI">Piauí</option>
					<option value="RJ">Rio de Janeiro</option>
					<option value="RN">Rio Grande do Norte</option>
					<option value="RS">Rio Grande do Sul</option>
					<option value="RO">Rondônia</option>
					<option value="RR">Roraima</option>
					<option value="SC">Santa Catarina</option>
					<option value="SP">São Paulo</option>
					<option value="SE">Sergipe</option>
					<option value="TO">Tocantins</option>
				</select>
		</div> 
		<div class="form-group" id="for-latitude">
			<label for="latitude">Latitude</label>
				<input type="text" id="latitude" name="latitude" maxlength="60" class="form-control" readonly="readonly">
					<div class="bubble" data-toggle="bubble_latitude"></div>
		</div> 
		<div class="form-group" id="for-longitude">
			<label for="longitude">Longitude</label>
				<input type="text" id="longitude" name="longitude" maxlength="60" class="form-control" readonly="readonly">
					<div class="bubble" data-toggle="bubble_longitude"></div>
		</div> 

			<input type="text" id="place-in" name="place-in" placeholder="Nome da cidade ou estado">
				<div id="map-canvas"></div>

		<br>
			<button class="btn btn-default" type="button" id="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Adicionar Marcador</button>
				<button class="btn btn-default" type="button" id="delete"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>&nbsp;Remover Marcador</button>
		<br>
		<br>
					<button class="btn btn-primary" type="submit">Registrar</button>
	</form>