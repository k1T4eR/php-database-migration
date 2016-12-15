<?php
namespace DatabaseMigration\Database;

use DatabaseMigration\Query;

interface AdapterInterface {

    /**
     * @param Query $query
     * @return mixed
     */
    public function query(Query $query);

}