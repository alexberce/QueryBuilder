<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 8/1/2017
 * Time: 12:26 PM
 */

include_once 'autoloader.php';
use Qpdb\QueryBuilder\QueryBuild;



$sql = QueryBuild::select('employees')
	->whereLike('firstName', '%arry%');

echo "<pre>" . print_r($sql->getSyntax(), 1) . "</pre>";
echo "<pre>" . print_r($sql->getBindParams(), 1) . "</pre>";
echo "<pre>" . print_r($sql->execute(), 1) . "</pre>";

var_dump(phpversion());
