<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\DirectiveList;

use webignition\RobotsTxt\Directive\DirectiveInterface;

class DirectiveList
{
    /**
     * @var DirectiveInterface[]
     */
    private $directives = [];

    public function add(DirectiveInterface $directive): void
    {
        if (!$this->contains($directive)) {
            $this->directives[] = $directive;
        }
    }

    public function remove(DirectiveInterface $directive): void
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
     * @return string[]
     */
    public function getValues(): array
    {
        $directives = array();
        foreach ($this->directives as $directive) {
            $directives[] = (string)$directive;
        }

        return $directives;
    }

    /**
     * @return DirectiveInterface[]
     */
    public function getDirectives(): array
    {
        return $this->directives;
    }

    public function first(): ?DirectiveInterface
    {
        return $this->directives[0] ?? null;
    }

    public function contains(DirectiveInterface $directive): bool
    {
        foreach ($this->directives as $existingDirective) {
            if ($directive->equals($existingDirective)) {
                return true;
            }
        }

        return false;
    }

    public function containsField(string $fieldName): bool
    {
        $fieldName = strtolower(trim($fieldName));

        foreach ($this->directives as $directive) {
            if ($directive->getField() == $fieldName) {
                return true;
            }
        }

        return false;
    }

    public function __toString(): string
    {
        $string = '';
        $directives = $this->getDirectives();

        foreach ($directives as $directive) {
            $string .= $directive . "\n";
        }

        return trim($string);
    }

    public function getByField(string $field): DirectiveList
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

    public function getLength(): int
    {
        return count($this->directives);
    }

    public function isEmpty(): bool
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
