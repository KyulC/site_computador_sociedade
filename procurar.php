
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<style type="text/css">
#map-canvas
{
	width: 100%;
	height: 350px;
	border-radius: 8px;
	box-shadow: 0px 0px 3px #000;
	display: none;
}
</style>
<script type="text/javascript">
$(document).ready(function()
{
	$("#for-cidade").hide();
	$("#for-locais").hide();

	$("#estado").on("change", function()
	{
		var request = $.ajax(
		{
			method: "POST",
			url: "actions.php",
			data: { state: $("#estado").val(), act: "getCity" },
			dataType: "json"
		});

		request.done(function(data)
		{
			$("#for-cidade").show();
			$("#cidade").empty();
			$("#cidade").append("<option value=''>Selecione</option>");
			for(var i = 0; i < data.length; i++)
			{
				$("#cidade").append("<option value='" +data[i]+ "'>" +data[i]+ "</option>");
			}
		});
	});

	$("#cidade").on("change", function()
	{
		var request = $.ajax(
		{	
			method: "POST",
			url: "actions.php",
			data: { city: $("#cidade").val(), act: "getLocal" },
			dataType: "json"
		});

		request.done(function(e)
		{
			$("#for-locais").show();
			$("#locais").empty();
			$("#locais").append("<option value=''>Selecione</option>");
			for(var i = 0; i < e.length; i++)
			{
				$("#locais").append("<option value='" +e[i]+ "'>" +e[i]+ "</option>");
			}
		});
	});


	$("#locais").on("change", function()
	{
		var request = $.ajax(
		{	
			method: "POST",
			url: "actions.php",
			data: { local: $("#locais").val(), act: "getCoordinates" },
			dataType: "json"
		});

		request.done(function(data)
		{
			var lat_lng = new google.maps.LatLng(data[0], data[1]);
			var elemento = document.getElementById("map-canvas");
			var options = { center: lat_lng, zoom: 17, mapTypeId: google.maps.MapTypeId.ROADMAP };
			var mapa = new google.maps.Map(elemento, options);
			var marker = new google.maps.Marker(
			{
				map: mapa,
				position: lat_lng,
				title: $("#locais").val()
			});
			$("#map-canvas").show();
		});
	});
});
</script>

	<h1>Procurar Locais</h1>

	<p>Nesta página você pode procurar locais para depósito de lixo eletrônico.</p>
	<p>Para isso, você deve escolher uma estado e posteriormente uma cidade. Após a escolha da cidade aparecerão os locais cadastrados na cidade escolhida.</p>
	<p>Clique no local para ser mostrado no mapa.</p>

	<br>
	<br>

		<div class="form-group" id="for-estado">
			<label for="estado">Estado</label>
				<select name="estado" id="estado">
					<option value="">Selecione</option>
					<?php
						$connection = new mysqli("localhost", "root", "jackass", "ecolixo");
						$stmt = $connection->prepare("SELECT DISTINCT estado FROM locals");
						$stmt->execute();
						$stmt->bind_result($estado);
						while($stmt->fetch())
						{
							?>
								<option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
							<?php
						}
					?>
				</select>
		</div>

		<div class="form-group" id="for-cidade">
			<label for="cidade">Cidade</label>
				<select name="cidade" id="cidade">
					<option value="">Selecione</option>
				</select>
		</div>

		<div class="form-group" id="for-locais">
			<label for="locais">Locais</label>
				<select name="locais" id="locais">
					<option value="">Selecione</option>
				</select>
		</div>

			<div id="map-canvas"></div>