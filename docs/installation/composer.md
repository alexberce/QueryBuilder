## Installation with composer

Create file **composer.json** in destination folder.

 ```composer.json```
    
```php
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