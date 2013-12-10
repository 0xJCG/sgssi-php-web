<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require 'interfaces/cabecera.php';
	require 'includes/cusuario.php';
	
	//Codigo Login
	if (!isset($_SESSION['codigo'])) { // Si no esta ya el usuario conectado. 
		if (isset($_POST['login']) && $_POST['login'] == 1) { // Si se ha enviado el formulario.
			if ($_SESSION['token'] != $_POST['token']) { // El formulario debe provenir de la pagina adecuada, no debe ser una copia.
				require 'interfaces/formulario_conectar.php';
			} else { // El formulario es correcto.
				$usuario = CUsuario::getCUsuario(); // Llamamos a la MAE de usuario.
				$login_successful = $usuario->login($_POST['usuario'], $_POST['pass']); // Hacemos el login.
				if ($login_successful) { // Si ha sido correcto.
					if (!empty($_SESSION['codigo'])) // La variable de sesion es correcta.
						echo "\t\t\t\t" . '<p>' . $_SESSION['nombre'] . ' se ha conectado correctamente.</p>' . "\n";
					else { // Variable de sesion no correcta.
						echo "\t\t\t\t" . '<p>Los datos introducidos son incorrectos.</p>' . "\n";
						session_destroy(); // Se destruye la sesion.
					}
				} else { // Login no efectuado.
					echo "\t\t\t\t" . '<p>No se ha podido conectar.</p>';
					session_destroy();
				}
			}
		} else // Si no se ha enviado el formulario.
			require 'interfaces/formulario_conectar.php';
	} else { // El usuario esta conectado.
		if (isset($_GET['desconectar'])) { // Ha pulsado en desconectar.
			session_destroy(); // Se destruye la sesion.
			echo "\t\t\t\t" . '<p>Te has desconectado.</p>' . "\n";
		} else { // No ha pulsado todavia en desconectar.
			echo "\t\t\t\t" . '<p>Conectado.</p>' . "\n";
			echo "\t\t\t\t" . '<p><a href="conectar.php?desconectar">Desconectar.</a></p>' . "\n";
		}
	}
	
	require 'interfaces/pie.html';
?>