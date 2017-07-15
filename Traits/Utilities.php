<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 5/26/2017 11:00 PM
 */

namespace Adi\QueryBuilder\Traits;


use Adi\QueryBuilder\Dependencies\QueryStructure;

trait Utilities
{

	use Objects;


	/**
	 * @param string $comment
	 * @return $this
	 */
	public function withComment( $comment = '' )
	{
		$this->queryStructure->setElement(QueryStructure::QUERY_COMMENT, $comment);
		return $this;
	}

	/**
	 * @param string $identifier
	 * @return $this
	 */
	public function withLogIdentifier( $identifier = null )
	{
		$this->queryStructure->setElement(QueryStructure::QUERY_IDENTIFIER, $identifier);
		return $this;
	}

}