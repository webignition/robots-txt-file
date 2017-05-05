<?php
namespace webignition\RobotsTxt\DirectiveList;

class DirectiveList
{
    /**
     * Collection of UserAgentDirective objects
     *
     * @var array
     */
    private $directives = array();

    /**
     *
     * @param string $directiveString
     */
    public function add($directiveString)
    {
        if (!$this->contains($directiveString)) {
            $this->directives[] = $this->getNewDirective($directiveString);
        }
    }

    /**
     *
     * @param string $directiveString
     */
    public function remove($directiveString)
    {
        $directive = $this->getNewDirective($directiveString);

        $directivePosition = null;
        foreach ($this->directives as $userAgentIndex => $existingUserAgent) {
            if ($directive->equals($existingUserAgent)) {
                $directivePosition = $userAgentIndex;
            }
        }

        if (!is_null($directivePosition)) {
            unset($this->directives[$directivePosition]);
        }
    }

    /**
     *
     * @return array
     */
    public function getValues()
    {
        $directives = array();
        foreach ($this->directives as $directive) {
            $directives[] = (string)$directive;
        }

        return $directives;
    }

    /**
     *
     * @return array
     */
    public function get()
    {
        return $this->directives;
    }

    /**
     *
     * @return \webignition\RobotsTxt\Directive\Directive
     */
    public function first()
    {
        $directives = $this->get();
        return $directives[0];
    }

    /**
     *
     * @param string $userAgentString
     * @return boolean
     */
    public function contains($directiveString)
    {
        $directive = $this->getNewDirective($directiveString);

        foreach ($this->directives as $existingDirective) {
            if ($directive->equals($existingDirective)) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * @param string $fieldName
     * @return boolean
     */
    public function containsField($fieldName)
    {
        $fieldName = strtolower(trim($fieldName));

        foreach ($this->directives as $directive) {
            /* @var $directive \webignition\RobotsTxt\Directive\Directive */
            if ($directive->getField() == $fieldName) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * @param string $directiveString
     * @return \webignition\RobotsTxt\Directive\Directive
     */
    protected function getNewDirective($directiveString)
    {
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->parse($directiveString);

        return $directive;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        $string = '';
        $directives = $this->get();

        foreach ($directives as $directive) {
            $string .= $directive . "\n";
        }

        return trim($string);
    }

    /**
     *
     * @param array $options
     * @return \webignition\RobotsTxt\DirectiveList\DirectiveList
     */
    public function filter($options)
    {
        $filter = new \webignition\RobotsTxt\DirectiveList\Filter($this);
        return $filter->getDirectiveList($options);
    }
}
