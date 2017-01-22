<?php

// Require migration library stuff
require_once __DIR__ . '/../src/Migration.php';
require_once __DIR__ . '/../src/Source/FileSource.php';
require_once __DIR__ . '/../src/Parser/SQLParser.php';

// Require app stuff
require_once __DIR__.'/app/MyAppDatabase.php';
require_once __DIR__.'/app/MyAppMigrationDatabaseAdapter.php';
require_once __DIR__.'/app/MyAppMigrationVersionProvider.php';

// Migrations are stored in file
$migrationFilepath = dirname(__FILE__).'/migrations.sql';
$migrationSource   = new DatabaseMigration\Source\FileSource($migrationFilepath);
$migrationVersion  = new MyAppMigrationVersionVersion();
$migrationParser   = new DatabaseMigration\Parser\SQLParser();
$databaseAdapter   = new MyAppMigrationDatabaseAdapter();

$migration = new DatabaseMigration\Migration();
$migration->setMigrationSource($migrationSource);
$migration->setMigrationVersion($migrationVersion);
$migration->setMigrationParser($migrationParser);
$migration->setDatabaseAdapter($databaseAdapter);

$migration->run();