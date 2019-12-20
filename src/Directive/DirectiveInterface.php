<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Directive;

interface DirectiveInterface
{
    public const FIELD_VALUE_SEPARATOR = ':';
    public const TYPE_USER_AGENT = 'user-agent';
    public const TYPE_DISALLOW = 'disallow';
    public const TYPE_ALLOW = 'allow';
    public const TYPE_SITEMAP = 'sitemap';

    public function getField(): string;
    public function getValue(): Value;
    public function isType(string $type): bool;
    public function equals(DirectiveInterface $comparator): bool;
    public function __toString(): string;
}
