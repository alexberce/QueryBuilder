### With composer

- **Step 1:** Creates a file in any existing or newly created folder. For example, ```config/my_loader.php```. 
Then create a copy of the ```vendor/qpdb/query_builder/sample-config/qpdb_db_config.php``` in any location, preferably ```config/qpdb_db_config.php```
```php
use Qpdb\QueryBuilder\DB\DbConfig;

DbConfig::getInstance()->withFileConfig( __DIR__ . '/relative/path/to/qpdb_db_config.php' );
```
- **Step 2:** Add autoload files key in ```composer.json```
```
{
    "require": {
        "qpdb/query-builder": "^1.0"
    },
    "autoload": {
        "files": ["config/my_loader.php"]
    }
}
```
- **Step 3:** Run ```composer update```
- **Step 4:** Edit file ```config/qpdb_db_config.php```.

### Using custom autoload file

Create an autoload customize file, for example ```config/autoload.php```:

```php
use Qpdb\QueryBuilder\DB\DbConfig;

require __DIR__ . '/relative/path/to/vendor/autoload.php'

DbConfig::getInstance()->withFileConfig( __DIR__ . '/relative/path/to/qpdb_db_config.php' );
```

Includes in your project the ```config/autoload.php``` file that already ```contains vendor/autoload.php```.

