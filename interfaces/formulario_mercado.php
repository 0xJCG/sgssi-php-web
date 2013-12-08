				<div class="formulario">
					<h1>A&ntilde;adir un nuevo elemento al mercado</h1>
					<form id="formularioMercado" name="formularioMercado" action="index.php" method="post">
						<p>
							<input type="text" name="titulo" maxlength="50" <?php echo (isset($titulo))?'value="' . $titulo . '"':'placeholder="T&iacute;tulo del mensaje"'; ?> />
						</p>
						<p>
							<!-- <textarea name="descripcion" rows="20" cols="80"></textare> -->
							<input type="text" name="descripcion" maxlength="1000" <?php echo (isset($descripcion))?'value="' . $descripcion . '"':'placeholder="Descripci&oacute;n del mensaje"'; ?> />
						</p>
						<p>
							<input type="file" name="imagen" />
						</p>
						<p>
<?php
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
?>
							<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
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
