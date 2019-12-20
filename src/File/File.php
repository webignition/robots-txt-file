<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\File;

use webignition\RobotsTxt\DirectiveList\DirectiveList;
use webignition\RobotsTxt\Record\Record;

/**
 * Models a robots.txt file as derived from specifications at:
 * http://www.robotstxt.org/norobots-rfc.txt
 * http://www.robotstxt.org/orig.html
 * http://en.wikipedia.org/wiki/Robots_exclusion_standard
 *
 * Short format description:
 *
 * A robots txt file contains one or more _records_ or independent
 * _directives_
 *
 * A record starts with one or more _user_agent_strings_ followed
 * by one or more directives applying to matching user agents.
 *
 * A directive can be an Allow or Disallow instruction applying to
 * a specified user agent. Such directives are collected in a record.
 *
 * A directive can be independent of any user agent. An example
 * is a sitemap directive. This is termed a non-group directive.
 *
 */
class File
{
    /**
     * @var Record[]
     */
    private $records = [];

    /**
     * @var DirectiveList|null
     */
    private $nonGroupDirectives = null;

    public function getNonGroupDirectives(): DirectiveList
    {
        if (is_null($this->nonGroupDirectives)) {
            $this->nonGroupDirectives = new DirectiveList();
        }

        return $this->nonGroupDirectives;
    }

    public function addRecord(Record $record): void
    {
        $this->records[] = $record;
    }

    /**
     * @return Record[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    public function __toString(): string
    {
        $string = '';
        foreach ($this->records as $record) {
            $string .= $record . "\n\n";
        }

        $string .= (string)$this->getNonGroupDirectives();

        return trim($string);
    }
}
