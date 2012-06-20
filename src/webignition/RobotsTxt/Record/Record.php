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
     * Collection of Directive objects
     * 
     * @var array
     */
    private $directives = array();
    
    
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
     * @param string $field
     * @param string $value 
     */
    public function addDirective($field, $value) {
        if (!$this->containsDirective($field, $value)) {
            $directive = new \webignition\RobotsTxt\Directive\Directive();
            $directive->setField($field);
            $directive->setValue($value);            
            
            $this->directives[] = $directive;
        }
    }
    
    public function removeDirective($field, $value) {
        $directivePosition = null;
        foreach ($this->directives as $directiveIndex => $existingDirective) {            
            
            
//            if ($userAgent == (string)$existingDirective->getValue()) {
//                $directivePosition = $directiveIndex;
//            }
        }
        
//        if (!is_null($directivePosition)) {
//            unset($this->directives[$directivePosition]);
//        }        
    }
    
    
    
    /**
     *
     * @param string $field
     * @param string $value
     * @return boolean 
     */
    public function containsDirective($field, $value) {
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->setField($field);
        $directive->setValue($value);        
        
        foreach ($this->directives as $existingDirective) {
            if ((string)$existingDirective->getField() == (string)$directive->getField() && (string)$existingValue->getValue() == (string)$directive->getValue()) {
                return true;
            }
        }
        
        return false;
    }
    
}
