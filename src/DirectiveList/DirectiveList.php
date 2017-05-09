<?php
namespace webignition\RobotsTxt\DirectiveList;

use webignition\RobotsTxt\Directive\DirectiveInterface;

class DirectiveList
{
    /**
     * @var DirectiveInterface[]
     */
    private $directives = array();

    /**
     * @param DirectiveInterface $directive
     */
    public function add(DirectiveInterface $directive)
    {
        if (!$this->contains($directive)) {
            $this->directives[] = $directive;
        }
    }

    /**
     * @param DirectiveInterface $directive
     */
    public function remove(DirectiveInterface $directive)
    {
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
     * @return DirectiveInterface[]
     */
    public function getDirectives()
    {
        return $this->directives;
    }

    /**
     *
     * @return DirectiveInterface
     */
    public function first()
    {
        return $this->directives[0];
    }

    /**
     * @param DirectiveInterface $directive
     *
     * @return bool
     */
    public function contains(DirectiveInterface $directive)
    {
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
     * @return string
     */
    public function __toString()
    {
        $string = '';
        $directives = $this->getDirectives();

        foreach ($directives as $directive) {
            $string .= $directive . "\n";
        }

        return trim($string);
    }

    /**
     *
     * @param string $field
     *
     * @return DirectiveList
     */
    public function getByField($field)
    {
        $directives = $this->getDirectives();

        foreach ($directives as $directiveIndex => $directive) {
            if (!$directive->isType($field)) {
                unset($directives[$directiveIndex]);
            }
        }

        $directiveList = new DirectiveList();
        foreach ($directives as $directive) {
            $directiveList->add($directive);
        }

        return $directiveList;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->directives);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        $isEmpty = true;

        foreach ($this->getDirectives() as $directive) {
            if (!$isEmpty) {
                continue;
            }

            if (!empty((string)$directive->getValue())) {
                $isEmpty = false;
            }
        }

        return $isEmpty;
    }
}
