<?php
/**
 * Created by PhpStorm.
 * User: computer
 * Date: 6/27/2017
 * Time: 8:47 AM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\Dependencies\QueryStructure;

trait Ignore
{

    use Objects;

    /**
     * @return $this
     */
    public function ignore()
    {
        $this->queryStructure->setElement(QueryStructure::IGNORE, 1);
        return $this;
    }


}