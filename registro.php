<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);
	
	require 'interfaces/cabecera.php';
	
	if (isset($_POST['registro']) && $_POST['registro'] == 1) {
		if ($_SESSION['form_token'] != $_POST['form_token'])
			require 'interfaces/formulario_registro.php';
		else {
			$usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
			$correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
			$contrasena = $_POST['pass1'];
			$sal = hash("sha512", substr(sha1(mt_rand()), 0, 22)); // Sal.
			
			require 'includes/cusuario.php';
			$cusuario = CUsuario::getCUsuario();
			
			$cusuario->registrar($usuario, $correo, $contrasena, $sal);
			
			echo "Usuario $usuario registrado y conectado.";
		}
	} else {
		require 'interfaces/formulario_registro.php';
	}
	
	require 'interfaces/pie.html';
?>