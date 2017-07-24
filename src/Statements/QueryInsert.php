<?php
/**
 * Created by PhpStorm.
 * User: computer
 * Date: 6/27/2017
 * Time: 1:51 PM
 */

namespace Qpdb\QueryBuilder\Statements;


use Qpdb\QueryBuilder\DB\DbService;
use Qpdb\QueryBuilder\Dependencies\QueryStructure;
use Qpdb\QueryBuilder\QueryBuild;
use Qpdb\QueryBuilder\Traits\Ignore;
use Qpdb\QueryBuilder\Traits\InsertMultiple;
use Qpdb\QueryBuilder\Traits\Replacement;
use Qpdb\QueryBuilder\Traits\SetFields;
use Qpdb\QueryBuilder\Traits\Utilities;

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
	    $syntax = array();

	    /**
	     * UPDATE statement
	     */
	    $syntax[] = $this->statement;

	    /**
	     * IGNORE clause
	     */
	    $syntax[] = $this->queryStructure->getElement(QueryStructure::IGNORE) ? 'IGNORE' : '';

	    /**
	     * INTO table
	     */
	    $syntax[] = 'INTO ' . $this->queryStructure->getElement(QueryStructure::TABLE);

	    /**
	     * FIELDS update
	     */
	    $syntax[] = $this->getSettingFieldsSyntax();

	    $syntax = implode(' ',$syntax);

	    return $this->getSyntaxReplace( $syntax );

    }

    public function execute()
    {
	    return DbService::getInstance()->query(
		    $this->getSyntax(),
		    $this->queryStructure->getElement(QueryStructure::BIND_PARAMS)
	    );
    }


}