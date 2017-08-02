<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/22/2017 3:15 AM
 */

namespace Qpdb\QueryBuilder\Dependencies;


class QueryException extends \Exception
{

	const QUERY_ERROR_ELEMENT_NOT_FOUND             = 10;
	const QUERY_ERROR_ELEMENT_TYPE                  = 11;
	const QUERY_ERROR_WHERE_INVALID_PARAM_ARRAY     = 20;
	const QUERY_ERROR_WHERE_INVALID_OPERATOR        = 30;
	const QUERY_ERROR_INVALID_LIMIT                 = 40;
	const QUERY_ERROR_INVALID_LIMIT_ZERO            = 50;
	const QUERY_ERROR_INVALID_LIMIT_OFFSET          = 60;
	const QUERY_ERROR_DELETE_NOT_FILTER             = 70;

	const QUERY_ERROR_INVALID_FIELDS_COUNT          = 91;
	const QUERY_ERROR_INVALID_DISTINCT              = 92;
	const QUERY_ERROR_HAVING_INVALID_PARAM_ARRAY    = 93;
	const QUERY_ERROR_HAVING_INVALID_OPERATOR       = 94;

}