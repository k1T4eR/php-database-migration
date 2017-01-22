<?php
namespace DatabaseMigration\Source;

require_once __DIR__.'/SourceInterface.php';

class FileSource
    implements
        SourceInterface {

    /** @var string */
    protected $_filename;

    /**
     * @param string $filename
     */
    public function __construct($filename) {
        $this->_filename = $filename;
    }

    /**
     * @param string $contents
     * @return void
     */
    public function setContents($contents) {
        file_put_contents($this->_filename, $contents);
    }

    /**
     * @return string
     */
    public function getContents() {
        return file_get_contents($this->_filename);
    }

}