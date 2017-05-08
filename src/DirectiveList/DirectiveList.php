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
    public function get()
    {
        return $this->directives;
    }

    /**
     *
     * @return DirectiveInterface
     */
    public function first()
    {
        $directives = $this->get();

        return $directives[0];
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

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->directives);
    }
}
