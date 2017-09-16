# QueryBuilder

**QueryBuilder** is a user friendly php class for build MySql queries that prevents mysql injections and it takes care of table prefixing. This same can also support replication master and slave.

### Requirements
* Php 5.4+
* Enable PDO (php.ini)
* MySql 5.5 / 5.6 / 5.7 / MariaDB

```PHP
$sql = QueryBuild::select('employees')
	->fields("firstName, lastName, jobTitle, offices.city, offices.country")
	->innerJoin('offices', 'employees.officeCode', 'offices.officeCode');
```

```PHP
Array
(
    [0] => Array
        (
            [employeeNumber] => 1002
            [lastName] => Murphy
            [firstName] => Diane
            [extension] => x5800
            [email] => dmurphy@classicmodelcars.com
            [officeCode] => 1
            [reportsTo] => 
            [jobTitle] => President
            [city] => San Francisco
            [country] => USA
            [ss] => 10
        )

    [1] => Array
        (
            [employeeNumber] => 1501
            [lastName] => Bott
            [firstName] => Larry
            [extension] => x2311
            [email] => lbott@classicmodelcars.com
            [officeCode] => 7
            [reportsTo] => 1102
            [jobTitle] => Sales Rep
            [city] => London
            [country] => UK
            [ss] => 2
        )
	...
```	
      
