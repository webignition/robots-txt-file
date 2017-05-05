<?php
namespace webignition\RobotsTxt\Directive;

class Directive
{
    const FIELD_VALUE_SEPARATOR = ':';

    /**
     *
     * @var Field
     */
    private $field = null;

    /**
     * String containing "<any CHAR except CR or LF or "#">"
     *
     * @var Value
     */
    private $value = null;

    /**
     *
     * @return string
     */
    public function getField()
    {
        return $this->field === null ? '' : (string)$this->field;
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value === null ? '' : $this->value;
    }

    /**
     *
     * @param string $directiveString
     */
    public function parse($directiveString)
    {
        $directiveString = trim($directiveString);

        $field = new Field($directiveString);
        $this->field = $field;
        $fieldString = (string)$field;

        if ($directiveString !== $fieldString) {
            $this->value = new Value(substr($directiveString, strlen($fieldString) + 1));
        }
    }

    /**
     *
     * @return boolean
     */
    public function isValid()
    {
        return !is_null($this->value);
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getField() . self::FIELD_VALUE_SEPARATOR . $this->getValue();
    }

    /**
     *
     * @param Directive $directive
     *
     * @return boolean
     */
    public function equals(Directive $directive)
    {
        if ((string)$this->getField() != (string)$directive->getField()) {
            return false;
        }

        if ((string)$this->getValue() != (string)$directive->getValue()) {
            return false;
        }

        return true;
    }

    /**
     *
     * @param string $value
     *
     * @return boolean
     */
    public function is($value)
    {
        return $this->getField() == trim(strtolower($value));
    }
}
