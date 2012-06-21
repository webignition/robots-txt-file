<?php
namespace webignition\RobotsTxt\Directive;

class Directive {
    
    const FIELD_VALUE_SEPARATOR = ':';
    
    /**
     *
     * @var \webignition\RobotsTxt\Directive\Field
     */
    private $field = null;
    
    /**
     * String containing "<any CHAR except CR or LF or "#">"
     * 
     * @var \webignition\RobotsTxt\Directive\NonBreakingNonCommentEntity
     */
    private $value = null;
    
    /**
     *
     * @return string
     */
    public function getField() {
        return $this->field === null ? '' : (string)$this->field;
    }
    
    /**
     *
     * @return string
     */
    public function getValue() {
        return $this->value === null ? '' : $this->value;
    }
    
    /**
     *
     * @param string $directiveString 
     */
    public function parse($directiveString) {
        $field = new \webignition\RobotsTxt\Directive\Field($directiveString);
        $value = new \webignition\RobotsTxt\Directive\Value(substr($directiveString, strlen($field) + 1));
        
        $this->field = $field;
        $this->value = $value;
    }
    
    
    /**
     *
     * @return string
     */
    public function __toString() {
        return $this->getField() . self::FIELD_VALUE_SEPARATOR . $this->getValue();
    }
    
    
    /**
     *
     * @param \webignition\RobotsTxt\Directive\Directive $directive
     * @return boolean 
     */
    public function equals(\webignition\RobotsTxt\Directive\Directive $directive) {        
        if ((string)$this->getField() != (string)$directive->getField()) {
            return false;
        }
        
        if ((string)$this->getValue() != (string)$directive->getValue()) {
            return false;
        }
        
        return true;
    }
}

