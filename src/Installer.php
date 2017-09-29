<?php
/**
 * Created by PhpStorm.
 * User: Adrian Dumitru
 * Date: 9/29/2017
 * Time: 7:28 PM
 */

namespace Qpdb\QueryBuilder;


class Installer
{

	public static function postInstall()
	{
		$configPath = __DIR__ . '/../config22/';
		mkdir( $configPath, 0777 );
	}


}