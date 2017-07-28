<?php
/**
 * Created by PhpStorm.
 * User: computer
 * Date: 7/28/2017
 * Time: 12:59 PM
 */

namespace Qpdb\QueryBuilder\Dependencies;


class QueryConfig
{

    private static $instance;

    /**
     * @var array
     */
    private $queryConfig;


    private function __construct()
    {
        $configPath = __DIR__ . '/../config/query_config.php';
        $this->queryConfig = require $configPath;
    }


    /**
     * @return string
     */
    public function getTablePrefix()
    {
        return $this->queryConfig['table_prefix'];
    }


    /**
     * @return QueryConfig
     */
    public static function getInstance() {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

}