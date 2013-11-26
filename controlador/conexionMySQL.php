<?php
	require_once 'datos.php'; // Fichero en el que tenemos los datos para poder conectarnos con la base de datos.
	
	class ConexionMySQL {
		private $conexion;
		
		public function __construct() { // Nos conectamos con la base de datos.
			$this->conexion = new mysqli(HOST, USER, PASS, DB); // Los datos los cogemos del fichero que hemos requerido.
		}
		
		public function getErrorNo() { // Número del error que hayamos tenido.
			return mysqli_errno($this->conexion);
		}
		
		public function getError() { // Error que hayamos tenido.
			return mysqli_error($this->conexion);
		}
		
		public function ejecutar($sentencia) { // Realizamos una sentencia SQL con la base de datos.
			return mysqli_query($this->conexion, $sentencia);
		}
		
		public function recogerResultado($resultado) {  // Recogemos el resultado de una sentencia.
			return mysqli_fetch_array($resultado);
		}
		
		public function estaConectada() { // Comprobamos la conexión con la base de datos.
			return !is_null($this->conexion);
		}
		
		public function escapar($parametro) { // Escapamos los caracteres extraños que pueda tener una sentencia.
			return mysqli_real_escape_string($this->conexion, $parametro);
		}
	}
?>