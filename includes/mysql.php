<?php
	require 'datos.php'; // Fichero en el que tenemos los datos para poder conectarnos con la base de datos.
	
	/* Clase con patron de diseno Singleton. */
	class MySQL {
		private $_conexion;
		private static $_miMySQL; // Variable estatica en la que guardaremos la unica instancia de esta clase.
		
		private function __construct() { // Nos conectamos con la base de datos.
			$this->_conexion = new mysqli(HOST, USER, PASS, DB); // Los datos los cogemos del fichero que hemos requerido.
		}
		
		public static function getMySQL() { // Metodo que nos deja acceder a la unica instancia de esta clase.
			if (!self::$_miMySQL)
				self::$_miMySQL = new MySQL();
			return self::$_miMySQL;
		}
		
		public function getErrorNo() { // Número del error que hayamos tenido.
			return mysqli_errno($this->_conexion);
		}
		
		public function getError() { // Error que hayamos tenido.
			return mysqli_error($this->_conexion);
		}
		
		public function ejecutar($sentencia) { // Realizamos una sentencia SQL con la base de datos.
			return mysqli_query($this->_conexion, $sentencia);
		}
		
		public function recogerResultado($resultado) {  // Recogemos el resultado de una sentencia.
			return mysqli_fetch_array($resultado);
		}
		
		public function estaConectada() { // Comprobamos la conexión con la base de datos.
			return !is_null($this->_conexion);
		}
		
		public function escapar($parametro) { // Escapamos los caracteres extraños que pueda tener una sentencia.
			return mysqli_real_escape_string($this->_conexion, $parametro);
		}
	}
?>