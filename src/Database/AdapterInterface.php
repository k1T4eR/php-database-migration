<?php
namespace DatabaseMigration\Database;

use DatabaseMigration\Query;

interface AdapterInterface {
    /**
     * Executes given query.
     *
     * @param Query $query
     * @return void
     */
    public function query(Query $query);
}