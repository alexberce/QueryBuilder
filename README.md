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

### Configuration

By default MysqlBuilder searches for configuration data (credentials, paths, etc) in the file ```vendor/qpdb/query_builder/sample-config/qpdb_db_config.php```. But it's not recommended to edit this file because it's overwritten by composer.
Configure QueryBuilder using one of two options below:

**Option 1** ( easy configuration )

- **Step 1:** Create a ```vendor-cfg``` folder on the same level as the ```vendor``` folder.
- **Step 2:** Copy file ```qpdb_db_config.php``` into ```vendor-cfg```.
- **Step 3:** Editeza fisierul ```vendor-cfg/qpdb_db_config.php```.

**Option 2** ( if there is already a configuration folder, for example ```config```)

- **Step 1:** Creates a file in any existing or newly created folder. For example, ```config/qpdb_db_loader.php```
```php
use Qpdb\QueryBuilder\DB\DbConfig;
$configFile = __DIR__ . '/relative/path/to/qpdb_db_config.php';
DbConfig::getInstance()->withFileConfig($configFile);
```
- **Step 2:** Add autoload json key in ```composer.json```
```
{
    "require": {
        "qpdb/query-builder": "^1.0"
    },
    "autoload": {
        "files": ["config/qpdb_db_loader.php"]
    }
}
```
- **Step 3:** Run ```composer update```

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
