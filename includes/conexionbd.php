<?php
	require 'mysql.php'; // Fichero en el que tenemos las clases y métodos para poder conectarnos a nuestra base de datos de MySQL.
	
	class ConexionBD {
		private $_mySQL;
		private $_parametros;
		private static $_miConexionBD; // Variable estatica en la que guardaremos la unica instancia de esta clase.
		
		private function __construct() {
			$this->_mySQL = MySQL::getMySQL();
			if (!$this->_mySQL->estaConectada()) {
				throw new Exception("La conexi&oacute;n a la base de datos no se ha completado.");
			}
		}
		
		public static function getConexionBD() { // Metodo que nos deja acceder a la unica instancia de esta clase.
			if (!self::$_miConexionBD)
				self::$_miConexionBD = new ConexionBD();
			return self::$_miConexionBD;
		}
		
		private function _replaceParams($coincidencias) {
			$b = current($this->_parametros);
			next($this->_parametros); 
			return $b;
		}
		
		private function _prepare($sql, $parametros) {
			for ($i = 0; $i < sizeof($parametros); $i++) {
				if (is_bool($parametros[$i]))
					$parametros[$i] = $parametros[$i]?1:0;
				elseif (is_double($parametros[$i]))
					$parametros[$i] = str_replace(',', '.', $parametros[$i]);
				elseif (is_numeric($parametros[$i]))
					$parametros[$i] = $this->_mySQL->escapar($parametros[$i]);
				elseif (is_null($parametros[$i]))
					$parametros[$i] = "NULL";
				else
					$parametros[$i] = "'" . $this->_mySQL->escapar($parametros[$i]) . "'";
			}
			$this->_parametros = $parametros;
			$q = preg_replace_callback("/(\?)/i", array($this, "_replaceParams"), $sql);
			return $q;
		}
		
		private function _sendQuery($q, $parametros) {
			$query = $this->_prepare($q, $parametros);
			$result = $this->_mySQL->ejecutar($query);
			if ($this->_mySQL->getErrorNo()) {
				throw new Exception("Ha habido un problema a la hora de realizar la sentencia SQL.");
			}
			return $result;
		}
		
		public function executeScalar($q, $parametros=null) {
			$result = $this->_sendQuery($q, $parametros);
			if (!is_null($result)) {
				if (!is_object($result))
					return $result;
				else {
					$row = $this->_mySQL->recogerResultado($result);
					return $row[0];
				}
			}
			return null;
		}
		
		public function execute($q, $parametros=null) {
			$result = $this->_sendQuery($q, $parametros);
			if (is_object($result)) {
				$arr = array();
				while ($row = $this->_mySQL->recogerResultado($result))
					$arr[] = $row;
				return $arr;
			}
			return null;
		}
	}
?>