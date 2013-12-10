				<div class="formulario">
					<h1>A&ntilde;adir un nuevo elemento al mercado</h1>
					<form id="formularioMercado" name="formularioMercado" action="index.php" method="post">
						<p>
							<input type="text" name="titulo" maxlength="50" <?php echo (isset($tituloOf))?'value="' . $tituloOf . '"':'placeholder="T&iacute;tulo del mensaje"'; ?> />
						</p>
						<p>
							<!-- <textarea name="descripcion" rows="20" cols="80"></textare> -->
							<input type="text" name="descripcion" maxlength="1000" <?php echo (isset($descripcionOf))?'value="' . $descripcionOf . '"':'placeholder="Descripci&oacute;n del mensaje"'; ?> />
						</p>
						<div id='espacio_seleccionar_imagen'>
							<input id='seleccionar_imagen' type="file" name="imagen" />
						</div>
						<p>
<?php
	/* Realizamos un token para evitar el Cross Site Request Forgery. */
	/* Solo validaremos el formulario si ha sido enviado desde la propia web. */
	/* Para ello, mas adelante se comprobara que este token sea el correcto, por lo que lo pondremos en el formulario actual y en una variable de sesion. */
	/* Este token sera aleatorio. */
	$token = md5(uniqid('auth', true));
	$_SESSION['token'] = $token;
?>
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
<?php
	if (isset($_GET['modificar']))
		echo "\t\t\t\t\t\t\t" . '<input type="hidden" name="modificar" value="' . $codigoOferta .'" />' . "\n";
	else
		echo "\t\t\t\t\t\t\t" . '<input type="hidden" name="anadir" value="1" />' . "\n";
?>
							<input class="boton" name="enviar" type="submit" value="Enviar" />
						</p>
					</form>
				</div>
