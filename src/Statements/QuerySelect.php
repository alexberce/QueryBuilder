<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/22/2017 4:17 AM
 */

namespace Qpdb\QueryBuilder\Statements;


use Qpdb\QueryBuilder\DB\DbService;
use Qpdb\QueryBuilder\Dependencies\QueryHelper;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;
use Qpdb\QueryBuilder\QueryBuild;
use Qpdb\QueryBuilder\Traits\DefaultPriority;
use Qpdb\QueryBuilder\Traits\Distinct;
use Qpdb\QueryBuilder\Traits\GroupBy;
use Qpdb\QueryBuilder\Traits\Having;
use Qpdb\QueryBuilder\Traits\HighPriority;
use Qpdb\QueryBuilder\Traits\Join;
use Qpdb\QueryBuilder\Traits\Limit;
use Qpdb\QueryBuilder\Traits\OrderBy;
use Qpdb\QueryBuilder\Traits\Replacement;
use Qpdb\QueryBuilder\Traits\Utilities;
use Qpdb\QueryBuilder\Traits\Where;

class QuerySelect extends QueryStatement implements QueryStatementInterface
{

	use Limit, Distinct, Where, Having, Replacement, OrderBy, GroupBy, Join, DefaultPriority, HighPriority, Utilities;

	/**
	 * @var string
	 */
	protected $statement = 'SELECT';


	/**
	 * QuerySelect constructor.
	 * @param QueryBuild $queryBuild
	 * @param null $table
	 */
	public function __construct(QueryBuild $queryBuild, $table = null)
	{
		parent::__construct($queryBuild, $table);

		if (is_a($table, QuerySelect::class)) {

			/**
			 * @var QuerySelect $table
			 */
			$tableName = '( ' . $table->getSyntax() . ' )';
			$this->queryStructure->setElement(QueryStructure::TABLE, $tableName);

			if ($this->queryStructure->getElement(QueryStructure::REPLACEMENT))
				$table->withReplacement();

			$tableSelectParams = $table->getBindParams();
			foreach ($tableSelectParams as $key => $value)
				$this->queryStructure->setParams($key, $value);

		}
	}

	/**
	 * @param $fields
	 * @return $this
	 */
	public function fields($fields)
	{
		$this->queryStructure->setElement(QueryStructure::FIELDS, $fields);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function first()
	{
		$this->queryStructure->setElement(QueryStructure::FIRST, 1);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function count()
	{
		$this->queryStructure->setElement(QueryStructure::COUNT, 1);
		return $this;
	}

	/**
	 * @param $column
	 * @return $this
	 */
	public function column($column)
	{
		$column = QueryHelper::clearMultipleSpaces($column);
		$this->queryStructure->setElement(QueryStructure::COLUMN, $column);
		return $this;
	}

	public function getSyntax()
	{

		if ($this->queryStructure->getElement(QueryStructure::COUNT)) {
			$this->queryStructure->setElement(QueryStructure::FIELDS, 'COUNT(*)');
			$this->queryStructure->setElement(QueryStructure::LIMIT, 1);
			$this->queryStructure->setElement(QueryStructure::DISTINCT, 0); //???
		}

		if ($this->queryStructure->getElement(QueryStructure::FIRST))
			$this->queryStructure->setElement(QueryStructure::LIMIT, 1);

		$syntax = array();

		/**
		 * SELECT statement
		 */
		$syntax[] = $this->statement;

		/**
		 * PRIORITY
		 */
		$syntax[] = $this->queryStructure->getElement(QueryStructure::PRIORITY);

		/**
		 * DISTINCT clause
		 */
		$syntax[] = $this->getDistinctSyntax();

		/**
		 * FIELDS
		 */
		$syntax[] = $this->queryStructure->getElement(QueryStructure::FIELDS);

		/**
		 * FROM table or queryStructure
		 */
		$syntax[] = 'FROM ' . $this->queryStructure->getElement(QueryStructure::TABLE);

		/**
		 * JOIN CLAUSES
		 */
		$syntax[] = $this->getJoinSyntax();

		/**
		 * WHERE clause
		 */
		$syntax[] = $this->getWhereSyntax();

		/**
		 * GROUP BY clause
		 */
		$syntax[] = $this->getGroupBySyntax();

		/**
		 * HAVING clause
		 */
		$syntax[] = $this->getHavingSyntax();

		/**
		 * ORDER BY clause
		 */
		$syntax[] = $this->getOrderBySyntax();

		/**
		 * LIMIT clause
		 */
		$syntax[] = $this->getLimitSyntax();

		$syntax = implode(' ', $syntax);

		return $this->getSyntaxReplace($syntax);

	}


	/**
	 * @return array|int|mixed|null|string
	 */
	public function execute()
	{

		switch (true) {
			case $this->queryStructure->getElement(QueryStructure::COUNT):
				return DbService::getInstance()->single($this->getSyntax(), $this->queryStructure->getElement(QueryStructure::BIND_PARAMS));
				break;
			case $this->queryStructure->getElement(QueryStructure::FIRST):
				if ($this->queryStructure->getElement(QueryStructure::COLUMN))
					return DbService::getInstance()->single($this->getSyntax(), $this->queryStructure->getElement(QueryStructure::BIND_PARAMS));
				return DbService::getInstance()->row($this->getSyntax(), $this->queryStructure->getElement(QueryStructure::BIND_PARAMS));
				break;
			case $this->queryStructure->getElement(QueryStructure::COLUMN):
				return DbService::getInstance()->column($this->getSyntax(), $this->queryStructure->getElement(QueryStructure::BIND_PARAMS));
				break;
			default:
				return DbService::getInstance()->query($this->getSyntax(), $this->queryStructure->getElement(QueryStructure::BIND_PARAMS));
				break;
		}
	}

}