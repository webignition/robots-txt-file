<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Directive;

/**
 * Validate a directive string
 */
class Validator
{
    public static function isDirectiveStringValid(string $directiveString): bool
    {
        $directiveString = trim($directiveString);

        if ('' === $directiveString) {
            return false;
        }

        if (!self::doesDirectiveStringContainFieldValueSeparator($directiveString)) {
            return false;
        }

        if (!self::doesDirectiveStringContainSeparatorBetweenFieldAndValue($directiveString)) {
            return false;
        }

        return true;
    }

    private static function doesDirectiveStringContainFieldValueSeparator(string $directiveString): bool
    {
        return substr_count($directiveString, Directive::FIELD_VALUE_SEPARATOR) > 0;
    }

    private static function doesDirectiveStringContainSeparatorBetweenFieldAndValue(string $directiveString): bool
    {
        return substr($directiveString, 0, 1) != Directive::FIELD_VALUE_SEPARATOR;
    }
}
