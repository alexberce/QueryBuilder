# QueryBuilder

**QueryBuilder** is a user friendly php class for build MySql queries that prevents mysql injections and it takes care of table prefixing. This same can also support replication master and slave.

### Requirements
* Php 5.4+
* Enable PDO (php.ini)
* MySql 5.5 / 5.6 / 5.7 / MariaDB

### Installation
* With composer
```
{
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "QueryBuilder",
        "version": "1.0",
        "source": {
          "url": "https://github.com/adumitru68/QueryBuilder.git",
          "type": "git",
          "reference": "master"
        },
        "autoload": {
          "psr-4": {
            "Qpdb\\QueryBuilder\\": "src/"
          }
        }
      }
    }
  ],
  "require": {
    "QueryBuilder": "1.0"
  }
}
```
