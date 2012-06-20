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
     * Collection of UserAgentDirective objects
     * 
     * @var array
     */
    private $userAgents = array();
    
    
    /**
     *
     * @param string $userAgentString 
     */
    public function addUserAgent($userAgentString) {
        if (!$this->containsUserAgent($userAgentString)) {
            $userAgent = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();
            $userAgent->setValue($userAgentString);
            
            $this->userAgents[] = $userAgent;
        }
    }
    
    
    /**
     *
     * @param string $userAgent 
     */
    public function removeUserAgent($userAgent) {
        $userAgentPosition = null;
        foreach ($this->userAgents as $userAgentIndex => $existingUserAgent) {            
            if ($userAgent == (string)$existingUserAgent->getValue()) {
                $userAgentPosition = $userAgentIndex;
            }
        }
        
        if (!is_null($userAgentPosition)) {
            unset($this->userAgents[$userAgentPosition]);
        }
    }
    
    
    /**
     *
     * @return array
     */
    public function getUserAgentList() {        
        $userAgents = array();
        foreach ($this->userAgents as $userAgent) {
            $userAgents[] = (string)$userAgent->getValue();
        }
        
        if (count($userAgents) === 0) {
            $userAgents[] = '*';
        }
        
        return $userAgents;
    }
    
    
    /**
     *
     * @param string $userAgentString
     * @return boolean 
     */
    public function containsUserAgent($userAgentString) {
        $userAgent = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();
        $userAgent->setValue($userAgentString);
        
        foreach ($this->userAgents as $existingUserAgent) {
            if ((string)$userAgent->getValue() == (string)$existingUserAgent->getValue()) {
                return true;
            }
        }
        
        return false;
    }
    
}
