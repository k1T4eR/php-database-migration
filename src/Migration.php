<?php
namespace DatabaseMigration;

require_once __DIR__.'/Database/AdapterInterface.php';
require_once __DIR__.'/Parser/AbstractParser.php';
require_once __DIR__.'/Source/SourceInterface.php';
require_once __DIR__.'/Version/VersionInterface.php';
require_once __DIR__.'/Query.php';

class Migration {

    /** @var Database\AdapterInterface */
    protected $_databaseAdapter;

    /** @var Source\SourceInterface */
    protected $_migrationSource;

    /** @var Version\VersionInterface */
    protected $_migrationVersion;

    /** @var Parser\AbstractParser */
    protected $_migrationParser;

    public function setDatabaseAdapter(Database\AdapterInterface $adapter) {
        $this->_databaseAdapter = $adapter;
    }

    public function setMigrationSource(Source\SourceInterface $source) {
        $this->_migrationSource = $source;
    }

    public function setMigrationVersion(Version\VersionInterface $version) {
        $this->_migrationVersion = $version;
    }

    public function setMigrationParser(Parser\AbstractParser $parser) {
        $this->_migrationParser = $parser;
    }

    public function run() {
        $currentVersion = $this->_migrationVersion->get();
        $queries        = $this->_migrationParser->getQueries($this->_migrationSource);

        foreach ($queries as $query) {
            $newVersion = $query->getVersion();

            if (!$newVersion || $newVersion > $currentVersion) {
                $currentVersion = time();

                echo 'Execute '.$query->getSource().PHP_EOL;
                $this->_databaseAdapter->query($query);
                $query->setVersion($currentVersion);

                $this->_migrationVersion->set($currentVersion);

                $this->_updateVersion($currentVersion);
                $this->_updateSource($queries);
            }
        }
    }

    protected function _updateVersion($version) {
        $this->_migrationVersion->set($version);
    }

    protected function _updateSource(array $queries) {
        $this->_migrationSource->setContents(join(PHP_EOL.PHP_EOL, array_map(function(Query $query) {
            return $query->assemble();
        }, $queries)));
    }
}