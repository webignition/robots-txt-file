<?php
namespace webignition\RobotsTxt\Directive;

/**
 * The Value in a robots txt directive line of the format
 * Field:Value
 *  
 */
class Value extends \webignition\DisallowedCharacterTerminatedString\DisallowedCharacterTerminatedString {
    
    public function __construct($value = null) {
        $this->addDisallowedCharacterCode(10);
        $this->addDisallowedCharacterCode(13);
        $this->addDisallowedCharacterCode(ord('#'));
        $this->set((is_null($value)) ? '' : $value);        
    }
    
    public function set($value) {
        parent::set($value);
        parent::set(trim(parent::get()));
    }
}
