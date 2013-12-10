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
	
	/* Parte del procesamiento de ofertas. */
	if (isset($_SESSION['codigo'])) { // Evitamos que el que no este logueado en el sistema pueda hacer cosas.
		if (isset($_POST['anadir'])) { // Cualquiera que este logueado en el sistema puede anadir nuevos elementos.
			/* Procesamos el titulo y la descripcion para eliminar posibles elementos no deseados en ellos. No debemos fiarnos del usuario. */
			$titulo = $filtro->process($_POST['titulo']);
			$descripcion = $filtro->process($_POST['descripcion']);
			$mercado->anadirOferta($titulo, $descripcion, $_POST['imagen']);
		} elseif (isset($_POST['modificar'])) {
			$codigoOferta = $_POST['modificar'];
			$usuarioOferta = $mercado->getUsuarioOferta($codigoOferta); // Cogemos el usuario que ha escrito la oferta.
			if ($usuarioOferta == $_SESSION['codigo'] || $_SESSION['tipo'] == 1) { // Si el usuario que ha pedido modificar la oferta es el mismo que la ha escrito, o ha sido el administrador, modificaremos la oferta.
				/* Procesamos el titulo y la descripcion para eliminar posibles elementos no deseados en ellos. No debemos fiarnos del usuario. */
				$titulo = $filtro->process($_POST['titulo']);
				$descripcion = $filtro->process($_POST['descripcion']);
				$mercado->modificarOferta($titulo, $descripcion, $_POST['imagen'], $_POST['modificar']);
			} else
				echo "\t\t\t\t" . '<p class="error">No se ha podido realizar la acci&oacute;n.</p>' . "\n";
		} elseif (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
			$codigoOferta = $_GET['eliminar'];
			$usuarioOferta = $mercado->getUsuarioOferta($codigoOferta); // Cogemos el usuario que ha escrito la oferta.
			if ($usuarioOferta == $_SESSION['codigo'] || $_SESSION['tipo'] == 1) // Si el usuario que ha pedido elimimar la oferta es el mismo que la ha escrito, o ha sido el administrador, eliminaremos la oferta.
				$mercado->eliminarOferta($codigoOferta);
			else
				echo "\t\t\t\t" . '<p class="error">No se ha podido realizar la acci&oacute;n.</p>' . "\n";
		}
	}
	
	/* Pedimos a la base de datos las 10 ofertas que queremos sacar por pantalla. */
	if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
		$desde = ($_GET['pagina'] - 1) * 5; // Variable en la que indicaremos desde que registro queremos mostrar ofertas por pantalla.
		$datosMercado = $mercado->getMercado($desde); // Pedimos a la base de datos las ofertas disponibles.
	} else // Si no ha pedido ninguna pagina en especial, sacamos las 5 primeras ofertas.
		$datosMercado = $mercado->getMercado(0);
	
	/* Mostramos dichas ofertas por pantalla. */
	/* - \t: es una tabulacion. Es para indentar el codigo cuando se muestra el codigo fuente de una web. */
	/* - \n: es un salto de linea en el codigo fuente. */
	$limite = count($datosMercado);
	if ($limite > 0) { // De no  haber ofertas, mostraremos un "error".
		for ($i = 0; $i < $limite; $i++) {
			echo "\t\t\t\t" . '<div class="mensaje">' . "\n";
			echo "\t\t\t\t\t" . '<div class="datos_mensaje">' . "\n";
			echo "\t\t\t\t\t\t" . '<p><img src="imagenes/usuario.png" /> ' . $datosMercado[$i][3] . '</p>' . "\n";
			echo "\t\t\t\t\t\t" . '<p><img src="imagenes/fecha.png" /> ' . $datosMercado[$i][4] . '</p>' . "\n";
			echo "\t\t\t\t\t" . '</div>' . "\n";
			echo "\t\t\t\t\t" . '<div class="cuerpo_mensaje">' . "\n";
			echo "\t\t\t\t\t\t" . '<h2>' . $datosMercado[$i][1] . '</h2>' . "\n";
			echo "\t\t\t\t\t\t" . '<p>' . $datosMercado[$i][2] . '</p>' . "\n";
			echo "\t\t\t\t\t" . '</div>' . "\n";
			if ((isset($_SESSION['nombre']) && $_SESSION['nombre'] == $datosMercado[$i][3]) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1)) {
				echo "\t\t\t\t\t" . '<div class="clear"></div>' . "\n";
				echo "\t\t\t\t\t" . '<div class="opciones_admin">' . "\n";
				echo "\t\t\t\t\t\t" . '<a href="index.php?modificar=' . $datosMercado[$i][0] . '"><img src="imagenes/modificar.png" /></a>' . "\n";
				echo "\t\t\t\t\t\t" . '<a href="index.php?eliminar=' . $datosMercado[$i][0] . '"><img src="imagenes/eliminar.png" /></a>' . "\n";
				echo "\t\t\t\t\t" . '</div>' . "\n";
			}
			echo "\t\t\t\t\t" . '<div class="clear"></div>' . "\n";
			echo "\t\t\t\t" . '</div>' . "\n";
		}
	} else
		echo "\t\t\t\t" . '<p class="error">No hay ofertas o la p&aacute;gina seleccionada no existe.</p>' . "\n";
	
	/* Mostramos la paginacion tras las ofertas. */
	echo "\t\t\t\t" . '<div id="paginas">' . "\n";
	echo "\t\t\t\t\t" . '<p>' . "\n";
	$totalPaginas = $mercado->getNumeroOfertas() / 5; // Entre 5 para sacar el numero de paginas de 5 ofertas que tenemos en total.
	for ($i = 0; $i < $totalPaginas; $i++) {
		echo "\t\t\t\t\t\t" . '<a href="index.php?pagina=' . ($i + 1) . '">' . ($i + 1) . '</a>' . "\n";
	}
	echo "\t\t\t\t\t" . '</p>' . "\n";
	echo "\t\t\t\t" . '</div>' . "\n";
	
	/* Si el usuario esta logueado en el sistema, podra modificar una oferta suya o anadir una nueva. */
	if (isset($_SESSION['codigo'])) {
		if (isset($_GET['modificar'])) { // Si el usuario ha pedido modificar una oferta, hay que asegurarse que ese usuario tenga permisos.
			$codigoOferta = $_GET['modificar'];
			$usuarioOferta = $mercado->getUsuarioOferta($codigoOferta); // Cogemos el usuario original que ha escrito la oferta.
			if ($usuarioOferta == $_SESSION['codigo'] || $_SESSION['tipo'] == 1) { // Si el usuario que ha pedido modificar la oferta es el mismo que la ha escrito, o ha sido el administrador, mostraremos el formulario.
				$datosOferta = $mercado->getDatosOferta($codigoOferta);
				$tituloOf = $datosOferta[0][0];
				$descripcionOf = $datosOferta[0][1];
			} else
				echo "\t\t\t\t" . '<p class="error">No tienes permisos para modificar la oferta seleccionada.</p>' . "\n";
		}
		/* Si no ha pedido modificar nada, mostraremos el formulario de anadir oferta. */
		require 'interfaces/formulario_mercado.php';
	}

	require 'interfaces/pie.html';
?>