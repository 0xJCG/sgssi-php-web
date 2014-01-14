<?php
	session_start();
	
	/******************************************/
	/* Si han pasado 5 minutos desde la       */
	/* ultima vez que el usuario ha           */
	/* interactuado con la web, se destruye   */
	/* la sesion como medida de seguridad.    */
	/******************************************/
	if (isset($_SESSION['tiempo']) && time() > $_SESSION['tiempo'] + 300) {
		session_destroy();
	} else
		$_SESSION['tiempo'] = time();
	
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);
	
	require 'interfaces/cabecera.php';
	
	if (!isset($_SESSION['codigo'])) { // Si el usuario no esta conectado.
		if (isset($_POST['registro']) && $_POST['registro'] == 1) { // Si se ha pulsado en el boton de registrar.
			if ($_SESSION['token'] != $_POST['token']) // Si el token del formulario no coincide con el de la sesion, es que el formulario no se ha enviado desde el lugar correcto.
				$error = "El formulario se ha enviado desde un lugar no apropiado.";
			else {
				$contrasena1 = $_POST['pass1'];
				$contrasena2 = $_POST['pass2'];
				
				if ($contrasena1 === $contrasena2) { // Comprobamos que las contrasenas coincidan para poder continuar.
					/* Filtramos los input del formulario. */
					$usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
					$correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
					$telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
					$cbancaria = filter_var($_POST['cbancaria'], FILTER_SANITIZE_STRING);
					
					/* Volvemos a filtrar el usuario por si ha metido alguna etiqueta no deseable, para evitar el XSS. */
					require 'includes/inputfilter.php';
					$filtro = new InputFilter();
					$usuario = $filtro->process($usuario);
					
					/* Creamos la sal propia para el usuario. */
					$sal = hash("sha512", substr(sha1(mt_rand()), 0, 22)); // Sal.
					
					/* Llamamos a la clase que contiene los metodos de los usuarios. */
					require 'includes/cusuario.php';
					$cusuario = CUsuario::getCUsuario();
					
					/* Ciframos la cuenta bancaria. */
					$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
					$iv_size = mcrypt_enc_get_iv_size($cipher);
					
					$key = substr(sha1($sal), 0, 32);
					$iv =  substr(sha1(intval($usuario) * $telefono / 2), 0, 32);
					
					if (mcrypt_generic_init($cipher, $key, $iv) != -1) {
						$encrypted = mcrypt_generic($cipher, $cbancaria);
						mcrypt_generic_deinit($cipher);
						$cbancaria = bin2hex($encrypted);
						
						$usuarioRegistrado = $cusuario->registrar($usuario, $correo, $telefono, $cbancaria, $contrasena1, $sal);
						
						if ($usuarioRegistrado) // Comprobamos que el usuairo se haya registrado correctamente.
							header('Location: panel.php');
						else // El registro ha fallado.
							$error = "El nombre de usuario o la contrase&ntilde;a ya est&aacute;n en uso.";
					} else
						$error = "Ha habido un error a la hora de realizar el registro.";
				} else // Las contrasenas no coinciden.
					$error = "Las contrase&ntilde;as no coinciden.";
			}
		}
	} else // El usuario esta conectado.
		header('Location: panel.php');
	
	require 'interfaces/formulario_registro.php';	
	require 'interfaces/pie.html';
?>