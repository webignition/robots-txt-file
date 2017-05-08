<?php
namespace webignition\RobotsTxt\DirectiveList;

use webignition\RobotsTxt\Directive\DirectiveInterface;
use webignition\RobotsTxt\Directive\UserAgentDirective;

class UserAgentDirectiveList extends DirectiveList
{
    /**
     * @param DirectiveInterface $directive
     */
    public function add(DirectiveInterface $directive)
    {
        if ($directive instanceof UserAgentDirective) {
            parent::add($directive);
        }
    }

    /**
     * @param DirectiveInterface $directive
     */
    public function remove(DirectiveInterface $directive)
    {
        if ($directive instanceof UserAgentDirective) {
            parent::remove($directive);
        }
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

        if (empty($userAgents)) {
            $userAgents[] = new UserAgentDirective(UserAgentDirective::DEFAULT_USER_AGENT);
        }

        return $userAgents;
    }

    /**
     * @param DirectiveInterface $directive
     *
     * @return bool
     */
    public function contains(DirectiveInterface $directive)
    {
        if ($directive instanceof UserAgentDirective) {
            return parent::contains($directive);
        }

        return false;
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
}
