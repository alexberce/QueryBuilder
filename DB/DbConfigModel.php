<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 6/17/2017 9:16 AM
 */

namespace Adi\QueryBuilder\DB;


class DbConfigModel
{

	private static $instance;

	/**
	 * @var array
	 */
	private $dbConfig;

	/**
	 * @var boolean
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
	 * DbConfigModel constructor.
	 */
	public function __construct()
	{
		$configPath = __DIR__ . '/../../config/db_config.php';
		$this->dbConfig = require $configPath;

	}


	/**
	 * @return mixed
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}
		return static::$instance;
	}

}