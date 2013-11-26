<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require_once 'vista/cabecera.html';
	require_once 'vista/formulario_registro.html';
	
	//$salt = substr(sha1(mt_rand()),0,22); salt
	
	require_once 'vista/pie.html';
?>