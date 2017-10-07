# QueryBuilder

**QueryBuilder** is a user friendly php class for build MySql queries that prevents mysql injections and it takes care of table prefixing. This same can also replication support for use master and slave.

### Requirements
* Php 5.4+
* Enable PDO (php.ini)
* MySql 5.5 / 5.6 / 5.7 / MariaDB

### Installation

```
composer require qpdb/query-builder
```
If you do not use composer, you can [manually install](docs/installation/manual.md) this library.



### How do we use?
```php
include_once 'path/to/vendor/autoload.php';

use Qpdb\QueryBuilder\QueryBuild;

$result = QueryBuild::select( 'employees' )
	->whereEqual( 'firstName', "leslie" )
	->execute();
```
The result **$result** is array:
```php

Array
(
	[0] => Array
	    (
		[employeeNumber] => 1165
		[lastName] => Jennings
		[firstName] => Leslie
		[extension] => x3291
		[email] => ljennings@classicmodelcars.com
		[officeCode] => 1
		[reportsTo] => 1143
		[jobTitle] => Sales Rep
	    )

	[1] => Array
	    (
		[employeeNumber] => 1166
		[lastName] => Thompson
		[firstName] => Leslie
		[extension] => x4065
		[email] => lthompson@classicmodelcars.com
		[officeCode] => 1
		[reportsTo] => 1143
		[jobTitle] => Sales Rep
	    )

)

```
