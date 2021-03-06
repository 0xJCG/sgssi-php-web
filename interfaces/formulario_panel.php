				<div class="formulario">
					<h1>Panel de usuario</h1>
<?php 
	if (isset($error)) { // Mostramos los errores por pantalla, de haberlos.
		echo "\t\t\t\t\t" . '<p id="error">' . $error . '</p>' . "\n";
	}
	if (isset($aviso)) { // Mostramos los avisos por pantalla, de haberlos.
		echo "\t\t\t\t\t" . '<p id="aviso">' . $aviso . '</p>' . "\n";
	}
	
	/* Desciframos la cuenta bancaria. */
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
	$iv_size = mcrypt_enc_get_iv_size($cipher);
	
	$key = substr(sha1($_SESSION['sal']), 0, 32);
	$iv =  substr(sha1(intval($_SESSION['nombre']) * $_SESSION['telefono'] / 2), 0, 32);
	
	if (mcrypt_generic_init($cipher, $key, $iv) != -1) {
		$cbancaria = mdecrypt_generic($cipher, hex2bin($_SESSION['cbancaria']));
		mcrypt_generic_deinit($cipher);
	}
?>
					<form id="formularioPanel" name="formularioPanel" action="panel.php" method="post">
						<p>
							<input type="text" name="usuario" maxlength="50" value="<?php echo $_SESSION['nombre']; ?>" disabled="disabled" />
						</p>
						<p>
							<input type="text" name="correo" value="<?php echo $_SESSION['correo']; ?>" maxlength="100" />
						</p>
						<p>
							<input type="text" name="telefono" maxlength="9" value="<?php echo $_SESSION['telefono']; ?>" placeholder="Tel&eacute;fono" />
						</p>
						<p>
							Cuenta actual: ****************<?php echo substr($cbancaria, 16, 20); ?>.
						</p>
						<p>
							<input type="text" name="cbancaria" maxlength="20" placeholder="Nueva cuenta bancaria" />
						</p>
						<p>
							<input id="pass" type="password" name="pass" maxlength="50" placeholder="Actual contrase&ntilde;a" />
						</p>
						<p>
							<input id="pass1" type="password" name="pass1" maxlength="50" placeholder="Nueva contrase&ntilde;a" />
						</p>
						<p>
							<input id="pass2" type="password" name="pass2" maxlength="50" placeholder="Vuelva a escribir la nueva contrase&ntilde;a" />
						</p>
						<p>
<?php
	/********************************************************************************/
	/* Realizamos un token para evitar el Cross Site Request Forgery.               */
	/* Solo validaremos el formulario si ha sido enviado desde la propia web.       */
	/* Para ello, mas adelante se comprobara que este token sea el correcto,        */
	/* por lo que lo pondremos en el formulario actual y en una variable de sesion. */
	/* Este token sera aleatorio.                                                   */
	/********************************************************************************/
	$token = md5(uniqid('auth', true));
	$_SESSION['token'] = $token;
?>
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
							<input type="hidden" name="panel" value="1" />
							<input class="boton" type="submit" value="Modificar" />
						</p>
					</form>
				</div>
