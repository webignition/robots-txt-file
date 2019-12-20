<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Inspector;

use webignition\RobotsTxt\Directive\DirectiveInterface;
use webignition\RobotsTxt\Directive\UserAgentDirective;
use webignition\RobotsTxt\DirectiveList\DirectiveList;
use webignition\RobotsTxt\File\File;

/**
 * Inspects (examines) a File
 */
class Inspector
{
    /**
     * @var File
     */
    private $file;

    /**
     * @var string
     */
    private $userAgent;

    public function __construct(File $file, string $userAgent = '*')
    {
        $this->file = $file;
        $this->setUserAgent($userAgent);
    }

    public function setUserAgent(string $userAgent = '*'): void
    {
        $this->userAgent = trim(mb_strtolower($userAgent));
    }

    public function getDirectives(): DirectiveList
    {
        $isDefaultUserAgent = $this->userAgent === UserAgentDirective::DEFAULT_USER_AGENT;
        $defaultUserAgentDirectives = $this->getDirectivesForDefaultUserAgent();

        if ($isDefaultUserAgent) {
            return $defaultUserAgentDirectives;
        }

        $records = $this->file->getRecords();
        $matchedDirectiveLists = [];

        foreach ($records as $record) {
            $userAgentDirectiveListMatch = $record->getUserAgentDirectiveList()->match($this->userAgent);

            if (!is_null($userAgentDirectiveListMatch)) {
                $matchedDirectiveLists[$userAgentDirectiveListMatch] = $record->getDirectiveList();
            }
        }

        $matchCount = count($matchedDirectiveLists);

        if ($matchCount === 0) {
            return $defaultUserAgentDirectives;
        }

        if ($matchCount === 1) {
            $directiveList = reset($matchedDirectiveLists);

            return $directiveList instanceof DirectiveList ? $directiveList : new DirectiveList();
        }

        return $matchedDirectiveLists[
            $this->findBestUserAgentStringToUserAgentIdentifierMatch(array_keys($matchedDirectiveLists))
        ];
    }

    /**
     * A urlPath is allowed if either:
     * - there are no matching disallow directives
     * - the longest matching allow path is greater in length than the longest matching disallow path
     *
     * Note: Google webmaster docs state that the allow/disallow precedence for paths containing wildcards
     *       is undefined.
     *       Many robots txt checking tools appear to use the 'longest rule wins' option regardless of
     *       wildcards. It is this approach that is taken here.
     *
     * @param string $urlPath
     *
     * @return bool
     */
    public function isAllowed(string $urlPath): bool
    {
        $matchingDisallowDirectives = $this->getMatchingAllowDisallowDirectivePaths(
            $urlPath,
            DirectiveInterface::TYPE_DISALLOW
        );

        $matchingAllowDirectives = $this->getMatchingAllowDisallowDirectivePaths(
            $urlPath,
            DirectiveInterface::TYPE_ALLOW
        );

        if (empty($matchingDisallowDirectives)) {
            return true;
        }

        if (empty($matchingAllowDirectives)) {
            return false;
        }

        $longestDisallowPath = $this->getLongestPath($matchingDisallowDirectives);
        $longestAllowPath = $this->getLongestPath($matchingAllowDirectives);

        if ($longestAllowPath === $longestDisallowPath) {
            return true;
        }

        $disallowPathLength = strlen($longestDisallowPath);
        $allowPathLength = strlen($longestAllowPath);

        if ($disallowPathLength === $allowPathLength) {
            return false;
        }

        return $allowPathLength > $disallowPathLength;
    }

    /**
     * @param string[] $paths
     *
     * @return string
     */
    private function getLongestPath(array $paths): string
    {
        return array_reduce($paths, function (?string $a, string $b) {
            return strlen((string) $a) > strlen((string) $b) ? $a : $b;
        });
    }

    /**
     * @param string $urlPath
     * @param string $type
     *
     * @return string[]
     */
    private function getMatchingAllowDisallowDirectivePaths(string $urlPath, string $type): array
    {
        $matchingDirectives = [];
        $directives = $this->getDirectives();
        $disallowDirectives = $directives->getByField($type);

        if ($disallowDirectives->isEmpty()) {
            return $matchingDirectives;
        }

        $matcher = new UrlMatcher();

        foreach ($disallowDirectives->getDirectives() as $disallowDirective) {
            if ($matcher->matches($disallowDirective, $urlPath)) {
                $matchingDirectives[] = (string)$disallowDirective->getValue();
            }
        }

        return $matchingDirectives;
    }

    private function getDirectivesForDefaultUserAgent(): DirectiveList
    {
        $defaultUserAgentDirective = new UserAgentDirective(UserAgentDirective::DEFAULT_USER_AGENT);

        foreach ($this->file->getRecords() as $record) {
            if ($record->getUserAgentDirectiveList()->contains($defaultUserAgentDirective)) {
                return $record->getDirectiveList();
            }
        }

        return new DirectiveList();
    }

    /**
     * @param string[] $userAgentIdentifiers
     *
     * @return string
     */
    private function findBestUserAgentStringToUserAgentIdentifierMatch(array $userAgentIdentifiers): string
    {
        $scores = array();
        $longestUserAgentIdentifier = '';
        $highestScore = 0;
        $highestScoringUserAgentIdentifier = '';

        foreach ($userAgentIdentifiers as $userAgentIdentifier) {
            $scores[$userAgentIdentifier] = 0;

            if ($this->userAgent === $userAgentIdentifier) {
                $scores[$userAgentIdentifier]++;
            }

            if (mb_strlen($userAgentIdentifier) > mb_strlen($longestUserAgentIdentifier)) {
                $longestUserAgentIdentifier = $userAgentIdentifier;
            }
        }

        $scores[$longestUserAgentIdentifier]++;

        foreach ($scores as $userAgentIdentifier => $score) {
            if ($score > $highestScore) {
                $highestScore = $score;
                $highestScoringUserAgentIdentifier = $userAgentIdentifier;
            }
        }

        return $highestScoringUserAgentIdentifier;
    }
}
