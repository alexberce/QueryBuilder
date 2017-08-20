<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/30/2017 9:55 PM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\Dependencies\QueryHelper;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;

trait GroupBy
{

	use Objects;


	/**
	 * @param $field
	 * @param null $direction
	 * @return $this
	 */
	public function groupBy( $field, $direction = null )
	{
		$expression = QueryHelper::alphaNum( $field );

		if ( !is_null( $direction ) ) {
			$direction = strtoupper( $direction );
			$expression .= ' ' . $direction;
		}

		$this->queryStructure->setElement( QueryStructure::GROUP_BY, $expression );

		return $this;
	}

	private function getGroupBySyntax()
	{

		if ( count( $this->queryStructure->getElement( QueryStructure::GROUP_BY ) ) )
			return 'GROUP BY ' . implode( ', ', $this->queryStructure->getElement( QueryStructure::GROUP_BY ) );

		return '';
	}

}