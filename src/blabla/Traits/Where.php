<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/25/2017 1:13 AM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\Dependencies\QueryException;
use Qpdb\QueryBuilder\Dependencies\QueryHelper;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;
use Qpdb\QueryBuilder\Statements\QuerySelect;

trait Where
{

	use Objects;

	private $whereOperators = [
		'=', '!=', '<>', '<', '<=', '>', '>=',
		'LIKE', 'NOT LIKE', '!LIKE',
		'IN', 'NOT IN', '!IN',
		'BETWEEN', 'NOT BETWEEN',
		'REGEXP', 'NOT REGEXP', '!REGEXP'
	];

	private $whereGlue = [
		'AND', 'OR', 'XOR'
	];

	/**
	 * @param $field
	 * @param $value
	 * @param $glue
	 * @return $this
	 */
	public function whereEqual( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, '=' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereEqual( $field, $value )
	{
		return $this->where( array( $field, $value, '=' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereNotEqual( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, '<>' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereNotEqual( $field, $value )
	{
		return $this->where( array( $field, $value, '<>' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereLessThan( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, '<' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereLessThan( $field, $value )
	{
		return $this->where( array( $field, $value, '<' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereLessThanOrEqual( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, '<=' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereLessThanOrEqual( $field, $value )
	{
		return $this->where( array( $field, $value, '<=' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereGreaterThan( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, '>' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereGreaterThan( $field, $value )
	{
		return $this->where( array( $field, $value, '>' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereGreaterThanOrEqual( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, '>=' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereGreaterThanOrEqual( $field, $value )
	{
		return $this->where( array( $field, $value, '>=' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereLike( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, 'LIKE' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereLike( $field, $value )
	{
		return $this->where( array( $field, $value, 'LIKE' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereNotLike( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, 'NOT LIKE' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereNotLike( $field, $value )
	{
		return $this->where( array( $field, $value, 'NOT LIKE' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $min
	 * @param $max
	 * @param string $glue
	 * @return $this
	 */
	public function whereBetween( $field, $min, $max, $glue = 'AND' )
	{
		return $this->where( array( $field, array( $min, $max ), 'BETWEEN' ), $glue );
	}

	/**
	 * @param $field
	 * @param $min
	 * @param $max
	 * @return $this
	 */
	public function orWhereBetween( $field, $min, $max )
	{
		return $this->where( array( $field, array( $min, $max ), 'BETWEEN' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $min
	 * @param $max
	 * @param string $glue
	 * @return $this
	 */
	public function whereNotBetween( $field, $min, $max, $glue = 'AND' )
	{
		return $this->where( array( $field, array( $min, $max ), 'NOT BETWEEN' ), $glue );
	}

	/**
	 * @param $field
	 * @param $min
	 * @param $max
	 * @return $this
	 */
	public function orWhereNotBetween( $field, $min, $max )
	{
		return $this->where( array( $field, array( $min, $max ), 'NOT BETWEEN' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereIn( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, 'IN' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereIn( $field, $value )
	{
		return $this->where( array( $field, $value, 'IN' ), 'OR' );
	}

	/**
	 * @param $field
	 * @param $value
	 * @param string $glue
	 * @return $this
	 */
	public function whereNotIn( $field, $value, $glue = 'AND' )
	{
		return $this->where( array( $field, $value, 'NOT IN' ), $glue );
	}

	/**
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function orWhereNotIn( $field, $value )
	{
		return $this->where( array( $field, $value, 'NOT IN' ), 'OR' );
	}

	/**
	 * @param $whereString
	 * @param array $bindParams
	 * @param string $glue
	 * @return $this
	 */
	public function whereExpression( $whereString, array $bindParams = [], $glue = 'AND' )
	{
		$whereString = $this->queryStructure->bindParamsExpression( $whereString, $bindParams );
		return $this->where( $whereString, $glue );
	}

	/**
	 * @param $whereString
	 * @param array $bindParams
	 * @return $this
	 */
	public function orWhereExpression( $whereString, array $bindParams = [] )
	{
		$whereString = $this->queryStructure->bindParamsExpression( $whereString, $bindParams );
		return $this->where( $whereString, 'OR' );
	}

	/**
	 * @return $this
	 */
	public function whereInvertResult()
	{
		$this->queryStructure->setElement( QueryStructure::WHERE_INVERT, 1 );

		return $this;
	}

	/**
	 * @param string $glue
	 * @return $this
	 */
	public function whereGroup( $glue = 'AND' )
	{
		$this->queryStructure->setElement( QueryStructure::WHERE, array( 'glue' => $glue, 'body' => '(', 'type' => 'start_where_group' ) );

		return $this;
	}

	/**
	 * @return $this
	 */
	public function OrWhereGroup()
	{
		return $this->whereGroup( 'OR' );
	}

	/**
	 * @return $this
	 */
	public function whereGroupEnd()
	{
		$this->queryStructure->setElement( QueryStructure::WHERE, array( 'glue' => '', 'body' => ')', 'type' => 'end_where_group' ) );

		return $this;
	}

	/**
	 * @param $param
	 * @param string $glue
	 * @return $this
	 */
	public function where( $param, $glue = 'AND' )
	{

		if ( !is_array( $param ) ) {
			$this->queryStructure->setElement( QueryStructure::WHERE, array( 'glue' => $glue, 'body' => trim( $param ), 'type' => 'cond' ) );

			return $this;
		}

		$param = $this->validateWhereParam( $param );

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
				$this->queryStructure->setElement( QueryStructure::WHERE, array( 'glue' => $glue, 'body' => $body, 'type' => 'cond' ) );
				break;

			case 'IN':
			case 'NOT IN':
			case '!IN':
				if ( is_a( $value, QuerySelect::class ) )
					return $this->inSelectObject( $field, $value, $operator, $glue );
				elseif ( is_array( $value ) )
					return $this->inArray( $field, $value, $operator, $glue );
				break;

			default:
				$valuePdoString = $this->queryStructure->bindParam( $field, $value );
				$body = $field . ' ' . $operator . ' ' . $valuePdoString;
				$this->queryStructure->setElement( QueryStructure::WHERE, array( 'glue' => $glue, 'body' => $body, 'type' => 'cond' ) );

		}

		return $this;

	}

	/**
	 * @return $this
	 */
	public function ignoreWhereTrigger()
	{
		$this->queryStructure->setElement( QueryStructure::WHERE_TRIGGER, 0 );

		return $this;
	}

	/**
	 * @param $field
	 * @param QuerySelect $subquerySelect
	 * @param $operator
	 * @param string $glue
	 * @return $this
	 */
	private function inSelectObject( $field, QuerySelect $subquerySelect, $operator, $glue = 'AND' )
	{
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
		$this->queryStructure->setElement( QueryStructure::WHERE, array( 'glue' => $glue, 'body' => $body, 'type' => 'cond' ) );

		return $this;
	}

	/**
	 * @param $field
	 * @param $value
	 * @param $operator
	 * @param $glue
	 * @return $this
	 */
	private function inArray( $field, array $value, $operator, $glue )
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
		$this->queryStructure->setElement( QueryStructure::WHERE, array( 'glue' => $glue, 'body' => $body, 'type' => 'cond' ) );

		return $this;
	}

	/**
	 * @return bool|mixed|string
	 */
	private function getWhereSyntax()
	{
		if ( count( $this->queryStructure->getElement( QueryStructure::WHERE ) ) == 0 )
			return '';

		$where = '';
		$last_type = 'where_start';
		foreach ( $this->queryStructure->getElement( QueryStructure::WHERE ) as $where_cond ) {
			$glue = $where_cond['glue'];
			if ( $last_type == 'where_start' || $last_type == 'start_where_group' ) {
				$glue = '';
			}
			$where .= ' ' . $glue . ' ' . $where_cond['body'];
			$last_type = $where_cond['type'];
		}

		if ( $this->queryStructure->getElement( QueryStructure::WHERE_INVERT ) ) {
			$where = ' NOT ( ' . $where . ' ) ';
		}

		$where = 'WHERE ' . $where;

		return QueryHelper::clearMultipleSpaces( $where );
	}

	/**
	 * @param $param
	 * @return array
	 * @throws QueryException
	 */
	private function validateWhereParam( $param )
	{
		if ( count( $param ) < 2 )
			throw new QueryException( 'Invalid where array!', QueryException::QUERY_ERROR_WHERE_INVALID_PARAM_ARRAY );

		if ( count( $param ) == 2 )
			$param[] = '=';

		$param[2] = trim( strtoupper( $param[2] ) );
		$param[2] = QueryHelper::clearMultipleSpaces( $param[2] );

		if ( !in_array( $param[2], $this->whereOperators ) )
			throw new QueryException( 'Invalid operator!', QueryException::QUERY_ERROR_WHERE_INVALID_OPERATOR );

		return $param;
	}
}