<?php
/**
 * Created by PhpStorm.
 * User: computer
 * Date: 6/27/2017
 * Time: 11:18 AM
 */

namespace Adi\QueryBuilder\Statements;


use Adi\QueryBuilder\DB\DbService;
use Adi\QueryBuilder\Dependencies\QueryException;
use Adi\QueryBuilder\Dependencies\QueryStructure;
use Adi\QueryBuilder\QueryBuild;
use Adi\QueryBuilder\Traits\Ignore;
use Adi\QueryBuilder\Traits\Limit;
use Adi\QueryBuilder\Traits\OrderBy;
use Adi\QueryBuilder\Traits\Replacement;
use Adi\QueryBuilder\Traits\SetFields;
use Adi\QueryBuilder\Traits\Utilities;
use Adi\QueryBuilder\Traits\Where;

class QueryDelete extends QueryStatement implements QueryStatementInterface
{

    use Limit, Where, Replacement, OrderBy, SetFields, Ignore, Utilities;

    protected $statement = 'DELETE';


    /**
     * QueryDelete constructor.
     * @param QueryBuild $queryBuild
     * @param null $table
     */
    public function __construct(QueryBuild $queryBuild, $table = null)
    {
        parent::__construct($queryBuild, $table);
    }

    public function getSyntax()
    {
        $syntax = array();

        /**
         * UPDATE statement
         */
        $syntax[] = $this->statement;

        /**
         * TABLE update
         */
        $syntax[] = 'FROM ' . $this->queryStructure->getElement(QueryStructure::TABLE);

        /**
         * WHERE clause
         */
        $syntax[] = $this->getWhereSyntax();

        /**
         * ORDER BY clause
         */
        $syntax[] = $this->getOrderBySyntax();

        /**
         * LIMIT clause
         */
        $syntax[] = $this->getLimitSyntax();

        $syntax = implode(' ',$syntax);

        return $this->getSyntaxReplace( $syntax );
    }

    /**
     * @return array|int|null
     * @throws QueryException
     */
    public function execute()
    {

        if(
            $this->queryStructure->getElement((QueryStructure::WHERE_TRIGGER)) &&
            !count($this->queryStructure->getElement(QueryStructure::WHERE))
        )
            throw new QueryException('Where clause is required for this statement!', QueryException::QUERY_ERROR_DELETE_NOT_WHERE);

        return DbService::getInstance()->query(
            $this->getSyntax(),
            $this->queryStructure->getElement(QueryStructure::BIND_PARAMS)
        );
    }


}