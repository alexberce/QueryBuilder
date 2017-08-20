<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 8/1/2017
 * Time: 12:38 PM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\Dependencies\QueryException;
use Qpdb\QueryBuilder\Dependencies\QueryHelper;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;
use Qpdb\QueryBuilder\Statements\QuerySelect;

trait Having
{

	use Objects;

	private $havingOperators = [
		'=', '!=', '<>', '<', '<=', '>', '>=',
		'LIKE', 'NOT LIKE', '!LIKE',
		'IN', 'NOT IN', '!IN',
		'BETWEEN', 'NOT BETWEEN',
		'REGEXP', 'NOT REGEXP', '!REGEXP'
	];

	private $havingGlue = [
		'AND', 'OR', 'XOR'
	];

	/**
	 * @param $field
	 * @param $value
	 * @param $glue
	 * @return $this
	 */
	public function havingEqual( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, '=' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingEqual( $field, $value )
	{
		return $this->having( array( $field, $value, '=' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingNotEqual( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, '<>' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingNotEqual( $field, $value )
	{
		return $this->having( array( $field, $value, '<>' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingLessThan( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, '<' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingLessThan( $field, $value )
	{
		return $this->having( array( $field, $value, '<' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingLessThanOrEqual( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, '<=' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingLessThanOrEqual( $field, $value )
	{
		return $this->having( array( $field, $value, '<=' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingGreaterThan( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, '>' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingGreaterThan( $field, $value )
	{
		return $this->having( array( $field, $value, '>' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingGreaterThanOrEqual( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, '>=' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingGreaterThanOrEqual( $field, $value )
	{
		return $this->having( array( $field, $value, '>=' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingLike( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, 'LIKE' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingLike( $field, $value )
	{
		return $this->having( array( $field, $value, 'LIKE' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingNotLike( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, 'NOT LIKE' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingNotLike( $field, $value )
	{
		return $this->having( array( $field, $value, 'NOT LIKE' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $min
	 * @param $max
	 * @param string $glue
	 * @return $this
	 */
	public function havingBetween( $field, $min, $max, $glue = 'AND' )
	{
		return $this->having( array( $field, array( $min, $max ), 'BETWEEN' ), $glue );
	}

	/**
	 * @param $field
	 * @param $min
	 * @param $max
	 * @return $this
	 */
	public function orHavingBetween( $field, $min, $max )
	{
		return $this->having( array( $field, array( $min, $max ), 'BETWEEN' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $min
	 * @param $max
	 * @param string $glue
	 * @return $this
	 */
	public function havingNotBetween( $field, $min, $max, $glue = 'AND' )
	{
		return $this->having( array( $field, array( $min, $max ), 'NOT BETWEEN' ), $glue );
	}

	/**
	 * @param $field
	 * @param $min
	 * @param $max
	 * @return $this
	 */
	public function orHavingNotBetween( $field, $min, $max )
	{
		return $this->having( array( $field, array( $min, $max ), 'NOT BETWEEN' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingIn( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, 'IN' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingIn( $field, $value )
	{
		return $this->having( array( $field, $value, 'IN' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function havingNotIn( $field, $value, $glue = 'AND' )
	{
		return $this->having( array( $field, $value, 'NOT IN' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orHavingNotIn( $field, $value )
	{
		return $this->having( array( $field, $value, 'NOT IN' ), 'OR' );
	}

	/**
	 * @param $havingString
	 * @param string $glue
	 * @return $this
	 */
	public function havingExpression( $havingString, $glue = 'AND' )
	{
		return $this->having( $havingString, $glue );
	}

	/**
	 * @param $havingString
	 * @return $this
	 */
	public function orHavingExpression( $havingString )
	{
		return $this->having( $havingString, 'OR' );
	}

	/**
	 * @return $this
	 */
	public function havingInvertResult()
	{
		$this->queryStructure->setElement( QueryStructure::HAVING_INVERT, 1 );

		return $this;
	}

	/**
	 * @param string $glue
	 * @return $this
	 */
	public function havingGroup( $glue = 'AND' )
	{
		$this->queryStructure->setElement( QueryStructure::HAVING, array( 'glue' => $glue, 'body' => '(', 'type' => 'start_having_group' ) );

		return $this;
	}

	/**
	 * @return $this
	 */
	public function OrHavingGroup()
	{
		return $this->havingGroup( 'OR' );
	}

	/**
	 * @return $this
	 */
	public function havingGroupEnd()
	{
		$this->queryStructure->setElement( QueryStructure::HAVING, array( 'glue' => '', 'body' => ')', 'type' => 'end_having_group' ) );

		return $this;
	}

	/**
	 * @param $param
	 * @param string $glue
	 * @return $this
	 */
	public function having( $param, $glue = 'AND' )
	{

		if ( !is_array( $param ) ) {
			$this->queryStructure->setElement( QueryStructure::HAVING, array( 'glue' => $glue, 'body' => trim( $param ), 'type' => 'cond' ) );

			return $this;
		}

		$param = $this->validateHavingParam( $param );

		$field = $param[0];
		$value = $param[1];
		$operator = $param[2];

		switch ( $operator ) {
			case 'BETWEEN':
			case 'NOT BETWEEN':
			case '!BETWEEN':
				$min = $value[0];
				$max = $value[1];
				$body = [
					$field,
					$operator,
					$this->queryStructure->bindParam( 'min', $min ),
					'AND',
					$this->queryStructure->bindParam( 'max', $max )
				];
				$body = implode( ' ', $body );
				$this->queryStructure->setElement( QueryStructure::HAVING, array( 'glue' => $glue, 'body' => $body, 'type' => 'cond' ) );
				break;

			case 'IN':
			case 'NOT IN':
			case '!IN':
				if ( is_a( $value, QuerySelect::class ) )
					return $this->inSelectObjectHaving( $field, $value, $operator, $glue );
				elseif ( is_array( $value ) )
					return $this->inArrayHaving( $field, $value, $operator, $glue );
				break;

			default:
				$valuePdoString = $this->queryStructure->bindParam( $field, $value );
				$body = $field . ' ' . $operator . ' ' . $valuePdoString;
				$this->queryStructure->setElement( QueryStructure::HAVING, array( 'glue' => $glue, 'body' => $body, 'type' => 'cond' ) );

		}

		return $this;

	}

	/**
	 * @param $field
	 * @param QuerySelect $subquerySelect
	 * @param $operator
	 * @param string $glue
	 * @return $this
	 */
	private function inSelectObjectHaving( $field, QuerySelect $subquerySelect, $operator, $glue = 'AND' )
	{
		if ( $this->queryStructure->getElement( QueryStructure::REPLACEMENT ) )
			$subquerySelect->withReplacement();
		$subquerySelectParams = $subquerySelect->getBindParams();
		foreach ( $subquerySelectParams as $key => $value ) {
			$this->queryStructure->setParams( $key, $value );
		}
		$body = [
			$field,
			$operator,
			'( ',
			$subquerySelect->getSyntax(),
			' )'
		];
		$body = implode( ' ', $body );
		$this->queryStructure->setElement( QueryStructure::HAVING, array( 'glue' => $glue, 'body' => $body, 'type' => 'cond' ) );

		return $this;
	}

	/**
	 * @param $field
	 * @param $value
	 * @param $operator
	 * @param $glue
	 * @return $this
	 */
	private function inArrayHaving( $field, array $value, $operator, $glue )
	{
		$pdoArray = array();
		foreach ( $value as $item ) {
			$pdoArray[] = $this->queryStructure->bindParam( 'a', $item );
		}
		$body = [
			$field,
			$operator,
			'( ' . implode( ', ', $pdoArray ) . ' )'
		];
		$body = implode( ' ', $body );
		$body = QueryHelper::clearMultipleSpaces( $body );
		$this->queryStructure->setElement( QueryStructure::HAVING, array( 'glue' => $glue, 'body' => $body, 'type' => 'cond' ) );

		return $this;
	}

	/**
	 * @return bool|mixed|string
	 */
	private function getHavingSyntax()
	{
		if ( count( $this->queryStructure->getElement( QueryStructure::HAVING ) ) == 0 )
			return '';

		$having = '';
		$last_type = 'having_start';
		foreach ( $this->queryStructure->getElement( QueryStructure::HAVING ) as $having_cond ) {
			$glue = $having_cond['glue'];
			if ( $last_type == 'having_start' || $last_type == 'start_having_group' ) {
				$glue = '';
			}
			$having .= ' ' . $glue . ' ' . $having_cond['body'];
			$last_type = $having_cond['type'];
		}

		if ( $this->queryStructure->getElement( QueryStructure::HAVING_INVERT ) ) {
			$having = ' NOT ( ' . $having . ' ) ';
		}

		$having = 'HAVING ' . $having;

		return QueryHelper::clearMultipleSpaces( $having );
	}

	/**
	 * @param $param
	 * @return array
	 * @throws QueryException
	 */
	private function validateHavingParam( $param )
	{
		if ( count( $param ) < 2 )
			throw new QueryException( 'Invalid having array!', QueryException::QUERY_ERROR_HAVING_INVALID_PARAM_ARRAY );

		if ( count( $param ) == 2 )
			$param[] = '=';

		$param[2] = trim( strtoupper( $param[2] ) );
		$param[2] = QueryHelper::clearMultipleSpaces( $param[2] );

		if ( !in_array( $param[2], $this->havingOperators ) )
			throw new QueryException( 'Invalid operator!', QueryException::QUERY_ERROR_HAVING_INVALID_OPERATOR );

		return $param;
	}
}