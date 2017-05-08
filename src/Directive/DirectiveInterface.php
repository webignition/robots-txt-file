<?php
namespace webignition\RobotsTxt\Directive;

interface DirectiveInterface
{
    const FIELD_VALUE_SEPARATOR = ':';

    const TYPE_UNKNOWN = 'unknown';
    const TYPE_USER_AGENT = 'user-agent';
    const TYPE_DISALLOW = 'disallow';
    const TYPE_ALLOW = 'allow';
    const TYPE_SITEMAP = 'sitemap';

    /**
     *
     * @return string
     */
    public function getField();

    /**
     *
     * @return Value
     */
    public function getValue();

    /**
     *
     * @return string
     */
    public function __toString();

    /**
     *
     * @param DirectiveInterface $comparator
     *
     * @return boolean
     */
    public function equals(DirectiveInterface $comparator);

    /**
     *
     * @param string $type
     *
     * @return boolean
     */
    public function isType($type);
}
