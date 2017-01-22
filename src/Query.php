<?php
namespace DatabaseMigration;

class Query {

    /** @var string */
    protected $_source;

    /** @var int */
    protected $_version;

    public function __construct($source, $version) {
        $this->setSource($source);
        $this->setVersion($version);
    }

    public function assemble() {
        return "-- v$this->_version".PHP_EOL.$this->_source;
    }

    public function getSource() {
        return $this->_source;
    }

    public function setSource($code) {
        $this->_source = $code;
    }

    public function getVersion() {
        return $this->_version;
    }

    public function setVersion($version) {
        $this->_version = (int)$version;
    }
}