<?php
namespace webignition\RobotsTxt\Directive;

/**
 * Validate a directive string
 */
class Validator
{
    /**
     * @param string $directiveString
     *
     * @return bool
     */
    public static function isDirectiveStringValid($directiveString)
    {
        $directiveString = trim($directiveString);

        if ($directiveString === '') {
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

    /**
     * @param string $directiveString
     *
     * @return bool
     */
    private static function doesDirectiveStringContainFieldValueSeparator($directiveString)
    {
        return substr_count($directiveString, Directive::FIELD_VALUE_SEPARATOR) > 0;
    }

    /**
     * @param string $directiveString
     *
     * @return bool
     */
    private static function doesDirectiveStringContainSeparatorBetweenFieldAndValue($directiveString)
    {
        return substr($directiveString, 0, 1) != Directive::FIELD_VALUE_SEPARATOR;
    }
}
