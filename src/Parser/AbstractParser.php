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

    public function buildQuery(array $data) {
        return new Query($data);
    }

}