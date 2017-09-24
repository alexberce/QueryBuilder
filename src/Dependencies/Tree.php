<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 9/22/2017
 * Time: 8:08 PM
 */

namespace Qpdb\QueryBuilder\Dependencies;


class Tree
{

	const ID_NAME = 'idName';
	const PARENT_ID_NAME = 'parentIdName';
	const CHILDREN_NAME = 'childrenName';
	const DEPTH_NAME = 'depthName';


	/**
	 * @var array
	 */
	private $flatArray = [];

	/**
	 * @var array
	 */
	private $treeArray = null;

	/**
	 * @var int|string
	 */
	private $rootValue = 0;

	/**
	 * @var array
	 */
	private $role = [
		self::ID_NAME => 'id',
		self::PARENT_ID_NAME => 'parentId',
		self::CHILDREN_NAME => 'children',
		self::DEPTH_NAME => 'depth'
	];

	/**
	 * @var array
	 */
	private $parents = [];

	/**
	 * @var array
	 */
	private $children = [];


	/**
	 * Tree constructor.
	 * @param array $flatArray
	 */
	public function __construct( array $flatArray )
	{
		$this->flatArray = $flatArray;
		$this->prepareFlatArray();
	}

	/**
	 * @param $idName
	 * @return $this
	 */
	public function withIdName( $idName )
	{
		$this->role[ self::ID_NAME ] = $idName;

		return $this;
	}

	/**
	 * @param $parentIdName
	 * @return $this
	 */
	public function withParentIdName( $parentIdName )
	{
		$this->role[ self::PARENT_ID_NAME ] = $parentIdName;

		return $this;
	}

	/**
	 * @param $childrenName
	 * @return $this
	 */
	public function withChildrenName( $childrenName )
	{
		$this->role[ self::CHILDREN_NAME ] = $childrenName;

		return $this;
	}

	/**
	 * @param string $name
	 */
	public function withDepthName( $name )
	{
		$this->role[ self::DEPTH_NAME ] = $name;
	}

	/**
	 * @param int|string $value
	 * @return $this
	 */
	public function withRootValue( $value = 0 )
	{
		$this->rootValue = $value;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function buildTree()
	{
		$this->treeArray = $this->createTree( $this->flatArray, $this->rootValue );

		return $this;
	}

	/**
	 * @return array
	 */
	public function getTreeArray()
	{
		return $this->treeArray;
	}

	/**
	 * @return array
	 */
	public function getFlatArray()
	{
		return $this->flatArray;
	}

	/**
	 * @param mixed $nodeId
	 * @return array
	 */
	public function getChildren( $nodeId )
	{
		$findChildren = array();
		foreach ( $this->flatArray as $key => $value ) {
			if ( $value[ $this->role[ self::PARENT_ID_NAME ] ] == $nodeId ) {
				$findChildren[] = $value[ $this->role[ self::ID_NAME ] ];
				$sub = $this->getChildren( $value[ $this->role[ self::ID_NAME ] ] );
				foreach ( $sub as $k => $v ) {
					$findChildren[] = $v;
				}
			}
		}

		return $findChildren;
	}

	public function getParents( $nodeId )
	{
		$this->parents = [];
		$this->calculateParents( $nodeId );

		return $this->parents;
	}

	private function calculateParents( $nodeId )
	{

		if(!array_key_exists($this->flatArray[ $nodeId ][ $this->role[ self::PARENT_ID_NAME ] ], $this->flatArray))
			return false;

		$parentNode = $this->flatArray[ $nodeId ][ $this->role[ self::PARENT_ID_NAME ] ];

		if ( $parentNode != $this->rootValue )
			$this->parents[] = $parentNode;

		if ( $parentNode != $this->rootValue ) {
			$this->calculateParents( $parentNode );
		}

		return true;

	}

	private function createTree( array $elements, $parentId = 0, $depth = 0 )
	{
		$tree = array();

		foreach ( $elements as $element ) {
			if ( $element[ $this->role[ self::PARENT_ID_NAME ] ] == $parentId ) {
				$children = $this->createTree(
					$elements,
					$element[ $this->role[ self::ID_NAME ] ],
					( $depth + 1 )
				);
				$element[ $this->role[ self::DEPTH_NAME ] ] = $depth;
				if ( $children ) {
					$element[ $this->role[ self::CHILDREN_NAME ] ] = $children;
				}
				$tree[ $element[ $this->role[ self::ID_NAME ] ] ] = $element;
				unset( $elements[ $element[ $this->role[ self::ID_NAME ] ] ] );
			}
		}

		return $tree;
	}

	/**
	 * @return bool
	 */
	private function prepareFlatArray()
	{
		if ( self::isArrayAssoc( $this->flatArray ) )
			return true;

		$newFlat = [];

		foreach ( $this->flatArray as $value )
			$newFlat[ $value[ $this->role[ self::ID_NAME ] ] ] = $value;

		$this->flatArray = $newFlat;

		return true;
	}


	/**
	 * @param array $arr
	 * @return bool
	 */
	public static function isArrayAssoc( array $arr )
	{
		if ( array() === $arr ) return false;

		return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
	}


}