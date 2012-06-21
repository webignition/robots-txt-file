<?php
namespace webignition\RobotsTxt\UserAgentDirective;

class UserAgentDirectiveList extends \webignition\RobotsTxt\Directive\DirectiveList {   
   
    /**
     *
     * @param string $userAgentString 
     */
    public function add($userAgentString) {
        parent::add('user-agent', $userAgentString);
    }
    
    
    /**
     *
     * @param string $userAgentString 
     */
    public function remove($userAgentString) {
        return parent::remove('user-agent', $userAgentString);
    }
    
    
    /**
     *
     * @return array
     */
    public function getValues() {        
        $userAgents = array();
        $userAgentDirectives = $this->get();
        
        foreach ($userAgentDirectives as $userAgent) {
            $userAgents[] = (string)$userAgent->getValue();
        }
        
        return $userAgents;
    }
    
    
    /**
     *
     * @return array
     */
    public function get() {
        $userAgents = parent::get();
        
        if (count($userAgents) === 0) {
            $defaultUserAgentDirective = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();
            $defaultUserAgentDirective->setValue('*');
            
            $userAgents[] = $defaultUserAgentDirective;
        }
        
        return $userAgents;
    }
    
    
    /**
     *
     * @param string $userAgentString
     * @return boolean 
     */
    public function contains($userAgentString) {
        return parent::contains('user-agent', $userAgentString);
    }
    
    
    /**
     *
     * @param string $field
     * @param string $value
     * @return \webignition\RobotsTxt\Directive\Directive 
     */
    protected function getNewDirective($field, $value) {
        $directive = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();
        $directive->setValue($value);
        
        return $directive;
    }    
    
}