<?php
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
     * @var UserAgentDirectiveList
     */
    private $userAgentDirectiveList = null;

    /**
     *
     * @var DirectiveList
     */
    private $directiveList = null;

    /**
     *
     * @return UserAgentDirectiveList
     */
    public function getUserAgentDirectiveList()
    {
        if (is_null($this->userAgentDirectiveList)) {
            $this->userAgentDirectiveList = new UserAgentDirectiveList();
        }

        return $this->userAgentDirectiveList;
    }

    /**
     *
     * @return DirectiveList
     */
    public function getDirectiveList()
    {
        if (is_null($this->directiveList)) {
            $this->directiveList = new DirectiveList();
        }

        return $this->directiveList;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        $stringRepresentation = '';

        $directives = array_merge($this->getUserAgentDirectiveList()->get(), $this->getDirectiveList()->get());

        foreach ($directives as $directive) {
            $stringRepresentation .= $directive . "\n";
        }

        return trim($stringRepresentation);
    }
}
