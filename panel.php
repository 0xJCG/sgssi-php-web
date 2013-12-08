<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);
	
	require 'interfaces/cabecera.php';
	require 'includes/cusuario.php';
	
	$cusuario = CUsuario::getCUsuario();
	
	if (isset($_POST['panel']) && $_POST['panel'] == 1) {
		if ($_SESSION['form_token'] != $_POST['form_token']) {
			require 'interfaces/formulario_panel.php';
		} else {
			if ($_POST['pass1'] == $_POST['pass2']) {
				$correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
				$contrasenaV = $_POST['pass'];
				$contrasenaN = $_POST['pass1'];
				$cusuario->modificarUsuario($correo, $contrasenaN, $contrasenaV);
			}
			require 'interfaces/formulario_panel.php';
		}
	} else {
		require 'interfaces/formulario_panel.php';
	}
	
	require 'interfaces/pie.html';
?>