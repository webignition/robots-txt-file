<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Directive;

use webignition\DisallowedCharacterTerminatedString\TerminatedString;

/**
 * The Value in a robots txt directive line of the format
 * Field:Value
 */
class Value extends TerminatedString
{
    public function __construct(?string $value)
    {
        $value = trim($value);

        parent::__construct($value, [
            "\n",
            "\r",
            '#',
        ]);
    }

    public function equals(Value $comparator): bool
    {
        return $this->get() === $comparator->get();
    }

    public function get(): string
    {
        return trim(parent::get());
    }

    public function __toString(): string
    {
        return trim(parent::__toString());
    }
}
