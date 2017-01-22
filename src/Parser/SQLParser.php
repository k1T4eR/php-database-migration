<?php
namespace DatabaseMigration\Parser;

require_once __DIR__.'/../Query.php';
require_once __DIR__.'/../Source/SourceInterface.php';
require_once __DIR__.'/../Parser/AbstractParser.php';

use DatabaseMigration\Query;
use DatabaseMigration\Source;

class SQLParser
    extends
        AbstractParser {

    // Used to split text in groups: [version comment + query source].
    protected static $rQueriesDelimiter = '/[\r\n]{2,}/';

    // Used to split text by new line or carriage return.
    protected static $rNR = '/[\r\n]+/';

    // Used to check if line is SQL comment.
    protected static $rComment = '/^--[^\n\r]*/';

    // Used to match version from SQL comment.
    protected static $rVersion = '/^-- *v([0-9]+)/';

    /**
     * @param Source\SourceInterface $source
     * @return Query[]
     */
    public function getQueries(Source\SourceInterface $source) {
        $matches = preg_split(static::$rQueriesDelimiter, $source->getContents());

        return array_map(function ($match) {
            $lines   = preg_split(static::$rNR, $match);
            $version = null;
            $source  = null;

            foreach ($lines as $line) {
                if (trim($line)) {
                    if (preg_match(static::$rVersion, trim($line), $matches)) {
                        $version = (int)$matches[1];
                    } elseif (!preg_match(static::$rComment, trim($line))) {
                        $source = $line;
                    }
                }
            }

            return $this->instantiateQuery($source, $version);
        }, $matches);
    }
}