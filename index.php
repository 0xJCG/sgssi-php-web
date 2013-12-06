<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require_once 'vista/cabecera.php';
	require('controlador/conexiones.php');
	
	$cn = new Connection();
	$rs = $cn->query("SELECT titulo, mensaje, nombre, fecha FROM mercado, usuarios WHERE mercado.usuario = usuarios.codigo", array());
	
	for ($i = 0; $i < count($rs); $i++) {
		echo '<div class="mensaje">';
		if ($_SESSION['nombre'] == $rs[$i][2])
			echo '<p class="opciones">Modificar. Eliminar.</p>';
		echo '<h2>' . $rs[$i][0] . '</h2>';		
		echo '<p>Por ' . $rs[$i][2] . ', el ' . $rs[$i][3] . '</p>';
		echo '<p>' . $rs[$i][1] . '</p>';
		echo "</div>";
	}
	
	if (isset($_SESSION['codigo']))
		require_once 'vista/formulario_mercado.php';
?>
		<noscript>
			<p>Su navegador no soporta JavaScript o lo tiene deshabilitado. Necesita JavaScript para poder utilizar esta p&aacute;gina web.</p>
		</noscript>
<?php
	require_once 'vista/pie.html';
?>