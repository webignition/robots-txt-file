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
     * Allow, Disallow or any extension such as crawl-delay or sitemap
     * 
     * @param string $field 
     */
    public function setField($field) {        
        $this->field = new \webignition\RobotsTxt\Directive\Field($field);
    }
    
    /**
     *
     * @return string
     */
    public function getField() {
        return $this->field === null ? '' : (string)$this->field;
    }
    
    
    /**
     * Set directive value, stopping when encountering a new line or the start
     * of a comment
     * 
     * @param string $value 
     */
    public function setValue($value) {
        $this->value = new \webignition\RobotsTxt\Directive\Value($value);
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
     * @return string
     */
    public function __toString() {
        return $this->getField() . self::FIELD_VALUE_SEPARATOR . $this->getValue();
    }
}
