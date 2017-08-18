<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 8/15/2017
 * Time: 12:15 PM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\Dependencies\QueryHelper;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;

trait SelectFields
{
	use Objects;

	/**
	 * @param string|array $fields
	 * @return $this
	 */
	public function fields( $fields )
	{
		if(is_array($fields))
			$fields = QueryHelper::implode( $fields, ', ' );

		$this->queryStructure->setElement(QueryStructure::FIELDS, $fields);
		return $this;
	}

}