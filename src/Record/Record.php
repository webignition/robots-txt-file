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
    public function userAgentDirectiveList()
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
    public function directiveList()
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

        $directives = array_merge($this->userAgentDirectiveList()->get(), $this->directiveList()->get());

        foreach ($directives as $directive) {
            $stringRepresentation .= $directive . "\n";
        }

        return trim($stringRepresentation);
    }
}
