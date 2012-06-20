<?php
namespace webignition\RobotsTxt\UserAgentDirective;

class UserAgentDirectiveList {
    
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
    public function add($userAgentString) {
        if (!$this->contains($userAgentString)) {
            $userAgent = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();
            $userAgent->setValue($userAgentString);
            
            $this->userAgents[] = $userAgent;
        }
    }
    
    
    /**
     *
     * @param string $userAgent 
     */
    public function remove($userAgent) {
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
    public function get() {        
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
    public function contains($userAgentString) {
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