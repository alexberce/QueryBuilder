<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/22/2017 4:16 AM
 */

namespace Qpdb\QueryBuilder\Statements;


use Qpdb\QueryBuilder\Dependencies\QueryConfig;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;
use Qpdb\QueryBuilder\QueryBuild;
use Qpdb\QueryBuilder\Traits\Utilities;

abstract class QueryStatement
{

	use Utilities;

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
	 * @param null $table
	 */
	public function __construct( QueryBuild $queryBuild, $table = null )
	{

		if(!is_null($table) && !is_a($table, QueryStatement::class))
		    $table = str_ireplace('::', QueryConfig::getInstance()->getTablePrefix(), $table );

        $this->queryBuild = $queryBuild;
		$this->queryStructure = new QueryStructure();
		$this->queryStructure->setElement( QueryStructure::TABLE, $table );
		$this->queryStructure->setElement( QueryStructure::STATEMENT, $this->statement );
		$this->queryStructure->setElement( QueryStructure::QUERY_TYPE, $this->queryBuild->getType());
	}

	/**
	 * @return mixed
	 */
	public function getBindParams()
	{
		return $this->queryStructure->getElement(QueryStructure::BIND_PARAMS);
	}


}