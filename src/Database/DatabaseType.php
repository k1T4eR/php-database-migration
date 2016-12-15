<?php
namespace DatabaseMigration\Database;

class DatabaseType {

    public static $rMysql = '/(sql|mysql)$/i';

    protected $_id;

    public function __construct($id) {
        $this->_id = $id;
    }

    public function isMysql() {
        return preg_match(static::$rMysql, $this->_id);
    }

}

