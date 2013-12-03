<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require_once 'vista/cabecera.html';
	require_once 'vista/formulario_conectar.html';
?>
		<!--
		<noscript>
			<p>Tu navegador no soporta JavaScript o lo tiene deshabilitado. Necesita JavaScript para poder utilizar esta p&aacute;gina web.</p>
		</noscript>
		-->
<?php
	require_once 'vista/pie.html';
?>