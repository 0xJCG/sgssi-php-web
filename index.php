<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require 'interfaces/cabecera.php';
	require 'includes/cmercado.php';
	require 'includes/inputfilter.php';
?>
				<noscript>
					<p>Su navegador no soporta JavaScript o lo tiene deshabilitado. Necesita JavaScript para poder utilizar esta p&aacute;gina web de manera correcta.</p>
				</noscript>
<?php
	$mercado = CMercado::getCMercado();
	$filtro = new InputFilter();
	
	if (isset($_SESSION['codigo'])) { // Evitamos que el que no este logueado en el sistema pueda hacer cosas.
		if (isset($_POST['anadir'])) { // Cualquiera que este logueado en el sistema puede anadir nuevos elementos.
			/* Procesamos el titulo y la descripcion para eliminar posibles elementos no deseados en ellos. No debemos fiarnos del usuario. */
			$titulo = $filtro->process($_POST['titulo']);
			$descripcion = $filtro->process($_POST['descripcion']);
			$mercado->anadirOferta($titulo, $descripcion, $_POST['imagen']);
		} elseif (isset($_POST['modificar'])) {
			$codigoOferta = $_GET['modificar'];
			$usuarioOferta = $mercado->getUsuarioOferta($codigoOferta); // Cogemos el usuario que ha escrito la oferta.
			if ($usuarioOferta == $_SESSION['codigo'] || $_SESSION['tipo'] == 1) { // Si el usuario que ha pedido modificar la oferta es el mismo que la ha escrito, o ha sido el administrador, modificaremos la oferta.
				/* Procesamos el titulo y la descripcion para eliminar posibles elementos no deseados en ellos. No debemos fiarnos del usuario. */
				$titulo = $filtro->process($_POST['titulo']);
				$descripcion = $filtro->process($_POST['descripcion']);
				$mercado->modificarOferta($titulo, $descripcion, $_POST['imagen'], $_POST['modificar']);
			} else
				echo "\t\t\t\t" . '<p class="error">No se ha podido realizar la acci&oacute;n.</p>' . "\n";
		} elseif (isset($_GET['eliminar'])) {
			$codigoOferta = $_GET['eliminar'];
			$usuarioOferta = $mercado->getUsuarioOferta($codigoOferta); // Cogemos el usuario que ha escrito la oferta.
			if ($usuarioOferta == $_SESSION['codigo'] || $_SESSION['tipo'] == 1) // Si el usuario que ha pedido elimimar la oferta es el mismo que la ha escrito, o ha sido el administrador, eliminaremos la oferta.
				$mercado->eliminarOferta($codigoOferta);
			else
				echo "\t\t\t\t" . '<p class="error">No se ha podido realizar la acci&oacute;n.</p>' . "\n";
		}
	}
	
	$datosMercado = $mercado->getMercado();
	
	$limite = count($datosMercado);
	for ($i = 0; $i < $limite; $i++) {
		echo "\t\t\t\t" . '<div class="mensaje">' . "\n";
		if ((isset($_SESSION['nombre']) && $_SESSION['nombre'] == $datosMercado[$i][3]) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1))
			echo "\t\t\t\t\t" . '<p class="opciones"><a href="index.php?modificar=' . $datosMercado[$i][0] . '">Modificar</a> <a href="index.php?eliminar=' . $datosMercado[$i][0] . '">Eliminar</a></p>' . "\n";
		echo "\t\t\t\t\t" . '<h2>' . $datosMercado[$i][1] . '</h2>' . "\n";		
		echo "\t\t\t\t\t" . '<p>Por ' . $datosMercado[$i][3] . ', el ' . $datosMercado[$i][4] . '</p>' . "\n";
		echo "\t\t\t\t\t" . '<p>' . $datosMercado[$i][2] . '</p>' . "\n";
		echo "\t\t\t\t" . '</div>' . "\n";
	}
	
	if (isset($_SESSION['codigo'])) {
		if (isset($_GET['modificar'])) {
			$datosOferta = $mercado->getDatosOferta($_GET['modificar']);
			$titulo = $datosOferta[0][0];
			$descripcion = $datosOferta[0][1];
		}
		require 'interfaces/formulario_mercado.php';
	}

	require 'interfaces/pie.html';
?>