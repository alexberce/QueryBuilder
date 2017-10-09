## Manual installation

1. Download the [latest version](https://github.com/adumitru68/QueryBuilder/releases) of the project.
2. Create the autoload file ```autoload.php``` outside the QueryBuilder folder.
3. Include the autoload.php file in your project.

#### Autoload file example ```autoload.php```

```PHP
spl_autoload_register(

    /**
     * @param $class
     */
	function ( $class ) {

		$nameSpace = str_replace( '\\', '/', trim( $class, '\\' ) ) . '.php';
		$nameSpace = str_replace( 'Qpdb/QueryBuilder/', '', $nameSpace );
		$includeFile = __DIR__ . '/path/to/QueryBuilder/src/' . $nameSpace;

		require_once( $includeFile );

	}

);
```