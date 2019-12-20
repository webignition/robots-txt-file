<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Inspector;

use webignition\RobotsTxt\Directive\DirectiveInterface;

/**
 * Checks if a given url pattern matches a directive value
 *
 * Implements rules defined at:
 * - http://www.robotstxt.org/norobots-rfc.txt
 * - https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt#url-matching-based-on-path-values
 */
class UrlMatcher
{
    public const ANY_CHARACTER_WILDCARD = '*';
    public const MUST_END_WITH_WILDCARD = '$';
    public const URL_ENCODED_SLASH = '%2f';

    public function matches(DirectiveInterface $directive, string $urlPath): bool
    {
        $decodedDirectivePath = $this->decodeUrlPath((string)$directive->getValue());

        if (empty($decodedDirectivePath)) {
            return false;
        }
        $decodedRelativeUrl = $this->decodeUrlPath($urlPath);

        return preg_match($this->createRegex($decodedDirectivePath), $decodedRelativeUrl) > 0;
    }

    /**
     * Decode a URL path without decoding encoded forward slashes
     *
     * @param string $urlPath
     *
     * @return string
     */
    private function decodeUrlPath(string $urlPath): string
    {
        $urlPath = str_replace(strtoupper(self::URL_ENCODED_SLASH), self::URL_ENCODED_SLASH, $urlPath);
        $urlPathParts = explode(self::URL_ENCODED_SLASH, $urlPath);

        array_walk($urlPathParts, function (&$urlPathPart) {
            $urlPathPart = rawurldecode($urlPathPart);
        });

        return implode(self::URL_ENCODED_SLASH, $urlPathParts);
    }

    /**
     * Transform a directive URL path into an equivalent regex
     *
     * @param string $directiveUrlPath
     *
     * @return string
     */
    private function createRegex(string $directiveUrlPath): string
    {
        $hasMustEndWithWildcard = substr($directiveUrlPath, -1) === self::MUST_END_WITH_WILDCARD;
        if ($hasMustEndWithWildcard) {
            $directiveUrlPath = rtrim($directiveUrlPath, self::MUST_END_WITH_WILDCARD);
        }

        $directiveUrlPath = rtrim($directiveUrlPath, self::ANY_CHARACTER_WILDCARD);
        $directiveValueParts = explode(self::ANY_CHARACTER_WILDCARD, $directiveUrlPath);

        array_walk($directiveValueParts, function (&$directiveValue) {
            $directiveValue = preg_quote($directiveValue, '/');
        });

        return '/^' . implode(".*", $directiveValueParts) . ($hasMustEndWithWildcard ? '$' : '') . '/';
    }
}
