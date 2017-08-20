<?php
/**
 * Created by PhpStorm.
 * User: computer
 * Date: 7/27/2017
 * Time: 10:39 PM
 */

namespace Qpdb\QueryBuilder\Statements;


use Qpdb\QueryBuilder\QueryBuild;

class QueryCustom extends QueryStatement implements QueryStatementInterface
{

	public function __construct( QueryBuild $queryBuild, $table = null )
	{
		parent::__construct( $queryBuild, $table );
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