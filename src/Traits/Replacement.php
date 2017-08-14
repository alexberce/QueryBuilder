<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/30/2017 4:47 PM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\DB\DbConnect;
use Qpdb\QueryBuilder\Dependencies\QueryHelper;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;
use Qpdb\QueryBuilder\Statements\QueryStatementInterface;

trait Replacement
{

	use Objects;

	/**
	 * @return $this
	 */
	public function withReplacement()
	{
		$this->queryStructure->setElement(QueryStructure::REPLACEMENT, QueryStatementInterface::REPLACEMENT_VALUES);
		return $this;
	}


	/**
	 * @param $syntax
	 * @param int $withReplacement
	 * @return mixed|string
	 */
	private function getSyntaxReplace($syntax, $withReplacement = QueryStatementInterface::REPLACEMENT_NONE)
	{
		$syntax = QueryHelper::clearMultipleSpaces($syntax);

		if (!$this->queryStructure->getElement(QueryStructure::REPLACEMENT) && !$withReplacement)
			return $syntax;

		return $this->replaceValues($syntax);
	}

	/**
	 * @param $syntax
	 * @return string
	 */
	private function replaceValues($syntax)
	{
		$bindParams = $this->queryStructure->getElement(QueryStructure::BIND_PARAMS);
		$search = array();
		$replace = array();
		foreach ($bindParams as $key => $value) {
			$search[] = ':' . $key;
			$replace[] = DbConnect::getInstance()->quote($value);
		}
		$syntax = str_ireplace($search, $replace, $syntax);

		return $syntax;

	}

}