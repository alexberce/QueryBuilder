<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/30/2017 8:26 PM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\Dependencies\QueryHelper;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;

trait OrderBy
{

	use Objects;


	/**
	 * @param $field
	 * @return $this
	 */
	public function orderBy( $field )
	{
		$expression = QueryHelper::alphaNum( $field ) . ' ASC';
		$this->queryStructure->setElement( QueryStructure::ORDER_BY, $expression );

		return $this;
	}

	/**
	 * @param $field
	 * @return $this
	 */
	public function orderByDesc( $field )
	{
		$expression = QueryHelper::alphaNum( $field ) . ' DESC';
		$this->queryStructure->setElement( QueryStructure::ORDER_BY, $expression );

		return $this;
	}

	/**
	 * @param $expression
	 * @return $this
	 */
	public function orderByExpression( $expression )
	{
		$this->queryStructure->setElement( QueryStructure::ORDER_BY, QueryHelper::clearQuotes( $expression ) );

		return $this;
	}

	/**
	 * @return string
	 */
	private function getOrderBySyntax()
	{
		if ( count( $this->queryStructure->getElement( QueryStructure::ORDER_BY ) ) )
			return 'ORDER BY ' . QueryHelper::implode( $this->queryStructure->getElement( QueryStructure::ORDER_BY ), ', ' );

		return '';
	}

}