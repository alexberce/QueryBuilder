<?php
/**
 * Created by PhpStorm.
 * User: computer
 * Date: 7/9/2017
 * Time: 10:41 AM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\Dependencies\QueryStructure;

trait InsertMultiple
{

    use Objects;

    /**
     * @param array $fieldsArray
     * @param array $valuesArray
     * @return $this
     *
     * @sample: ->insertMultipleRows(
               [field1, field2, field3, ... ],
               [
                   [field1_v1, field2_v1, field3_v1, ... ],
                   [field1_v2, field2_v2, field3_v2, ... ],
                   [field1_v3, field2_v3, field3_v3, ... ],
                   ...
               ]
     )
     *
     */
    public function multipleRows( array $fieldsArray, array $valuesArray )
    {
        $this->queryStructure->setElement(QueryStructure::MULTIPLE_ROWS, 1);

        return $this;
    }

}