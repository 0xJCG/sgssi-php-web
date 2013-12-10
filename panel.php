<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);
	
	require 'interfaces/cabecera.php';
	require 'includes/cusuario.php';
	
	$cusuario = CUsuario::getCUsuario();
	
	if (isset($_SESSION['codigo'])) { // Solo dejaremos acceder al panel de usuario a los usuarios logueado en el sistema.
		if (isset($_POST['panel']) && $_POST['panel'] == 1) { // Si se ha pulsado el formulario.
			if ($_SESSION['token'] != $_POST['token']) { // El formulario debe provenir de la pagina adecuada, no debe ser una copia.
				require 'interfaces/formulario_panel.php';
			} else { // El formulario es correcto.
				if ($_POST['pass1'] == $_POST['pass2']) { // Si se modifica la contrasena, estas deben coincidir. Si no se modifican, esta condicion siempre sera TRUE.
					/* Filtramos los input. */
					$correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
					$telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
					$contrasenaV = $_POST['pass'];
					$contrasenaN = $_POST['pass1'];
					
					/* Modificamos el usuario. */
					$cusuario->modificarUsuario($correo, $telefono, $contrasenaN, $contrasenaV);
					
					echo "\t\t\t\t" . '<p class="ok">Datos modificados.</p>' . "\n";
				}
				require 'interfaces/formulario_panel.php';
			}
		} else {
			require 'interfaces/formulario_panel.php';
		}
	} else
		echo "\t\t\t\t" . '<p class="error">No tienes permisos para acceder a esta secci&oacute;n.</p>' . "\n";
	
	require 'interfaces/pie.html';
?>