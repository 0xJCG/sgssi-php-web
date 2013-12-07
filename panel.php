<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);
	
	require_once 'vista/cabecera.php';
	require('controlador/cusuario.php');
	
	$cusuario = new CUsuario();
	
	if (isset($_POST['panel']) && $_POST['panel'] == 1) {
		if ($_SESSION['form_token'] != $_POST['form_token']) {
			require_once 'vista/formulario_panel.php';
		} else {
			$correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
			$contrasenaV = $_POST['pass'];
			$contrasenaN = $_POST['pass1'];
			
			$cusuario->modificarUsuario($correo, $contrasenaN, $contrasenaV);
			
			require_once 'vista/formulario_panel.php';
		}
	} else {
		require_once 'vista/formulario_panel.php';
	}
	
	require_once 'vista/pie.html';
?>