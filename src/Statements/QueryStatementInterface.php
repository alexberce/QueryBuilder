<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 5/21/2017 9:29 AM
 */

namespace Qpdb\QueryBuilder\Statements;


interface QueryStatementInterface
{

	const REPLACEMENT_NONE      = 0;
	const REPLACEMENT_VALUES    = 1;

	public function getSyntax();

	public function execute();

}