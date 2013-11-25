<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require_once('interfaz/cabecera.html');
?>
				<form action="index.php" method="post">
					<p>
						<label>
							Usuario
							<span class="small">M&aacute;x. 30 caracteres:</span>
						</label>
						<input type="text" name="user" maxlength="50" />
						<label>
							Correo electr&oacute;nico
							<span class="small">M&aacute;x. 100 caracteres:</span>
						</label>
						<input type="text" name="user" maxlength="100" />
						<label>
							Contrase&ntilde;a
							<span class="small">Introduzca su contrase&ntilde;a:</span>
						</label>
						<input type="password" name="pass" maxlength="40" />
						<label>
							Contrase&ntilde;a
							<span class="small">Vuelva a introducir su contrase&ntilde;a:</span>
						</label>
						<input type="password" name="pass" maxlength="40" />
						<br />
						<input type="hidden" name="login" value="1" />
						<input class="boton" type="submit" value="Registrar" />
					</p>
				</form>
<?php	
	require_once('interfaz/pie.html');
?>