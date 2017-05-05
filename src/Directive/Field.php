<?php
namespace webignition\RobotsTxt\Directive;

/**
 * The Field in a robots txt directive line of the format
 * Field:Value
 *
 */
class Field extends Value
{
    /**
     * @param string|null $field
     */
    public function __construct($field = null)
    {
        $field = (is_null($field)) ? '' : trim($field);

        parent::__construct();
        $this->addDisallowedCharacterCode(ord(':'));
        $this->set($field);
    }

    /**
     * @param string $value
     */
    public function set($value)
    {
        parent::set(strtolower($value));
    }

    /**
     *
     * @param string $value
     *
     * @return string
     */
    public function equals($value)
    {
        return (string)$this->get() == strtolower($value);
    }
}
