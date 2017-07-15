<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 5/21/2017 9:29 AM
 */

namespace Adi\QueryBuilder\Statements;


interface QueryStatementInterface
{

    const REPALCEMENT_NONE      = 0;
    const REPALCEMENT_VALUES     = 1;
    const REPALCEMENT_MASK      = 2;

	public function getSyntax();

	public function execute();

}