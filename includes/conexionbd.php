<?php
	require_once 'mysql.php'; // Fichero en el que tenemos las clases y métodos para poder conectarnos a nuestra base de datos de MySQL.
	
	class ConexionBD {
		private $mySQL;
		private $parametros;
		
		public function __construct() {
			$this->mySQL = new MySQL();
			if (!$this->mySQL->estaConectada()) {
				throw new Exception("La conexi&oacute;n a la base de datos no se ha completado.");
			}
		}
		
		private function replaceParams($coincidencias) {
			$b = current($this->parametros);
			next($this->parametros); 
			return $b;
		}
		
		private function prepare($sql, $parametros) {
			for ($i = 0; $i < sizeof($parametros); $i++) {
				if (is_bool($parametros[$i]))
					$parametros[$i] = $parametros[$i]?1:0;
				elseif (is_double($parametros[$i]))
					$parametros[$i] = str_replace(',', '.', $parametros[$i]);
				elseif (is_numeric($parametros[$i]))
					$parametros[$i] = $this->mySQL->escapar($parametros[$i]);
				elseif (is_null($parametros[$i]))
					$parametros[$i] = "NULL";
				else
					$parametros[$i] = "'" . $this->mySQL->escapar($parametros[$i]) . "'";
			}
			$this->parametros = $parametros;
			$q = preg_replace_callback("/(\?)/i", array($this,"replaceParams"), $sql);
			return $q;
		}
		
		private function sendQuery($q, $parametros) {
			$query = $this->prepare($q, $parametros);
			$result = $this->mySQL->ejecutar($query);
			if ($this->mySQL->getErrorNo()) {
				throw new Exception("Ha habido un problema a la hora de realizar la sentencia SQL.");
			}
			return $result;
		}
		
		public function executeScalar($q, $parametros=null) {
			$result = $this->sendQuery($q, $parametros);
			if (!is_null($result)) {
				if (!is_object($result))
					return $result;
				else {
					$row = $this->mySQL->recogerResultado($result);
					return $row[0];
				}
			}
			return null;
		}
		
		public function execute($q, $parametros=null) {
			$result = $this->sendQuery($q, $parametros);
			if (is_object($result)) {
				$arr = array();
				while ($row = $this->mySQL->recogerResultado($result))
					$arr[] = $row;
				return $arr;
			}
			return null;
		}
	}
?>