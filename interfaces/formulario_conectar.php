				<div class="formulario">
					<h1>Conectar</h1>
					<form id="formularioLogin" name="formularioLogin" action="conectar.php" method="post">
						<p>
							<input id="usuario" type="text" name="usuario" maxlength="50" placeholder="Usuario" />
						</p>
						<p>
							<input id="pass" type="password" name="pass" maxlength="50" placeholder="Contrase&ntilde;a" />
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
							<input type="hidden" name="login" value="1" />
							<input class="boton" type="submit" value="Conectar" />
						</p>
					</form>
				</div>
