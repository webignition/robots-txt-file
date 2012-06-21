<?php
namespace webignition\RobotsTxt\Record;

/**
 * From http://www.robotstxt.org/norobots-rfc.txt:
 * 
 *   The record starts with one or more User-agent lines, specifying
 *   which robots the record applies to, followed by [directives]
 * 
 */
class Record {
    
    /**
     *
     * @var \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList
     */
    private $userAgentDirectiveList = null;
    
    /**
     *
     * @var \webignition\RobotsTxt\Directive\DirectiveList
     */
    private $directiveList = null;
    
    
    /**
     *
     * @return \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList
     */
    public function userAgentDirectiveList() {
        if (is_null($this->userAgentDirectiveList)) {
            $this->userAgentDirectiveList = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList();
        }
        
        return $this->userAgentDirectiveList;
    }
    
    /**
     *
     * @return \webignition\RobotsTxt\Directive\DirectiveList 
     */
    public function directiveList() {
        if (is_null($this->directiveList)) {
            $this->directiveList = new \webignition\RobotsTxt\Directive\DirectiveList();
        }
        
        return $this->directiveList;        
    }
    
}
