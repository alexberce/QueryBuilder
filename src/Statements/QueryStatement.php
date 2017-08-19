<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/22/2017 4:16 AM
 */

namespace Qpdb\QueryBuilder\Statements;


use Qpdb\QueryBuilder\Dependencies\QueryException;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;
use Qpdb\QueryBuilder\QueryBuild;
use Qpdb\QueryBuilder\Traits\TableValidation;
use Qpdb\QueryBuilder\Traits\Utilities;

abstract class QueryStatement
{

	use Utilities, TableValidation;

	/**
	 * @var string
	 */
	protected $statement;

	/**
	 * @var QueryBuild
	 */
	protected $queryBuild;

	/**
	 * @var QueryStructure
	 */
	protected $queryStructure;

	/**
	 * @var array
	 */
	protected $usedInstanceIds = [];

	/**
	 * @var string
	 */
	protected $tablePrefix;


	/**
	 * QueryStatement constructor.
	 * @param QueryBuild $queryBuild
	 * @param string $table
	 * @throws QueryException
	 */
	public function __construct(QueryBuild $queryBuild, $table = '')
	{

		$table = $this->validateTable($table);

		$this->queryBuild = $queryBuild;
		$this->queryStructure = new QueryStructure();
		$this->queryStructure->setElement(QueryStructure::TABLE, $table);
		$this->queryStructure->setElement(QueryStructure::STATEMENT, $this->statement);
		$this->queryStructure->setElement(QueryStructure::QUERY_TYPE, $this->queryBuild->getType());

	}

	/**
	 * @return mixed
	 */
	public function getBindParams()
	{
		return $this->queryStructure->getElement(QueryStructure::BIND_PARAMS);
	}


}