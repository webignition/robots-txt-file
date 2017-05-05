<?php
namespace webignition\RobotsTxt\UserAgentDirective;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\DirectiveList\DirectiveList;
use webignition\RobotsTxt\UserAgentDirective\UserAgentDirective;

class UserAgentDirectiveList extends DirectiveList
{
    /**
     *
     * @param string $userAgentString
     */
    public function add($userAgentString)
    {
        parent::add('user-agent:'.strtolower($userAgentString));
    }

    /**
     *
     * @param string $userAgentString
     */
    public function remove($userAgentString)
    {
        parent::remove('user-agent:'.strtolower($userAgentString));
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
            $defaultUserAgentDirective->parse('user-agent:*');

            $userAgents[] = $defaultUserAgentDirective;
        }

        return $userAgents;
    }

    /**
     *
     * @param string $userAgentString
     *
     * @return boolean
     */
    public function contains($userAgentString)
    {
        return parent::contains('user-agent:'.$userAgentString);
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
