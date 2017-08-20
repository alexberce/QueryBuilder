<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 7/28/2017
 * Time: 12:59 PM
 */

namespace Qpdb\QueryBuilder\Dependencies;


class QueryConfig
{

	private static $instance;

	/**
	 * @var array
	 */
	private $queryConfig;


	/**
	 * QueryConfig constructor.
	 */
	private function __construct()
	{
		$configPath = __DIR__ . '/../../config/query_config.php';
		$this->queryConfig = require $configPath;
	}


	/**
	 * @return string
	 */
	public function getTablePrefix()
	{
		return $this->queryConfig['table_prefix'];
	}

	/**
	 * @return integer
	 */
	public function useTablePrefix()
	{
		return $this->queryConfig['use_table_prefix'];
	}

	/**
	 * @return string
	 */
	public function getDriver()
	{
		return $this->queryConfig['driver'];
	}


	/**
	 * @return QueryConfig
	 */
	public static function getInstance()
	{
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

}