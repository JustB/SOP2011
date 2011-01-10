<?php

/**
 * Classe responsabile della comunicazione dell'applicazione con il database.
 * 
 *
 * @author just
 */
require_once 'DatabaseErrorException.php';

class DB {

	private static $instance = NULL;
	private $user = 'sop2011_admin';
	private $password = 'z0m1x9n2';
	private $dbName = 'sop2011';
	private $dbHost = 'localhost';
	private $conn = NULL;

	/**
	 * costruttore privato
	 * @throws DatabaseException
	 */
	private function __construct() {
		$this->conn = new mysqli($this->dbHost, $this->user, $this->password, $this->dbName);
		if (mysqli_connect_errno ()) {
			$msg = $this->conn->connect_error;
			throw new DatabaseErrorException($msg);
		}
		$this->conn->query("SET NAMES 'utf8'");
	}

	/**
	 * Restituisce l'unica istanza della connessione
	 * @return DB
	 */
	public static function getInstance() {
		if (!self::$instance instanceof self) {
			try {
				self::$instance = new self;
			} catch (DatabaseErrorException $e) {
				die($e->getMessage()); //TODO cosa dovrei fare qui?
			}
		}
		return self::$instance;
	}

	/**
	 *
	 * @param type $queryStr
	 * @return type 
	 * @throws DatabaseErrorException
	 */
	public function query($queryStr) {
		$result = @$this->conn->query($queryStr);
		if ($result !== FALSE) {
			return $result;
		} else {
			$msg = $this->conn->connect_error;
			throw new DatabaseErrorException($msg);
		}
	}

	/**
	 * Restituisce l'id per l'ultima query effettuata, se il campo prevede
	 * il vincolo AUTO_INCREMENT
	 * @return integer
	 */
	public function lastInsertId() {
		return $this->conn->insert_id;
	}

	/**
	 *
	 * @param type $queryStr
	 * @return type 
	 */
	public function fetchFirst($queryStr) {
		$queryStr .= ' LIMIT 1';
		//$result = $this->conn->query($queryStr);
		$result = $this->query($queryStr);
		$out = $result->fetch_assoc();
		if (!empty($out)) {
			return $out;
		} else {
			throw new DatabaseErrorException("Record non trovato");
		}
	}

	public function escape($str) {
		if ($this->conn) {
			$str = trim($str);
			return $this->conn->real_escape_string($str);
		}
	}

	/**
	 * Elimina la connessione
	 */
	public function __destruct() {
		$this->conn->close();
	}

}

/*
 * public function disconnect (not a must, but always nice to have)

 * public function escape (simple use of mysql_escape_string, but ensures we’re connected to mysql first)

 * public function fetchArray (calls query and returns the entire result one row at a time)

 * public function storeArray (calls query and returns the entire result as an array)

 * private function error (simple error reporting)
 */
?>
