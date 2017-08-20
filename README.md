# QueryBuilder

**QueryBuilder** is a user friendly php class that prevents mysql injections

### Requirements
* Php 5.4+
* Enable PDO (php.ini)
* MySql 5.5 / 5.6 / 5.7 / MariaDB

```
$sql = QueryBuild::select('employees')
        ->whereLike('firstName', '%arry%');
```