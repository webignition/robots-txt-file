<?php
namespace webignition\RobotsTxt\Directive;

class Directive implements DirectiveInterface
{
    /**
     * @var string
     */
    private $field = null;

    /**
     * String containing "<any CHAR except CR or LF or "#">"
     *
     * @var Value
     */
    private $value = null;

    /**
     * @param string $field
     * @param string $value
     */
    public function __construct($field = '', $value = '')
    {
        $this->field = mb_strtolower($field);
        $this->value = new Value($value);
    }

    /**
     * @inheritdoc
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getField() . self::FIELD_VALUE_SEPARATOR . $this->getValue();
    }

    /**
     * @inheritdoc
     */
    public function equals(DirectiveInterface $comparator)
    {
        if ($this->getField() != $comparator->getField()) {
            return false;
        }

        if (!$this->getValue()->equals($comparator->getValue())) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function isType($type)
    {
        return strtolower($this->getField()) == strtolower($type);
    }
}
