<?php

declare(strict_types=1);

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
    public function __construct(string $field = '', string $value = '')
    {
        $this->field = mb_strtolower($field);
        $this->value = new Value($value);
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getField() . self::FIELD_VALUE_SEPARATOR . $this->getValue();
    }

    public function equals(DirectiveInterface $comparator): bool
    {
        if ($this->getField() != $comparator->getField()) {
            return false;
        }

        if (!$this->getValue()->equals($comparator->getValue())) {
            return false;
        }

        return true;
    }

    public function isType(string $type): bool
    {
        return strtolower($this->getField()) == strtolower($type);
    }
}
