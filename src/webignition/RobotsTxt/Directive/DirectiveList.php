<?php
namespace webignition\RobotsTxt\Directive;

class DirectiveList {
    
    /**
     * Collection of UserAgentDirective objects
     * 
     * @var array
     */
    private $directives = array();
    
    
    /**
     *
     * @param string $field
     * @param string $value 
     */
    public function add($field, $value) {
        if (!$this->contains($field, $value)) {            
            $this->directives[] = $this->getNewDirective($field, $value);
        }
    }
    
    
    /**
     *
     * @param string $userAgent 
     */
    public function remove($field, $value) {
        $directive = $this->getNewDirective($field, $value);
        
        $directivePosition = null;
        foreach ($this->directives as $userAgentIndex => $existingUserAgent) {
            if ($directive->equals($existingUserAgent)) {
                $directivePosition = $userAgentIndex;
            }
        }
        
        if (!is_null($directivePosition)) {
            unset($this->directives[$directivePosition]);
        }
    }
    
    
    /**
     *
     * @return array
     */
    public function get() {        
        $directives = array();
        foreach ($this->directives as $directive) {
            $directives[] = (string)$directive;
        }
        
        return $directives;
    }
    
    
    /**
     *
     * @param string $userAgentString
     * @return boolean 
     */
    public function contains($field, $value) {
        $directive = $this->getNewDirective($field, $value);
        
        foreach ($this->directives as $existingDirective) {
            if ($directive->equals($existingDirective)) {
                return true;
            }
        }
        
        return false;
    }  
    
    
    /**
     *
     * @param string $field
     * @param string $value
     * @return \webignition\RobotsTxt\Directive\Directive 
     */
    private function getNewDirective($field, $value) {
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->setField($field);
        $directive->setValue($value);
        
        return $directive;
    }
    
    
}