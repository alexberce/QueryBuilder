<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 4/29/2017 7:51 PM
 */

spl_autoload_register(

/**
 * @param $class
 */
    function( $class )
    {
        $basePath = trim( $_SERVER['DOCUMENT_ROOT'], '/');
        $nameSpace = str_replace( '\\', '/', trim($class, '\\') ) . '.php';
        $nameSpace = str_replace('Adi/QueryBuilder/', '/QueryBuilder/', $nameSpace);
        $classFile = $basePath . $nameSpace;
        require_once ( $classFile );
    }

);