# QueryBuilder

**QueryBuilder** is a user friendly php class that prevents mysql injections

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
array (size=23)
  0 => 
    array (size=5)
      'firstName' => string 'Diane' (length=5)
      'lastName' => string 'Murphy' (length=6)
      'jobTitle' => string 'President' (length=9)
      'city' => string 'San Francisco' (length=13)
      'country' => string 'USA' (length=3)
  1 => 
    array (size=5)
      'firstName' => string 'Mary' (length=4)
      'lastName' => string 'Patterson' (length=9)
      'jobTitle' => string 'VP Sales' (length=8)
      'city' => string 'San Francisco' (length=13)
      'country' => string 'USA' (length=3)
  2 => 
    array (size=5)
      'firstName' => string 'Jeff' (length=4)
      'lastName' => string 'Firrelli' (length=8)
      'jobTitle' => string 'VP Marketing' (length=12)
      'city' => string 'San Francisco' (length=13)
      'country' => string 'USA' (length=3)