- config/
- project/
- vendor/

- **Step 1:** Creates a file in any existing or newly created folder. For example, ```config/my_loader.php```. 
Then create a copy of the ```qpdb_db_config.php``` file from the vendor folder in any location, preferably ```config/qpdb_db_config.php```
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
        "files": ["config/my_loader.php"]
    }
}
```
- **Step 3:** Run ```composer update```
- **Step 4:** Edit file ```config/qpdb_db_config.php```.
