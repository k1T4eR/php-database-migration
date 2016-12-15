<?php
namespace DatabaseMigration\Version;

interface ProviderInterface {

    /**
     * @return int
     */
    public function getNumber();

    /**
     * @param int $v
     * @return mixed
     */
    public function setNumber($v);

}