## Installation with composer

Create file **composer.json** in root folder.

 ```composer.json```
    
```php
{
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "Qpdb/QueryBuilder",
                "version": "1.0",
                "source": {
                    "url": "https://github.com/adumitru68/QueryBuilder.git",
                    "type": "git",
                    "reference": "1.0"
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
        "Qpdb/QueryBuilder": "1.0"
    }
}
```