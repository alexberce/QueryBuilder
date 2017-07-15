<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 5/27/2017 12:38 PM
 */

return [

	'replicationEnable' => true,

	'slave_statements' => ['SELECT'],

	/**
	 * if not Replication support use only first entry in master_data_connect
	 */
	'master_data_connect' => [
		[
			'host' => 'localhost',
			'user' => 'guser',
			'password' => '1234',
			'dbname' => 'vstore'
		],
		[
			'host' => 'localhost',
			'user' => 'guser',
			'password' => '1234',
			'dbname' => 'vstore'
		]
	],

	'slave_data_connect' => [
		[
			'host' => 'localhost',
			'user' => 'guser',
			'password' => '1234',
			'dbname' => 'vstore'
		],
		[
			'host' => 'localhost',
			'user' => 'guser',
			'password' => '1234',
			'dbname' => 'vstore'
		]
	],

	'prefix' => 'vs_',

	'db_log' => [
		'enable_log_errors' => true,
		'enable_log_query_duration' => true,
		'log_path_errors' => '/tmp/db/errors/',
		'log_path_query_duration' => '/tmp/db/query_duration/',
	]

];