<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 5/27/2017 1:07 PM
 */

namespace Adi\QueryBuilder\DB;


class DbConfig
{

	private static $instance;

	/**
	 * @var array
	 */
	private $dbConfig;

	/**
	 * @var bool
	 */
	private $replicationEnable;

	/**
	 * @var array
	 */
	private $masterDataConnect;

	/**
	 * @var array
	 */
	private $slaveDataConnect;


	/**
	 * DbConfig constructor.
	 */
	private function __construct()
	{
		$configPath = __DIR__ . '/../config/db_config.php';
		$this->dbConfig = require $configPath;
		$this->replicationEnable = $this->dbConfig['replicationEnable'];
		$this->readMasterDataConnect();
		$this->readSlaveDataConnect();
	}

	/**
	 * @return bool
	 */
	public function getReplicationEnable()
	{
		return $this->replicationEnable;
	}

	/**
	 * @return array
	 */
	public function getMasterDataConnect()
	{
		return $this->masterDataConnect;
	}

	/**
	 * @return array
	 */
	public function getSlaveDataConnect()
	{
		return $this->slaveDataConnect;
	}

	/**
	 * @return array
	 */
	public function getLogConfig()
	{
		return $this->dbConfig['db_log'];
	}


	/**
	 * @return mixed
	 */
	public function getTablePrefix()
	{
		return $this->dbConfig['prefix'];
	}


	/**
	 * @return bool
	 * @throws DbException
	 */
	private function readMasterDataConnect()
	{

		if(!isset($this->dbConfig['master_data_connect'][0]))
			throw new DbException('Master data connect is missing', DbException::DB_ERROR_MASTER_DATA_CONNECTION_MISSING);

		$dataConnection = $this->dbConfig['master_data_connect'];

		if(!$this->replicationEnable || count($dataConnection)==1) {
			$this->masterDataConnect = $dataConnection[0];
			return true;
		}

		shuffle( $dataConnection );
		$this->masterDataConnect = $dataConnection[0];

		return true;
	}


	/**
	 * @return bool
	 */
	private function readSlaveDataConnect()
	{

		if(!isset($this->dbConfig['slave_data_connect'][0])) {
			$this->slaveDataConnect = $this->masterDataConnect;
			return true;
		}

		$dataConnection = $this->dbConfig['slave_data_connect'];

		shuffle( $dataConnection );
		$this->slaveDataConnect = $dataConnection[0];

		return true;
	}

	/**
	 * @return DbConfig
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}
		return static::$instance;
	}


}