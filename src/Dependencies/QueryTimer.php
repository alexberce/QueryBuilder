<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 5/26/2017 7:36 PM
 */

namespace Qpdb\QueryBuilder\Dependencies;


class QueryTimer
{

	/**
	 * @var double
	 */
	private $queryStart;

	/**
	 * @var double
	 */
	private $queryEnd;

	public function __construct()
	{
		$this->queryStart = microtime( true );
	}

	/**
	 * @return float
	 */
	public function getDuration()
	{
		$this->queryEnd = microtime( true );

		return $this->queryEnd - $this->queryStart;
	}

}