<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Directive;

class UserAgentDirective extends Directive
{
    public const USER_AGENT_FIELD_VALUE = 'user-agent';
    public const DEFAULT_USER_AGENT = '*';

    public function __construct(string $userAgentIdentifier)
    {
        parent::__construct(self::USER_AGENT_FIELD_VALUE, mb_strtolower($userAgentIdentifier));
    }

    public function getField(): string
    {
        return strtolower(parent::getField());
    }

    public function getValue(): Value
    {
        $value = parent::getValue();

        return (string) $value === ''
            ? new Value(self::DEFAULT_USER_AGENT)
            : $value;
    }
}
