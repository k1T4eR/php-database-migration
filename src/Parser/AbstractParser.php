<?php
namespace DatabaseMigration\Parser;

use DatabaseMigration\Query;
use DatabaseMigration\Source;

abstract class AbstractParser {

    /**
     * @param Source\SourceInterface $source
     * @return Query[]
     */
    abstract public function getQueries(Source\SourceInterface $source);

    protected function instantiateQuery($source, $version) {
        return new Query($source, $version);
    }

}