<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 8/1/2017
 * Time: 12:26 PM
 */

include_once 'autoloader.php';
use Qpdb\QueryBuilder\QueryBuild;

function exception_handler( $exception )
{
	/**
	 * @var \Exception $exception
	 */
	echo "Uncaught exception: ", $exception->getMessage(), "\n", $exception->getCode();
	var_dump( end( $exception->getTrace() ) );
}

set_exception_handler( 'exception_handler' );

$sql = QueryBuild::select( QueryBuild::select( 'kbs' ) )
	->fields( [] );

echo $sql->getSyntax();

//var_dump(\Qpdb\QueryBuilder\Statements\QueryStatement::QUERY_STATEMENT_DELETE);
