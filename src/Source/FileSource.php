<?php
namespace DatabaseMigration\Source;

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
     * @return mixed
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