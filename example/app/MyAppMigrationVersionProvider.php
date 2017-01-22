<?php

require_once __DIR__.'/../../src/Version/VersionInterface.php';
require_once __DIR__.'/MyAppDatabase.php';

class MyAppMigrationVersionVersion
    implements
        DatabaseMigration\Version\VersionInterface {

    /**
     * @return int
     */
    public function get() {
        $statement = MyAppDatabase::getConnection()->prepare('SELECT version FROM migration');
        $statement->execute();
        return (int)$statement->fetchObject()->version;
    }

    /**
     * @param int $v
     * @return void
     */
    public function set($v) {
        $statement = MyAppDatabase::getConnection()->prepare('UPDATE migration SET version = ?');
        $statement->execute([$v]);
    }
}