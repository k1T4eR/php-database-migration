<?php
namespace DatabaseMigration\Parser;

use DatabaseMigration\Database;

class ParseStrategy {

    /**
     * @param Database\DatabaseType $tp
     * @return AbstractParser
     */
    public function parserOf(Database\DatabaseType $tp) {
        if ($tp->isMysql()) {
            return new SqlParser();
        }
    }

}