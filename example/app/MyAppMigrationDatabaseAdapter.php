<?php

require_once __DIR__.'/../../src/Database/AdapterInterface.php';
require_once __DIR__.'/MyAppDatabase.php';

class MyAppMigrationDatabaseAdapter
    implements
        DatabaseMigration\Database\AdapterInterface {

    /**
     * @param \DatabaseMigration\Query $query
     * @return void
     */
    public function query(\DatabaseMigration\Query $query) {
        MyAppDatabase::getConnection()->exec($query->getSource());
    }
}
