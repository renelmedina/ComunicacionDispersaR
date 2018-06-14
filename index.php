<?php

require_once("libreria.php");
$cabecera=new PaginaPrincipal;
echo $cabecera->ArchivosEsenciales();
echo $cabecera->FrameworkModernos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Comunicacion Dispersa</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(images/accsac-comunicaciondispersa.jpg);">
					<span class="login100-form-title-1">
						Comunicacion Dispersa
					</span>
				</div>
				<div id="divMensajesRebote">
						<?php 
						
						/*$usuario=(coger_dato_externo("usuario")==null?'':coger_dato_externo("usuario"));
						$password=(coger_dato_externo("password")==null?'':coger_dato_externo("password"));*/



						//$valor=(empty(coger_dato_externo("msj")))?"s":coger_dato_externo("msj");
						$valor=(coger_dato_externo("mensajito")==null?'':coger_dato_externo("mensajito"));
						if (!empty($valor)) {
							msg_rojo($valor);
						}
						//echo $valor;*/
						?>
					</div>
				<form class="login100-form validate-form" id="frmIniciarSession" onsubmit="envio_general_forms('#frmIniciarSession','login.php','#divMensajesRebote');return false;" >
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Usuario</span>
						<input class="input100" type="text" name="usuario" placeholder="Usuario">
						
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Contraseña</span>
						<input class="input100" type="password" name="password" placeholder="Contraseña">
						<span class="focus-input100"></span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="su">
							Iniciar Session
						</button>
					</div>
					
				</form>
			</div>
			<div style="clear: both; width: 100%; text-align: center;">
				<p style="font-size: 0.7em;">Copyright &copy; 2018<br>
					ACC Contratistas Generales SAC<br>
					Scdsoft V 1.0<br>
					Developed by: <a href="mailto: renel@renel.pe">Renel Medina Ancalle</a>
				</p>
			</div>
		</div>
	</div>
	


</body>
</html>