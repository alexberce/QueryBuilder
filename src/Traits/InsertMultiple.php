<?php
/**
 * Created by PhpStorm.
 * User: computer
 * Date: 7/9/2017
 * Time: 10:41 AM
 */

namespace Qpdb\QueryBuilder\Traits;


use Qpdb\QueryBuilder\Dependencies\QueryException;
use Qpdb\QueryBuilder\Dependencies\QueryHelper;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;

trait InsertMultiple
{

    use Objects;


    /**
     * @param string|array $fieldList
     * @return $this
     */
    public function setFieldsList( $fieldList )
    {
        if(!is_array($fieldList))
            $fieldList = QueryHelper::explode($fieldList);

        $this->queryStructure->replaceElement(QueryStructure::FIELDS, $fieldList );

        return $this;
    }

    /**
     * @param array $rowValues
     * @return $this
     * @throws QueryException
     */
    public function addRow(array $rowValues )
    {
        if($this->getNumberOfFields() !== count($rowValues))
            throw new QueryException('Ivalid number of fields.', QueryException::QUERY_ERROR_INVALID_FIELDS_COUNT);

        $pdoRowValues = array();

        foreach ($rowValues as $value)
            $pdoRowValues[] = $this->queryStructure->bindParam('value', $value);

        $pdoRowValuesString = '( ' . QueryHelper::implode($pdoRowValues,', ') . ' )';

        $this->queryStructure->setElement(QueryStructure::SET_FIELDS, $pdoRowValuesString );

        return $this;
    }

    /**
     * @param array $rows
     * @return $this
     */
    public function addMultipleRows(array $rows )
    {
        foreach ($rows as $row)
            $this->addRow($row);

        return $this;
    }

    /**
     * @return string
     */
    private function getInsertMultipleRowsSyntax()
    {
        $fields =  '( ' . QueryHelper::implode($this->queryStructure->getElement(QueryStructure::FIELDS), ', ') . ' )';
        $values = QueryHelper::implode($this->queryStructure->getElement(QueryStructure::SET_FIELDS), ', ');
        return $fields . ' VALUES ' . $values;
    }

    /**
     * @return int
     */
    private function getNumberOfFields()
    {
        return count($this->queryStructure->getElement(QueryStructure::FIELDS));
    }


}