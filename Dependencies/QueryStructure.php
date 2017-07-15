<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/22/2017 2:33 AM
 */

namespace Adi\QueryBuilder\Dependencies;


use Adi\QueryBuilder\Statements\QueryStatement;

class QueryStructure
{

	const TABLE                 = 'table';
	const STATEMENT             = 'statement';
	const FIELDS                = 'fields';
	const SET_FIELDS            = 'set_fields';
	const WHERE                 = 'where';
	const WHERE_INVERT          = 'where_invert';
	const LIMIT                 = 'limit_rows';
	const ORDER_BY              = 'order_by';
	const GROUP_BY              = 'group_by';
	const COUNT                 = 'count';
	const COLUMN                = 'column';
	const FIRST                 = 'first';
	const DISTINCT              = 'distinct';
	const JOIN                  = 'join';
	const IGNORE                = 'ignore';
	const MULTIPLE_ROWS         = 'multiple_rows';
	const QUERY                 = 'query';
	const BIND_PARAMS           = 'bind_params';
	const REPLACEMENT           = 'replacement';
	const QUERY_TYPE            = 'query_type';
	const QUERY_COMMENT         = 'query_comment';
	const QUERY_IDENTIFIER      = 'query_identifier';
	const WHERE_TRIGGER         = 'where_trigger';
	const INSTANCE              = 'instance';


	/**
	 * @var array
	 */
	private static $usedInstanceIds = [];

	/**
	 * @var array
	 */
	private $syntaxEL = array();

	/**
	 * @var int
	 */
	private $counter = 0;


	/**
	 * QueryStructure constructor.
	 */
	public function __construct()
	{
		$this->syntaxEL = $this->init();
	}

	private function init()
	{
		return [
			self::TABLE                 => '',
			self::STATEMENT             => '',
			self::FIELDS                => '*',
			self::SET_FIELDS            => array(),
			self::WHERE                 => array(),
			self::WHERE_INVERT          => 0,
			self::LIMIT                 => 0,
			self::ORDER_BY              => array(),
			self::GROUP_BY              => array(),
			self::COUNT                 => 0,
			self::COLUMN                => '',
			self::FIRST                 => 0,
			self::DISTINCT              => 0,
			self::JOIN                  => array(),
			self::IGNORE                => 0,
			self::MULTIPLE_ROWS         => 0,
			self::QUERY                 => '',
			self::BIND_PARAMS           => array(),
			self::REPLACEMENT           => 0,
			self::QUERY_TYPE            => 0,
			self::QUERY_COMMENT         => '',
			self::QUERY_IDENTIFIER      => 'DEFAULT',
            self::WHERE_TRIGGER         => 1,
			self::INSTANCE              => $this->makeStatementInstance()
		];
	}


	private function makeStatementInstance()
	{
		$instance = QueryHelper::random( 5 );
		while ( in_array($instance, self::$usedInstanceIds) ) {
			$instance = QueryHelper::random( 7 );
		}
		self::$usedInstanceIds[] = $instance;
		return $instance;
	}


	/**
	 * @return array
	 */
	public static function getUsedInstances()
	{
		return self::$usedInstanceIds;
	}


	/**
	 * @return array
	 */
	public function getAllElements()
	{
		return $this->syntaxEL;
	}

	/**
	 * @param $elements
	 */
	public function setAllElements( $elements )
	{
		$this->syntaxEL = $elements;
	}


	/**
	 * @param $name
	 * @param $value
	 * @return bool
	 * @throws QueryException
	 */
	public function setElement( $name, $value )
	{
		if(!array_key_exists( $name, $this->syntaxEL ))
			throw new QueryException('Invalid Query property', QueryException::QUERY_ERROR_ELEMENT_NOT_FOUND);

		if( $name == self::TABLE && is_a( $value, QueryStatement::class) )
			return true;

		if(is_array($this->syntaxEL[$name]))
		    $this->syntaxEL[$name][] = $value;
		else
		    $this->syntaxEL[$name] = $value;

		return true;
	}

    /**
     * @param string $elementName
     * @param array $elementValue
     * @throws QueryException
     */
    public function replaceElement( $elementName, $elementValue )
    {
        if(!array_key_exists( $elementName, $this->syntaxEL ))
            throw new QueryException('Invalid Query property', QueryException::QUERY_ERROR_ELEMENT_NOT_FOUND);

        if(!is_array($this->syntaxEL[$elementName]))
            throw new QueryException('Invalid Query property', QueryException::QUERY_ERROR_ELEMENT_TYPE);

        $this->syntaxEL[$elementName] = $elementValue;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getElement( $name )
	{
		return $this->syntaxEL[$name];
	}

	/**
	 * @param $name
	 * @param $value
	 */
	public function setParams( $name, $value )
	{
		$this->syntaxEL[QueryStructure::BIND_PARAMS][$name] = $value;
	}

	/**
	 * @param $name
	 * @param $value
	 * @return string
	 */
	public function bindParam( $name, $value )
	{
		$pdoName = $this->index($name);
		$this->syntaxEL[QueryStructure::BIND_PARAMS][$pdoName] = $value;
		return ':' . $pdoName;
	}

	/**
	 * @param string $fieldName
	 * @return string
	 */
	public function index( $fieldName = '' )
	{
		return trim($fieldName) . '_' . $this->syntaxEL[self::INSTANCE] . '_' . ++$this->counter . 'i';
	}

}