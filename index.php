<?php
	session_start(); // Iniciamos sesion.
	
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
	
	/******************************************/
	/* Utilizamos UTF-8 para codificar los    */
	/* caracteres y evitar problemas con las  */
	/* tildes.                                */
	/******************************************/
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	/******************************************/
	/* Clases que necesitamos para nuestras   */
	/* funciones.                             */
	/******************************************/
	require 'interfaces/cabecera.php'; // Cabecera del html.
	require 'includes/cmercado.php';
	require 'includes/inputfilter.php';
?>
				<noscript>
					<p>Su navegador no soporta JavaScript o lo tiene deshabilitado. Necesita JavaScript para poder utilizar esta p&aacute;gina web de manera correcta.</p>
				</noscript>
<?php
	if (isset($_SESSION['nombre'])) { // Si el usuario esta conectado podra ver el contenido.
		/******************************************/
		/* Creamos dos nuevas variables que nos   */
		/* serviran para acceder a las funciones. */
		/******************************************/
		$mercado = CMercado::getCMercado();
		$filtro = new InputFilter();
		
		/******************************************/
		/* Procesamiento de ofertas.              */
		/* Procesamos los formularios de ofertas. */
		/******************************************/
		if (isset($_POST['anadir'])) { // Cualquiera que este logueado en el sistema puede anadir nuevos elementos.
			/* Procesamos el titulo y la descripcion para eliminar posibles elementos no deseados en ellos. No debemos fiarnos del usuario. */
			$titulo = $filtro->process($_POST['titulo']);
			$descripcion = $filtro->process($_POST['descripcion']);
			$mercado->anadirOferta($titulo, $descripcion);
		} elseif (isset($_POST['modificar'])) {
			$codigoOferta = $_POST['modificar'];
			$usuarioOferta = $mercado->getUsuarioOferta($codigoOferta); // Cogemos el usuario que ha escrito la oferta.
			if ($usuarioOferta == $_SESSION['codigo'] || $_SESSION['tipo'] == 1) { // Si el usuario que ha pedido modificar la oferta es el mismo que la ha escrito, o ha sido el administrador, modificaremos la oferta.
				/* Procesamos el titulo y la descripcion para eliminar posibles elementos no deseados en ellos. No debemos fiarnos del usuario. */
				$titulo = $filtro->process($_POST['titulo']);
				$descripcion = $filtro->process($_POST['descripcion']);
				$mercado->modificarOferta($titulo, $descripcion, $_POST['modificar']);
			} else
				header('Location: index.php');
		} elseif (isset($_GET['eliminar']) && ctype_digit($_GET['eliminar'])) {
			$codigoOferta = $_GET['eliminar'];
			$usuarioOferta = $mercado->getUsuarioOferta($codigoOferta); // Cogemos el usuario que ha escrito la oferta.
			if ($usuarioOferta == $_SESSION['codigo'] || $_SESSION['tipo'] == 1) // Si el usuario que ha pedido elimimar la oferta es el mismo que la ha escrito, o ha sido el administrador, eliminaremos la oferta.
				$mercado->eliminarOferta($codigoOferta);
			else
				header('Location: index.php');
		}
		
		/******************************************/
		/* Pedimos a la base de datos las 10      */
		/* ofertas que queremos sacar por         */
		/* pantalla.                              */
		/******************************************/
		if (isset($_GET['pagina']) && ctype_digit($_GET['pagina'])) { // La pagina debe ser un numero.
			$desde = ($_GET['pagina'] - 1) * 5; // Variable en la que indicaremos desde que registro queremos mostrar ofertas por pantalla.
			$datosMercado = $mercado->getMercado($desde); // Pedimos a la base de datos las ofertas disponibles.
		} else // Si no ha pedido ninguna pagina en especial o no es un numero, sacamos las 5 primeras ofertas por defecto.
			$datosMercado = $mercado->getMercado(0);
		
		/******************************************/
		/* Mostramos dichas ofertas por pantalla. */
		/* - \t: es una tabulacion. Es para       */
		/*       indentar el codigo cuando se     */
		/*       muestra el codigo fuente de      */
		/*       una web.                         */
		/* - \n: es un salto de linea en el       */
		/*       codigo fuente.                   */
		/******************************************/
		$limite = count($datosMercado);
		if ($limite > 0) { // De no  haber ofertas, mostraremos un "error".
			for ($i = 0; $i < $limite; $i++) { // Esto muestra el html de las ofertas.
				echo "\t\t\t\t" . '<div class="mensaje">' . "\n";
				echo "\t\t\t\t\t" . '<div class="datos_mensaje">' . "\n";
				echo "\t\t\t\t\t\t" . '<p><img src="imagenes/usuario.png" /> ' . $datosMercado[$i][3] . '</p>' . "\n";
				echo "\t\t\t\t\t\t" . '<p><img src="imagenes/telefono.png" /> ' . $datosMercado[$i][4] . '</p>' . "\n";
				echo "\t\t\t\t\t\t" . '<p><img src="imagenes/fecha.png" /> ' . $datosMercado[$i][6] . '</p>' . "\n";
				echo "\t\t\t\t\t" . '</div>' . "\n";
				echo "\t\t\t\t\t" . '<div class="cuerpo_mensaje">' . "\n";
				echo "\t\t\t\t\t\t" . '<h2>' . $datosMercado[$i][1] . '</h2>' . "\n";
				echo "\t\t\t\t\t\t" . '<p>' . $datosMercado[$i][2] . '</p>' . "\n";
				if ($datosMercado[$i][5] != null) { // De haber imagen, la sacamos.
					$ruta = 'imagenes/ofertas/' . $datosMercado[$i][5];
					echo "\t\t\t\t\t\t" . '<img class="imagenOferta" src="' . $ruta . '" />' . "\n";
				}
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
		} else // No hay ofertas.
			echo "\t\t\t\t" . '<p id="error">Todav&iacute;a no hay ofertas.</p>' . "\n";
		
		/******************************************/
		/* Mostramos la paginacion.               */
		/******************************************/
		echo "\t\t\t\t" . '<div id="paginas">' . "\n";
		echo "\t\t\t\t\t" . '<p>' . "\n";
		$totalPaginas = $mercado->getNumeroOfertas() / 5; // Entre 5 para sacar el numero de paginas de 5 ofertas que tenemos en total.
		for ($i = 0; $i < $totalPaginas; $i++) {
			echo "\t\t\t\t\t\t" . '<a href="index.php?pagina=' . ($i + 1) . '">' . ($i + 1) . '</a>' . "\n";
		}
		echo "\t\t\t\t\t" . '</p>' . "\n";
		echo "\t\t\t\t" . '</div>' . "\n";
		
		/******************************************/
		/* Mostramos el formulario para anadir o  */
		/* modificar ofertas, siempre y cuando el */
		/* usuario este debidamente conectado.    */
		/******************************************/
		if (isset($_GET['modificar']) && ctype_digit($_GET['modificar'])) { // Si el usuario ha pedido modificar una oferta, hay que asegurarse que ese usuario tenga permisos.
			$codigoOferta = $_GET['modificar'];
			$usuarioOferta = $mercado->getUsuarioOferta($codigoOferta); // Cogemos el usuario original que ha escrito la oferta.
			if ($usuarioOferta == $_SESSION['codigo'] || $_SESSION['tipo'] == 1) { // Si el usuario que ha pedido modificar la oferta es el mismo que la ha escrito, o ha sido el administrador, mostraremos el formulario.
				$datosOferta = $mercado->getDatosOferta($codigoOferta);
					$tituloOf = $datosOferta[0][0];
					$descripcionOf = $datosOferta[0][1];
			}
		}
		/* Si no ha pedido modificar nada, mostraremos el formulario de anadir oferta. */
		require 'interfaces/formulario_mercado.php';
	} else // Si no esta conectado, aparecera un mensaje de error.
		echo "\t\t\t\t" . '<p id="error">Necesitas estar conectado para poder ver las ofertas publicadas.</p>' . "\n";

	/******************************************/
	/* Mostramos el pie de la pagina web.     */
	/******************************************/
	require 'interfaces/pie.html';
?>
