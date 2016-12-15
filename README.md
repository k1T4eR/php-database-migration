database-migration
==================

Example. MySql migration. Version is stored in database. Source code is taken from file.

Clone src into DatabaseMigration inside your library folder.

Setup database:
```SQL
CREATE TABLE IF NOT EXISTS `migration` (
  `version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert initial record
INSERT INTO `migration` (`version`) VALUES ('0');
```

Setup autoload:
 
```PHP
require_once PATH_TO_YOUR_LIBRARY . '/DatabaseMigration/Autoload.php';
```

Define database adapter:
```PHP
class DatabaseAdapter
    implements
      DatabaseMigration\Database\AdapterInterface {

    /**
     * @param \DatabaseMigration\Query $query
     * @return mixed
     */
    public function query(\DatabaseMigration\Query $query) {
        // run $query->getCode() here
    }
    
}
```

Define version provider:
```PHP
class VersionProvider
    implements
      \DatabaseMigration\Version\ProviderInterface {

    /**
     * @return int
     */
    public function getNumber() {
        // do something like 'SELECT version FROM migration'
    }

    /**
     * @param int $v
     * @return mixed
     */
    public function setNumber($v) {
      // do something like 'UPDATE migration SET version = $v'
    }
    
}
```

Instantiate dependencies and run migration:
```PHP
  $filename = './migration.sql'; // migrations are stored in file
  
  $source = new DatabaseMigration\Source\FileSource($filename);
  $type = new DatabaseMigration\Database\DatabaseType($filename);
  $adapter = new DatabaseAdapter();
  $versionProvider = new VersionProvider();
  
  $migration = new DatabaseMigration\Migration();
  $migration->setSource($source);
  $migration->setDatabaseType($type);
  $migration->setVersionProvider($versionProvider);
  $migration->setDatabaseAdapter($adapter);
  
  $migration->run();
```
