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
            $this->userAgents[] = $this->getNewUserAgent($userAgentString);
        }
    }
    
    
    /**
     *
     * @param string $userAgentString 
     */
    public function remove($userAgentString) {
        $userAgent = $this->getNewUserAgent($userAgentString);
        
        $userAgentPosition = null;
        foreach ($this->userAgents as $userAgentIndex => $existingUserAgent) {
            if ($userAgent->equals($existingUserAgent)) {
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
        $userAgent = $this->getNewUserAgent($userAgentString);
        
        foreach ($this->userAgents as $existingUserAgent) {
            if ($userAgent->equals($existingUserAgent)) {
                return true;
            }
        }
        
        return false;
    }
    
    
    /**
     *
     * @param type $userAgentString
     * @return \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective 
     */
    private function getNewUserAgent($userAgentString) {
        $userAgent = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();
        $userAgent->setValue($userAgentString);
        
        return $userAgent;
    }
    
}