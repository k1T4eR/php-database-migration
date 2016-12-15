<?php
namespace DatabaseMigration\Source;

interface SourceInterface {

    /**
     * @param string $contents
     * @return mixed
     */
    public function setContents($contents);

    /**
     * @return string
     */
    public function getContents();

}