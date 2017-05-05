<?php
namespace webignition\RobotsTxt\DirectiveList;

/**
 * Filter a directive list given a set of filtering options
 */
class Filter
{
    /**
     * Options by which to filter directives
     *
     * @var array
     */
    private $options = array();

    /**
     * Directive list to be filtered
     *
     * @var \webignition\RobotsTxt\DirectiveList\DirectiveList
     */
    private $sourceDirectiveList = null;

    /**
     *
     * @param \webignition\RobotsTxt\DirectiveList\DirectiveList $sourceDirectiveList
     */
    public function __construct(\webignition\RobotsTxt\DirectiveList\DirectiveList $sourceDirectiveList)
    {
        $this->setSourceDirectiveList($sourceDirectiveList);
    }

    /**
     *
     * @param \webignition\RobotsTxt\DirectiveList\DirectiveList $directiveList
     */
    public function setSourceDirectiveList(\webignition\RobotsTxt\DirectiveList\DirectiveList $directiveList)
    {
        $this->sourceDirectiveList = $directiveList;
    }

    /**
     *
     * @param array $options
     * @return \webignition\RobotsTxt\DirectiveList\DirectiveList
     */
    public function getDirectiveList($options = array())
    {
        $directives = $this->sourceDirectiveList->get();

        if (isset($options['field'])) {
            foreach ($directives as $directiveIndex => $directive) {
                /* @var $directive \webignition\RobotsTxt\Directive\Directive */
                if (!$directive->is($options['field'])) {
                    unset($directives[$directiveIndex]);
                }
            }
        }

        if (isset($options['value'])) {
            foreach ($directives as $directiveIndex => $directive) {
                /* @var $directive \webignition\RobotsTxt\Directive\Directive */
                if ((string)$directive->getValue() != $options['value']) {
                    unset($directives[$directiveIndex]);
                }
            }
        }

        $directiveList = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
        foreach ($directives as $directive) {
            $directiveList->add((string)$directive);
        }

        return $directiveList;
    }
}
