<?php
namespace DatabaseMigration\Parser;

use DatabaseMigration\Query;
use DatabaseMigration\Source;

class SqlParser
    extends
        AbstractParser {

    public static $rDelimiter = '/[\r\n]{2,}/';
    public static $rLinebreakDelimiter = '/[\r\n]+/';
    public static $rComment = '/^--[^\n\r]*/';
    public static $rVersion = '/^--\s*v([0-9]+)/i';

    /**
     * @param Source\SourceInterface $source
     * @return Query[]
     */
    public function getQueries(Source\SourceInterface $source) {
        $matches = preg_split(static::$rDelimiter, $source->getContents());

        $queries = array_map(function ($match) {
            $lines = preg_split(static::$rLinebreakDelimiter, $match);

            $data = ['comments' => [], 'code' => [], 'version' => 0];

            foreach ($lines as $line) {
                if (preg_match(static::$rVersion, $line, $matches)) {
                    $data['version'] = (int)$matches[1];
                } elseif (preg_match(static::$rComment, $line)) {
                    $data['comments'][] = $line;
                } else {
                    $data['code'][] = $line;
                }
            }

            $data['code'] = join(PHP_EOL, $data['code']);
            return $this->buildQuery($data);
        }, $matches);

        return array_filter($queries, function(Query $query) {
            return !!$query->getCode();
        });
    }

}