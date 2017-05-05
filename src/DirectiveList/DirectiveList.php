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
     * @param string $directiveIdentifier
     */
    public function add($directiveIdentifier)
    {
        if (!$this->contains($directiveIdentifier)) {
            $this->directives[] = $this->createNewDirective($directiveIdentifier);
        }
    }

    /**
     *
     * @param string $directiveIdentifier
     */
    public function remove($directiveIdentifier)
    {
        $directive = $this->createNewDirective($directiveIdentifier);

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
     * @param string $directiveIdentifier
     *
     * @return boolean
     */
    public function contains($directiveIdentifier)
    {
        $directive = $this->createNewDirective($directiveIdentifier);

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
