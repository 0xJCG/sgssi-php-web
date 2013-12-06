<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);
	
	require_once 'vista/cabecera.php';
	require('controlador/conexiones.php');
	$cn = new Connection();
	
	if (isset($_POST['modificado']) && $_POST['modificado'] == 1) {
		if ($_SESSION['form_token'] != $_POST['form_token']) {
			$rs = $cn->query("SELECT nombre, correo FROM usuarios WHERE codigo = ?", array($_SESSION['codigo']));
			require_once 'vista/formulario_panel.php';
		} else {
			$correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
			$contrasenaV = $_POST['pass'];
			$contrasenaN = $_POST['pass1'];
			
			$cn->modificarUsuario($correo, $contrasenaN, $contrasenaV);
			
			$rs = $cn->query("SELECT nombre, correo FROM usuarios WHERE codigo = ?", array($_SESSION['codigo']));
			
			require_once 'vista/formulario_panel.php';
		}
	} else {
		$rs = $cn->query("SELECT nombre, correo FROM usuarios WHERE codigo = ?", array($_SESSION['codigo']));
		require_once 'vista/formulario_panel.php';
	}
	
	require_once 'vista/pie.html';
?>