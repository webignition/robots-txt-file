<?php
namespace webignition\RobotsTxt\File;

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
class File {

    /**
     *
     * @var array
     */
    private $records = array();
    
    /**
     *
     * @var type 
     */
    private $directiveList = null;
    
    
    /**
     *
     * @return \webignition\RobotsTxt\DirectiveList\DirectiveList 
     */
    public function directiveList() {
        if (is_null($this->directiveList)) {
            $this->directiveList = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
        }
        
        return $this->directiveList;        
    }    
    
    
    /**
     *
     * @param \webignition\RobotsTxt\Record\Record $record 
     */
    public function addRecord(\webignition\RobotsTxt\Record\Record $record) {
        $this->records[] = $record;        
    }
    
    /**
     * 
     * @return array
     */
    public function getRecords() {
        return $this->records;
    }
    
    
    /**
     *
     * @param string $userAgentString
     * @return \webignition\RobotsTxt\DirectiveList\DirectiveList 
     */
    public function getDirectivesFor($userAgentString) {        
        foreach ($this->getRecords() as $record) {
            /* @var $record \webignition\RobotsTxt\Record\Record */
            if ($record->userAgentDirectiveList()->contains($userAgentString)) {
                return $record->directiveList();
            }
        }
        
        foreach ($this->getRecords() as $record) {
            /* @var $record \webignition\RobotsTxt\Record\Record */
            if ($record->userAgentDirectiveList()->contains('*')) {
                return $record->directiveList();
            }
        }
        
        return new \webignition\RobotsTxt\DirectiveList\DirectiveList();
    }
    
    /**
     *
     * @return string 
     */
    public function __toString() {
        $string = '';
        foreach ($this->records as $record) {
            $string .= $record . "\n\n";
        }
        
        $string .= (string)$this->directiveList();
        
        return trim($string);
    }  
}