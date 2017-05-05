<?php
namespace webignition\RobotsTxt\DirectiveList;

use webignition\RobotsTxt\Directive\Directive;

class DirectiveList
{
    /**
     * @var Directive[]
     */
    private $directives = array();

    /**
     *
     * @param string $directiveString
     */
    public function add($directiveString)
    {
        if (!$this->contains($directiveString)) {
            $this->directives[] = $this->createNewDirective($directiveString);
        }
    }

    /**
     *
     * @param string $directiveString
     */
    public function remove($directiveString)
    {
        $directive = $this->createNewDirective($directiveString);

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
     * @return string[]
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
     * @return Directive[]
     */
    public function get()
    {
        return $this->directives;
    }

    /**
     *
     * @return Directive
     */
    public function first()
    {
        $directives = $this->get();

        return $directives[0];
    }

    /**
     *
     * @param string $directiveString
     *
     * @return boolean
     */
    public function contains($directiveString)
    {
        $directive = $this->createNewDirective($directiveString);

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
     *
     * @return boolean
     */
    public function containsField($fieldName)
    {
        $fieldName = strtolower(trim($fieldName));

        foreach ($this->directives as $directive) {
            if ($directive->getField() == $fieldName) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * @param string $directiveString
     *
     * @return Directive
     */
    protected function createNewDirective($directiveString)
    {
        $directive = new Directive();
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
     *
     * @return DirectiveList
     */
    public function filter($options)
    {
        $filter = new Filter($this);

        return $filter->getDirectiveList($options);
    }
}
