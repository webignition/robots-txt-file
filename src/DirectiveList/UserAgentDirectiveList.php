<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\DirectiveList;

use webignition\RobotsTxt\Directive\DirectiveInterface;
use webignition\RobotsTxt\Directive\UserAgentDirective;

class UserAgentDirectiveList extends DirectiveList
{
    public function add(DirectiveInterface $directive): void
    {
        if ($directive instanceof UserAgentDirective) {
            parent::add($directive);
        }
    }

    public function remove(DirectiveInterface $directive): void
    {
        if ($directive instanceof UserAgentDirective) {
            parent::remove($directive);
        }
    }

    /**
     * @return string[]
     */
    public function getValues(): array
    {
        $userAgents = array();
        $userAgentDirectives = $this->getDirectives();

        foreach ($userAgentDirectives as $userAgent) {
            $userAgents[] = (string)$userAgent->getValue();
        }

        return $userAgents;
    }

    /**
     * @return DirectiveInterface[]|UserAgentDirective[]
     */
    public function getDirectives(): array
    {
        $userAgents = parent::getDirectives();

        if (empty($userAgents)) {
            $userAgents[] = new UserAgentDirective(UserAgentDirective::DEFAULT_USER_AGENT);
        }

        return $userAgents;
    }

    public function contains(DirectiveInterface $directive): bool
    {
        if ($directive instanceof UserAgentDirective) {
            return parent::contains($directive);
        }

        return false;
    }

    public function match(string $userAgentString): ?string
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
