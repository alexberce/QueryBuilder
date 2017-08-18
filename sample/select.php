<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 8/1/2017
 * Time: 12:26 PM
 */

include_once 'autoloader.php';
use Qpdb\QueryBuilder\QueryBuild;

$sql = QueryBuild::select('::test')
	->fields([]);

echo $sql->getSyntax();

//echo phpversion();
//throw new \Qpdb\QueryBuilder\Dependencies\QueryException(\Qpdb\QueryBuilder\Dependencies\QueryException::QUERY_ERROR_INVALID_DISTINCT,'jnwoeoew');