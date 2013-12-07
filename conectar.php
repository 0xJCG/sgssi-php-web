<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require_once 'interfaces/cabecera.php';
	require_once 'includes/cusuario.php';
	
	//Codigo Login
	if (!isset($_SESSION['codigo'])) {
		if (isset($_POST['login']) && $_POST['login'] == 1) {
			$usuario = new CUsuario();
			$login_successful = $usuario->login($_POST['usuario'], $_POST['pass']);
			if ($login_successful) {
				if (!empty($_SESSION['codigo']))
					echo "\t\t\t\t" . '<p>' . $_SESSION['nombre'] . ' se ha conectado correctamente.</p>' . "\n";
				else {
					echo "\t\t\t\t" . '<p>Los datos introducidos son incorrectos.</p>' . "\n";
					session_destroy();
				}
			} else {
				echo "\t\t\t\t" . '<p>No se ha podido conectar.</p>';
				session_destroy();
			}
		} else
			require_once('interfaces/formulario_conectar.html');
	} else {
		if (isset($_GET['desconectar'])) {
			session_destroy();
			echo "\t\t\t\t" . '<p>Te has desconectado.</p>' . "\n";
		} else {
			echo "\t\t\t\t" . '<p>Conectado.</p>' . "\n";
			echo "\t\t\t\t" . '<p><a href="conectar.php?desconectar">Desconectar.</a></p>' . "\n";
		}
	}
	
	require_once 'interfaces/pie.html';
?>