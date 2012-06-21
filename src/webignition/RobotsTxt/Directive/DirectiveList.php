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
     * @param string $directiveString
     */
    public function add($directiveString) {
        if (!$this->contains($directiveString)) {            
            $this->directives[] = $this->getNewDirective($directiveString);
        }
    }
    
    
    /**
     *
     * @param string $directiveString 
     */
    public function remove($directiveString) {
        $directive = $this->getNewDirective($directiveString);
        
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
    public function getValues() {        
        $directives = array();
        foreach ($this->directives as $directive) {
            $directives[] = (string)$directive;
        }
        
        return $directives;
    }
    
    
    /**
     *
     * @return array
     */
    public function get() {
        return $this->directives;
    }
    
    
    /**
     *
     * @param string $userAgentString
     * @return boolean 
     */
    public function contains($directiveString) {
        $directive = $this->getNewDirective($directiveString);
        
        foreach ($this->directives as $existingDirective) {
            if ($directive->equals($existingDirective)) {
                return true;
            }
        }
        
        return false;
    }  
    
    
    /**
     *
     * @param string $directiveString
     * @return \webignition\RobotsTxt\Directive\Directive 
     */
    protected function getNewDirective($directiveString) {
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->parse($directiveString);
        
        return $directive;
    }
    
    
    /**
     *
     * @return string
     */
    public function __toString() {
        $string = '';
        $directives = $this->get();
        
        foreach ($directives as $directive) {
            $string .= $directive . "\n";
        }
        
        return trim($string);
    }
    
}