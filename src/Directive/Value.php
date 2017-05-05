<?php
namespace webignition\RobotsTxt\Directive;

use webignition\DisallowedCharacterTerminatedString\DisallowedCharacterTerminatedString;

/**
 * The Value in a robots txt directive line of the format
 * Field:Value
 */
class Value extends DisallowedCharacterTerminatedString
{
    /**
     * @param string|null $value
     */
    public function __construct($value = null)
    {
        $this->addDisallowedCharacterCode(10);
        $this->addDisallowedCharacterCode(13);
        $this->addDisallowedCharacterCode(ord('#'));
        $this->set((is_null($value)) ? '' : $value);
    }

    /**
     * @param string $value
     */
    public function set($value)
    {
        parent::set($value);
        parent::set(trim(parent::get()));
    }
}
