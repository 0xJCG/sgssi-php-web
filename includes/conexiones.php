<?php
	require_once("bd.php");
	class Connection {
		var $cn;
		function Connection() {
			$this->cn = DatabaseLayer::getConnection("MySqlProvider");
		}
		function login($user, $pass) {
			$rs = $this->query("SELECT codigo, nombre FROM usuarios WHERE nombre = ? AND contrasena = ?", array($user, $pass));
			if (!empty($rs)) {
				$_SESSION['codigo'] = $rs[0][0];
				$_SESSION['nombre'] = $rs[0][1];
				unset($rs);
				return true;
			}
			else {
				unset($rs);
				return false;
			}
		}
		function register($user, $email, $pass) {
			$rs = $this->queryScalar("SELECT nombre FROM usuarios WHERE nombre = ?", array($user));
			$rs2 = $this->queryScalar("SELECT nombre FROM usuarios WHERE email = ?", array($email));
			if (!empty($rs) || !empty($rs2))
				return false;
			else {
				unset($rs);
				$rs = $this->query("INSERT INTO usuarios (nombre, email, pass, date) VALUES (?, ?, ?, ?)", array($user, $email, $pass, date('Y-m-d H:i:s')));
				return true;
			}
		}
		function change($email, $pass, $passverif) {
			$password = $this->queryScalar("SELECT pass FROM usuarios WHERE id = ?", array($_SESSION['id']));
			if ($password != $passverif)
				return false;
			else {
				$rs = $this->queryScalar("SELECT email FROM usuarios WHERE id = ?", array($_SESSION['id']));
				if ($rs != $email) {
					unset($rs);
					$rs = $this->queryScalar("SELECT nombre FROM usuarios WHERE email = ?", array($email));
					if (!empty($rs)) 
						return false;
					else {
						unset($rs);
						$rs = $this->query("UPDATE usuarios SET email = ?, pass = ? WHERE id = ?", array($email, $pass, $_SESSION['id']));
						return true;
					}
				}
				else {
					unset($rs);
					$rs = $this->query("UPDATE usuarios SET email = ?, pass = ? WHERE id = ?", array($email, $pass, $_SESSION['id']));
					return true;
				}
			}
		}
		function query($query, $parameters) {
			$rs = $this->cn->execute($query, $parameters);
			return $rs;
		}
		function queryScalar($query, $parameters) {
			$rs = $this->cn->executeScalar($query, $parameters);
			return $rs;
		}
	}
?>