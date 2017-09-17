<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 8/1/2017
 * Time: 12:26 PM
 */

//include_once 'autoloader.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
var_dump($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
var_dump(__DIR__);
use Qpdb\QueryBuilder\QueryBuild;



$sql = QueryBuild::select('employees')
	->fields("employees.*, offices.city, offices.country")
	->innerJoin('offices', 'employees.officeCode', 'offices.officeCode')
	//->groupBy('country DESC')
	;

//$sql = QueryBuild::select('employees')
//	->whereLike('lastName','%bo%')
//;

echo "<pre>" . print_r($sql->getSyntax(),1) . "</pre>";
echo "<pre>" . print_r($sql->getBindParams(),1) . "</pre>";
echo "<pre>" . print_r($sql->execute(),1) . "</pre>";


