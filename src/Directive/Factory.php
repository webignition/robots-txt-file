<?php
namespace webignition\RobotsTxt\Directive;

/**
 * Create a type-specific directive from a directive string
 */
class Factory
{
    const FIELD_DISALLOW = 'disallow';
    const FIELD_USER_AGENT = 'user-agent';

    public static function create($directiveString)
    {
        if (!Validator::isDirectiveStringValid($directiveString)) {
            return null;
        }

        $directiveString = trim($directiveString);

        list($field, $value) = explode(':', $directiveString, 2);
        $lowercaseField = mb_strtolower($field);

        switch ($lowercaseField) {
            case self::FIELD_USER_AGENT:
                return new UserAgentDirective($value);
        }

        return new Directive($field, $value);
    }
}
