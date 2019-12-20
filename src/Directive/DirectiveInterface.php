<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Directive;

interface DirectiveInterface
{
    const FIELD_VALUE_SEPARATOR = ':';

    const TYPE_UNKNOWN = 'unknown';
    const TYPE_USER_AGENT = 'user-agent';
    const TYPE_DISALLOW = 'disallow';
    const TYPE_ALLOW = 'allow';
    const TYPE_SITEMAP = 'sitemap';

    public function getField(): string;
    public function getValue(): Value;
    public function isType(string $type): bool;
    public function equals(DirectiveInterface $comparator): bool;
    public function __toString(): string;
}
