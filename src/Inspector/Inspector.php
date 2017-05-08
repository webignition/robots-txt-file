<?php
namespace webignition\RobotsTxt\Inspector;

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

    /**
     * @param File $file
     * @param string $userAgent
     */
    public function __construct(File $file, $userAgent = '*')
    {
        $this->file = $file;
        $this->setUserAgent($userAgent);
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent = '*')
    {
        $this->userAgent = trim(mb_strtolower($userAgent));
    }

    /**
     * @return DirectiveList
     */
    public function getDirectives()
    {
        $isDefaultUserAgent = $this->userAgent === UserAgentDirective::DEFAULT_USER_AGENT;
        $defaultUserAgentDirectives = $this->getDirectivesForDefaultUserAgent();

        if ($isDefaultUserAgent) {
            return $defaultUserAgentDirectives;
        }

        $records = $this->file->getRecords();
        $matchedDirectiveLists = [];

        foreach ($records as $record) {
            $userAgentDirectiveListMatch = $record->userAgentDirectiveList()->match($this->userAgent);

            if (!is_null($userAgentDirectiveListMatch)) {
                $matchedDirectiveLists[$userAgentDirectiveListMatch] = $record->directiveList();
            }
        }

        $matchCount = count($matchedDirectiveLists);

        if ($matchCount === 0) {
            return $defaultUserAgentDirectives;
        }

        if ($matchCount === 1) {
            return reset($matchedDirectiveLists);
        }

        return $matchedDirectiveLists[
            $this->findBestUserAgentStringToUserAgentIdentifierMatch(array_keys($matchedDirectiveLists))
        ];
    }

    /**
     * @param string $relativeUrlPatternString
     *
     * @return bool
     */
    public function isAllowed($relativeUrlPatternString)
    {
        /**
         * <star> and $ are special
         * <star> is a wildcard - Disallow: /private<star>
         * $ matches something ending in - Disallow: /<star>.asp$
         */
        $directives = $this->getDirectives();

        return true;
    }

    /**
     * @return DirectiveList|null
     */
    private function getDirectivesForDefaultUserAgent()
    {
        $defaultUserAgentDirective = new UserAgentDirective(UserAgentDirective::DEFAULT_USER_AGENT);

        foreach ($this->file->getRecords() as $record) {
            if ($record->userAgentDirectiveList()->contains($defaultUserAgentDirective)) {
                return $record->directiveList();
            }
        }

        return new DirectiveList();
    }

    /**
     * @param string[] $userAgentIdentifiers
     *
     * @return string
     */
    private function findBestUserAgentStringToUserAgentIdentifierMatch($userAgentIdentifiers)
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
