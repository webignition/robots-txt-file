<?php
namespace webignition\RobotsTxt\DirectiveList;

/**
 * Filter a directive list given a set of filtering options
 */
class Filter
{
    /**
     * Directive list to be filtered
     *
     * @var DirectiveList
     */
    private $sourceDirectiveList = null;

    /**
     *
     * @param DirectiveList $sourceDirectiveList
     */
    public function __construct(DirectiveList $sourceDirectiveList)
    {
        $this->setSourceDirectiveList($sourceDirectiveList);
    }

    /**
     *
     * @param DirectiveList $directiveList
     */
    public function setSourceDirectiveList(DirectiveList $directiveList)
    {
        $this->sourceDirectiveList = $directiveList;
    }

    /**
     *
     * @param array $options
     *
     * @return DirectiveList
     */
    public function getDirectiveList($options = array())
    {
        $directives = $this->sourceDirectiveList->get();

        if (isset($options['field'])) {
            foreach ($directives as $directiveIndex => $directive) {
                if (!$directive->isType($options['field'])) {
                    unset($directives[$directiveIndex]);
                }
            }
        }

        if (isset($options['value'])) {
            foreach ($directives as $directiveIndex => $directive) {
                if ((string)$directive->getValue() != $options['value']) {
                    unset($directives[$directiveIndex]);
                }
            }
        }

        $directiveList = new DirectiveList();
        foreach ($directives as $directive) {
            $directiveList->add($directive);
        }

        return $directiveList;
    }
}
