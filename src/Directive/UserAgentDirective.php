<?php
namespace webignition\RobotsTxt\Directive;

class UserAgentDirective extends Directive
{
    const USER_AGENT_FIELD_VALUE = 'user-agent';
    const DEFAULT_USER_AGENT = '*';

    /**
     * @param string $userAgentIdentifier
     */
    public function __construct($userAgentIdentifier)
    {
        parent::__construct(self::USER_AGENT_FIELD_VALUE, mb_strtolower($userAgentIdentifier));
    }

    /**
     *
     * @return string
     */
    public function getField()
    {
        return strtolower(parent::getField());
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return parent::getValue() == '' ? self::DEFAULT_USER_AGENT : parent::getValue();
    }
}
