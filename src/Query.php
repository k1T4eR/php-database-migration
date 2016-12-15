<?php
namespace DatabaseMigration;

class Query {

    /** @var array */
    protected $_comments;

    /** @var string */
    protected $_code;

    /** @var int */
    protected $_version;

    public function __construct(array $data) {
        $this->setComments($data['comments']);
        $this->setCode($data['code']);
        $this->setVersion($data['version']);
    }

    public function assemble() {
        $v = "-- v$this->_version";
        $comments = join(PHP_EOL, $this->_comments);
        $s = $v . PHP_EOL;
        $s .= $comments ? $comments . PHP_EOL : '';
        return $s . $this->_code;
    }

    public function getCode() {
        return $this->_code;
    }

    public function setCode($code) {
        $this->_code = $code;
    }

    public function getVersion() {
        return $this->_version;
    }

    public function setVersion($version) {
        $this->_version = (int)$version;
    }

    public function getComments() {
        return $this->_comments;
    }

    public function setComments(array $comments) {
        $this->_comments = $comments;
    }

}