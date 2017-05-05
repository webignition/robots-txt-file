<?php
namespace webignition\RobotsTxt\UserAgentDirective;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\DirectiveList\DirectiveList;

class UserAgentDirectiveList extends DirectiveList
{
    /**
     *
     * @param string $userAgentIdentifier
     */
    public function add($userAgentIdentifier)
    {
        parent::add(
            UserAgentDirective::USER_AGENT_FIELD_VALUE .
            Directive::FIELD_VALUE_SEPARATOR .
            strtolower($userAgentIdentifier)
        );
    }

    /**
     *
     * @param string $userAgentIdentifier
     */
    public function remove($userAgentIdentifier)
    {
        parent::remove(
            UserAgentDirective::USER_AGENT_FIELD_VALUE .
            Directive::FIELD_VALUE_SEPARATOR .
            strtolower($userAgentIdentifier)
        );
    }

    /**
     *
     * @return string[]
     */
    public function getValues()
    {
        $userAgents = array();
        $userAgentDirectives = $this->get();

        foreach ($userAgentDirectives as $userAgent) {
            $userAgents[] = (string)$userAgent->getValue();
        }

        return $userAgents;
    }

    /**
     *
     * @return UserAgentDirective[]
     */
    public function get()
    {
        $userAgents = parent::get();

        if (count($userAgents) === 0) {
            $defaultUserAgentDirective = new UserAgentDirective();
            $defaultUserAgentDirective->parse(
                UserAgentDirective::USER_AGENT_FIELD_VALUE .
                Directive::FIELD_VALUE_SEPARATOR .
                '*'
            );

            $userAgents[] = $defaultUserAgentDirective;
        }

        return $userAgents;
    }

    /**
     *
     * @param string $userAgentIdentifier
     *
     * @return boolean
     */
    public function contains($userAgentIdentifier)
    {
        return parent::contains(
            UserAgentDirective::USER_AGENT_FIELD_VALUE .
            Directive::FIELD_VALUE_SEPARATOR .
            strtolower($userAgentIdentifier)
        );
    }

    /**
     * @param string $userAgentString
     *
     * @return bool
     */
    public function match($userAgentString)
    {
        foreach ($this->getValues() as $userAgentIdentifier) {
            if ($userAgentIdentifier === UserAgentDirective::DEFAULT_USER_AGENT) {
                continue;
            }

            if (substr_count($userAgentString, $userAgentIdentifier)) {
                return $userAgentIdentifier;
            }
        }

        return null;
    }

    /**
     *
     * @param string $directiveString
     *
     * @return Directive
     */
    protected function createNewDirective($directiveString)
    {
        $directive = new UserAgentDirective();
        $directive->parse($directiveString);

        return $directive;
    }
}
