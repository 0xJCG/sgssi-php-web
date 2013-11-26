<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require_once 'vista/cabecera.html';
	
	//Codigo Login
	if (!isset($_SESSION['codigo'])) {
		if (isset($_POST['login']) && $_POST['login'] == 1) {
			require('controlador/conexiones.php');
			$cn = new Connection();
			$salt = $cn->queryScalar("SELECT sal FROM usuarios WHERE nombre = ?", array($_POST['user']));
			$login_successful = $cn->login($_POST['user'], hash("sha512", hash("sha512", $_POST['pass']) . $salt));
			if ($login_successful) {
				if (!empty($_SESSION['codigo']))
					echo "\t\t\t\t" . '<p>Se ha conectado correctamente.</p>' . "\n";
				else {
					echo "\t\t\t\t" . '<p>Los datos introducidos son incorrectos.</p>' . "\n";
					session_destroy();
				}
			} else {
				echo "\t\t\t\t" . '<p>No se ha podido conectar.</p>';
				session_destroy();
			}
		} else
			require_once('vista/formulario_conectar.html');
	} else {
		if (isset($_GET['desconectar'])) {
			session_destroy();
			echo "\t\t\t\t" . '<p>Te has desconectado.</p>' . "\n";
		} else {
			echo "\t\t\t\t" . '<p>Conectado.</p>' . "\n";
			echo "\t\t\t\t" . '<p><a href="conectar.php?desconectar">Desconectar.</a></p>' . "\n";
		}
	}
	
	require_once 'vista/pie.html';
?>