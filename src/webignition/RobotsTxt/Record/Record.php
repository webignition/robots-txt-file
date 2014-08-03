<?php
namespace webignition\RobotsTxt\Record;

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
     *
     * @var \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList
     */
    private $userAgentDirectiveList = null;

    /**
     *
     * @var \webignition\RobotsTxt\DirectiveList\DirectiveList
     */
    private $directiveList = null;

    /**
     *
     * @return \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList
     */
    public function userAgentDirectiveList()
    {
        if (is_null($this->userAgentDirectiveList)) {
            $this->userAgentDirectiveList = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList();
        }

        return $this->userAgentDirectiveList;
    }

    /**
     *
     * @return \webignition\RobotsTxt\DirectiveList\DirectiveList
     */
    public function directiveList()
    {
        if (is_null($this->directiveList)) {
            $this->directiveList = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
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
