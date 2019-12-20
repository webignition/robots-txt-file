<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Directive;

/**
 * Create a type-specific directive from a directive string
 */
class Factory
{
    public const FIELD_USER_AGENT = 'user-agent';

    public static function create(string $directiveString): ?DirectiveInterface
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
