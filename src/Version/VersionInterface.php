<?php
namespace DatabaseMigration\Version;

interface VersionInterface {
    /**
     * Returns current migration version.
     *
     * @return int
     */
    public function get();

    /**
     * Persists migration version.

     * @param int $version
     * @return void
     */
    public function set($version);
}