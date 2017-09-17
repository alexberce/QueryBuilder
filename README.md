# QueryBuilder

**QueryBuilder** is a user friendly php class for build MySql queries that prevents mysql injections and it takes care of table prefixing. This same can also replication support for use master and slave.

### Requirements
* Php 5.4+
* Enable PDO (php.ini)
* MySql 5.5 / 5.6 / 5.7 / MariaDB

### Installation
* [With composer](docs/installation/composer.md)
* [Manual installation](docs/installation/manual.md)

### Configuration
To use this package, you need to configure it. Configuration files can be found in the QueryBuilder / config folder. There are 2 configuration files:
- **db_config.php**:set up database credentials (*slave_data_connect* array), logs location (query time and errors). If *replicationEnable* is true, the slave credentials are required. There may be one or more slave connections. In the *slave_data_connect* array, there must be as many inputs as we have of the slave connections we have.
- **query_config.php**: if a prefix table is used, a prefix can be set and queryBuilder will automatically put the prefix of the table.
