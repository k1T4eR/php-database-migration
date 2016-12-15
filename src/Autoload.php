<?php

function database_migration_autoload($className) {
    if (strpos($className, 'DatabaseMigration') === 0) {
        $tokens = explode('\\', $className);
        array_shift($tokens);
        require_once __DIR__ . '/' . join('/', $tokens) . '.php';
    }
}

spl_autoload_register('database_migration_autoload');