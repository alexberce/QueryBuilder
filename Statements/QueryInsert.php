<?php
/**
 * Created by PhpStorm.
 * User: computer
 * Date: 6/27/2017
 * Time: 1:51 PM
 */

namespace Adi\QueryBuilder\Statements;


use Adi\QueryBuilder\QueryBuild;
use Adi\QueryBuilder\Traits\Ignore;
use Adi\QueryBuilder\Traits\InsertMultiple;
use Adi\QueryBuilder\Traits\Replacement;
use Adi\QueryBuilder\Traits\SetFields;
use Adi\QueryBuilder\Traits\Utilities;

class QueryInsert extends QueryStatement implements QueryStatementInterface
{

    use InsertMultiple, Replacement, SetFields, Ignore, Utilities;

    /**
     * @var string
     */
    protected $statement = 'INSERT';


    /**
     * QueryInsert constructor.
     * @param QueryBuild $queryBuild
     * @param null $table
     */
    public function __construct(QueryBuild $queryBuild, $table = null)
    {
        parent::__construct($queryBuild, $table);
    }

    public function getSyntax()
    {
        // TODO: Implement getSyntax() method.
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }
}