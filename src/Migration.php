<?php
namespace DatabaseMigration;

class Migration {

    /** @var Database\DatabaseType */
    protected $_dbType;

    /** @var Database\AdapterInterface */
    protected $_dbAdapter;

    /** @var Source\SourceInterface */
    protected $_source;

    /** @var Version\ProviderInterface */
    protected $_versionProvider;

    /** @var Parser\ParseStrategy */
    protected $_parseStrategy;

    public function setSource(Source\SourceInterface $source) {
        $this->_source = $source;
    }
    
    public function setDatabaseAdapter(Database\AdapterInterface $adapter) {
        $this->_dbAdapter = $adapter;
    }

    public function setDatabaseType(Database\DatabaseType $tp) {
        $this->_dbType = $tp;
    }

    public function setVersionProvider(Version\ProviderInterface $provider) {
        $this->_versionProvider = $provider;
    }

    public function setParseStrategy(Parser\ParseStrategy $strategy) {
        $this->_parseStrategy = $strategy;
    }

    public function run() {
        $v = $this->_versionProvider->getNumber();
        $parser = $this->__getParser();
        $queries = $parser->getQueries($this->_source);

        foreach ($queries as $query) {
            $newV = $query->getVersion();

            if (!$newV || $newV > $v) {
                $v = $newV ? : time();

                $this->_dbAdapter->query($query);
                $query->setVersion($v);

                $this->__updateVersion($v);
                $this->__updateSource($queries);
            }
        }
    }

    protected function __updateVersion($v) {
        $this->_versionProvider->setNumber($v);
    }

    protected function __updateSource(array $queries) {
        $this->_source->setContents(join("\n\n", array_map(function (Query $query) {
            return $query->assemble();
        }, $queries)));
    }

    protected function __getParser() {
        if (!$this->_parseStrategy) {
            $this->_parseStrategy = new Parser\ParseStrategy();
        }

        return $this->_parseStrategy->parserOf($this->_dbType);
    }

}