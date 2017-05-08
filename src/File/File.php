<?php
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
 * by one or more directives applying to matching user agents
 *
 * A directive can be an Allow or Disallow instruction applying to
 * a specified user agent. Such directives are collected in a record.
 *
 * A directive can be independent of any user agent. An example
 * is a sitemap directive.
 *
 */
class File
{
    /**
     * @var Record[]
     */
    private $records = array();

    /**
     * @var DirectiveList|null
     */
    private $directiveList = null;

    /**
     * @return DirectiveList
     */
    public function directiveList()
    {
        if (is_null($this->directiveList)) {
            $this->directiveList = new DirectiveList();
        }

        return $this->directiveList;
    }

    /**
     * @param Record $record
     */
    public function addRecord(Record $record)
    {
        $this->records[] = $record;
    }

    /**
     * @return Record[]
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = '';
        foreach ($this->records as $record) {
            $string .= $record . "\n\n";
        }

        $string .= (string)$this->directiveList();

        return trim($string);
    }
}
