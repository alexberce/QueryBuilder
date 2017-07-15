<?php

/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 5/1/2017 1:30 AM
 */

namespace Adi\QueryBuilder\Dependencies;

class DbServiceOld
{

	private static $instance;


	/**
	 * @var \PDO
	 */
	private $pdo;

	/**
	 * @var \PDOStatement
	 */
	private $sQuery;

	/**
	 * @var array
	 */
	private $settings;

	/**
	 * @var bool
	 */
	private $bConnected = false;

	//private $log;

	/**
	 * @var array
	 */
	private $parameters = [];


	public function __construct()
	{
		//$this->log = new Log();
		$this->Connect();
		$this->parameters = array();
	}

	/**
	 * @return \PDO
	 */
	public function getPdo()
	{
		return $this->pdo;
	}

	/**
	 * @param $string
	 * @return string
	 */
	public function quote( $string )
	{
		return $this->pdo->quote( $string );
	}

	private function Connect()
	{
		$this->settings = parse_ini_file("settings.php");
		$dsn = 'mysql:dbname=' . $this->settings["dbname"] . ';host=' . $this->settings["host"] . '';
		try {

			$this->pdo = new \PDO(
				$dsn,
				$this->settings["user"],
				$this->settings["password"],
				array(
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
				)
			);

			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
			$this->bConnected = true;
		}
		catch (\PDOException $e) {
			# Write into log
			echo $this->ExceptionLog($e->getMessage());
			die();
		}
	}

	public function CloseConnection()
	{
		# Set the PDO object to null to close the connection
		# http://www.php.net/manual/en/pdo.connections.php
		$this->pdo = null;
	}

	private function Init($query, $parameters = [])
	{
		# Connect to database
		if (!$this->bConnected) {
			$this->Connect();
		}

		$query = str_replace('::', $this->settings['prefix'], $query);

		try {
			# Prepare query
			$this->sQuery = $this->pdo->prepare($query);

			# Add parameters to the parameter array
			$this->bindMore($parameters);

			# Bind parameters
			if ( count($this->parameters) ) {
				foreach ($this->parameters as $param => $value) {
					if(is_int($value[1])) {
						$type = \PDO::PARAM_INT;
					} else if(is_bool($value[1])) {
						$type = \PDO::PARAM_BOOL;
					} else if(is_null($value[1])) {
						$type = \PDO::PARAM_NULL;
					} else {
						$type = \PDO::PARAM_STR;
					}
					$this->sQuery->bindValue($value[0], $value[1], $type);
				}
			}

			# Execute SQL
			$this->sQuery->execute();
		}
		catch (\PDOException $e) {
			# Write into log and display Exception
			echo $this->ExceptionLog($e->getMessage(), $query);
			die();
		}

		# Reset the parameters
		$this->parameters = array();
	}

	public function bind($para, $value)
	{
		$this->parameters[sizeof($this->parameters)] = [":" . $para , $value];
	}

	public function bindMore($parray)
	{
		if ( !count($this->parameters)  && is_array($parray) ) {
			$columns = array_keys($parray);
			foreach ($columns as $i => &$column) {
				$this->bind($column, $parray[$column]);
			}
		}
	}

	public function query($query, $params = null, $fetchmode = \PDO::FETCH_ASSOC)
	{
		$query = trim(str_replace("\r", " ", $query));

		$this->Init($query, $params);

		$rawStatement = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));

		$statement = strtolower($rawStatement[0]);

		if ($statement === 'select' || $statement === 'show') {
			return $this->sQuery->fetchAll($fetchmode);
		} elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
			return $this->sQuery->rowCount();
		} else {
			return NULL;
		}
	}

	public function column($query, $params = null)
	{
		$this->Init($query, $params);
		$Columns = $this->sQuery->fetchAll(\PDO::FETCH_NUM);

		$column = null;

		foreach ($Columns as $cells) {
			$column[] = $cells[0];
		}

		return $column;

	}

	public function row($query, $params = null, $fetchmode = \PDO::FETCH_ASSOC)
	{
		$this->Init($query, $params);
		$result = $this->sQuery->fetch($fetchmode);
		$this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued,
		return $result;
	}

	public function single($query, $params = null)
	{
		$this->Init($query, $params);
		$result = $this->sQuery->fetchColumn();
		$this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued
		return $result;
	}


	/**
	 * @return DbServiceOld
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}
		return static::$instance;
	}


	private function ExceptionLog($message, $sql = "")
	{
		$exception = 'Unhandled Exception. <br />';
		$exception .= $message;
		$exception .= "<br /> You can find the error back in the log.";

		if (!empty($sql)) {
			# Add the Raw SQL to the Log
			$message .= "\r\nRaw SQL : " . $sql;
		}
		# Write into log
		//$this->log->write($message);

		return $exception;
	}


}