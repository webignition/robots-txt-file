<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Record;

use webignition\RobotsTxt\DirectiveList\DirectiveList;
use webignition\RobotsTxt\DirectiveList\UserAgentDirectiveList;

/**
 * From http://www.robotstxt.org/norobots-rfc.txt:
 *
 *   The record starts with one or more User-agent lines, specifying
 *   which robots the record applies to, followed by [directives]
 *
 */
class Record
{
    /**
     * @var UserAgentDirectiveList|null
     */
    private $userAgentDirectiveList = null;

    /**
     *
     * @var DirectiveList|null
     */
    private $directiveList = null;

    public function getUserAgentDirectiveList(): UserAgentDirectiveList
    {
        if (is_null($this->userAgentDirectiveList)) {
            $this->userAgentDirectiveList = new UserAgentDirectiveList();
        }

        return $this->userAgentDirectiveList;
    }

    public function getDirectiveList(): DirectiveList
    {
        if (is_null($this->directiveList)) {
            $this->directiveList = new DirectiveList();
        }

        return $this->directiveList;
    }

    public function __toString(): string
    {
        $stringRepresentation = '';

        $directives = array_merge(
            $this->getUserAgentDirectiveList()->getDirectives(),
            $this->getDirectiveList()->getDirectives()
        );

        foreach ($directives as $directive) {
            $stringRepresentation .= $directive . "\n";
        }

        return trim($stringRepresentation);
    }
}
