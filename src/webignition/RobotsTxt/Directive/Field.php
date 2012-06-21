<?php
namespace webignition\RobotsTxt\Directive;

/**
 * The Field in a robots txt directive line of the format
 * Field:Value
 *  
 */
class Field extends Value {
    
    public function __construct($field = null) {
        parent::__construct();
        $this->addDisallowedCharacterCode(ord(':'));
        $this->set((is_null($field)) ? '' : $field);
    }
    
    public function set($value) {
        parent::set(strtolower($value));
    }
}
