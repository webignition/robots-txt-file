<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\Inspector;

use webignition\RobotsTxt\File\Parser;
use webignition\RobotsTxt\Inspector\Inspector;

class IsAllowedTest extends \PHPUnit\Framework\TestCase
{
    public function testIsAllowedWhenNoDisallowDirectivesArePresent()
    {
        $parser = new Parser();
        $parser->setSource('');

        $file = $parser->getFile();
        $inspector = new Inspector($file);

        $this->assertTrue($inspector->isAllowed('/foo'));
    }

    /**
     * @dataProvider emptyDisallowDirectiveDataProvider
     *
     * @param string[] $emptyDisallowDirectiveStrings
     */
    public function testIsAllowedWhenOnlyEmptyDisallowIsPresent(array $emptyDisallowDirectiveStrings)
    {
        $parser = new Parser();
        $parser->setSource('user-agent: *' . "\n" . implode("\n", $emptyDisallowDirectiveStrings));

        $file = $parser->getFile();
        $inspector = new Inspector($file);

        $this->assertTrue($inspector->isAllowed('/foo'));
    }

    public function emptyDisallowDirectiveDataProvider(): array
    {
        return [
            [
                'emptyDisallowDirectiveStrings' => ['disallow:'],
            ],
            [
                'emptyDisallowDirectiveStrings' => ['disallow:', 'disallow:'],
            ],
            [
                'emptyDisallowDirectiveStrings' => ['disallow:', 'disallow:', 'disallow:'],
            ],
        ];
    }

    /**
     * @dataProvider noMatchesDataProvider
     */
    public function testIsAllowedWithNoMatchingDisallowDirectives(string $directivePath, string $urlPath)
    {
        $parser = new Parser();
        $parser->setSource('user-agent: *' . "\n" . 'disallow: ' . $directivePath);

        $file = $parser->getFile();
        $inspector = new Inspector($file);

        $this->assertTrue($inspector->isAllowed($urlPath));
    }

    /**
     * robots-txt-rfc-draft-* data sets taken from:
     * http://www.robotstxt.org/norobots-rfc.txt
     *
     * Directive path   URL path        Matches
     * /tmp/            /tmp              no
     * /a%2fb.html      /a/b.html         no
     * /a/b.html        /a%2fb.html       no
     *
     * google-webmasters-* data sets taken from:
     * https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt#url-matching-based-on-path-values
     *
     * Directive path   URL path        Matches
     * /fish            /Fish.asp         no
     *                  /catfish          no
     *                  /?id=fish         no
     *
     * /fish*           /Fish.asp         no
     *                  /catfish          no
     *                  /?id=fish         no
     *
     * /fish/           /fish             no
     *                  /fish.html        no
     *                  /Fish/Salmon.asp  no
     *
     *  /*.php          /                 no
     *                  /windows.PHP      no
     *
     * /*.php$          /filename.php?parameters
     *                  /filename.php/
     *                  /filename.php5
     *                  /windows.PHP
     *
     * /fish*.php       /Fish.PHP
     *
     * @return array
     */
    public function noMatchesDataProvider(): array
    {
        return [
            'robots-txt-rfc-draft-1' => [
                'directivePath' => '/tmp/',
                'urlPath' => '/tmp',
            ],
            'robots-txt-rfc-draft-2' => [
                'directivePath' => '/a%2fb.html',
                'urlPath' => '/a/b.html',
            ],
            'robots-txt-rfc-draft-3' => [
                'directivePath' => '/a/b.html',
                'urlPath' => '/a%2fb.html',
            ],
            '/google-webmasters-1' => [
                'directivePath' => '/fish',
                'urlPath' => '/Fish.asp',
            ],
            '/google-webmasters-2' => [
                'directivePath' => '/fish',
                'urlPath' => '/catfish',
            ],
            '/google-webmasters-3' => [
                'directivePath' => '/fish',
                'urlPath' => '/?id=fish',
            ],
            '/google-webmasters-4' => [
                'directivePath' => '/fish*',
                'urlPath' => '/Fish.asp',
            ],
            '/google-webmasters-5' => [
                'directivePath' => '/fish*',
                'urlPath' => '/catfish',
            ],
            '/google-webmasters-6' => [
                'directivePath' => '/fish*',
                'urlPath' => '/?id=fish',
            ],
            '/google-webmasters-8' => [
                'directivePath' => '/fish/',
                'urlPath' => '/fish.html',
            ],
            '/google-webmasters-9' => [
                'directivePath' => '/fish/',
                'urlPath' => '/Fish/Salmon.asp',
            ],
            '/google-webmasters-10' => [
                'directivePath' => '/*.php',
                'urlPath' => '/',
            ],
            '/google-webmasters-11' => [
                'directivePath' => '/*.php',
                'urlPath' => 'windows.PHP',
            ],
            '/google-webmasters-12' => [
                'directivePath' => '/*.php$',
                'urlPath' => '/filename.php?parameters',
            ],
            '/google-webmasters-13' => [
                'directivePath' => '/*.php$',
                'urlPath' => '/filename.php/',
            ],
            '/google-webmasters-14' => [
                'directivePath' => '/*.php$',
                'urlPath' => '/filename.php5',
            ],
            '/google-webmasters-15' => [
                'directivePath' => '/*.php$',
                'urlPath' => '/windows.PHP',
            ],
            '/google-webmasters-16' => [
                'directivePath' => '/fish*.php',
                'urlPath' => '/Fish.PHP',
            ],
        ];
    }

    /**
     * @dataProvider matchesDataProvider
     */
    public function testIsNotAllowedWithMatchingDisallowDirectives(string $directivePath, string $urlPath)
    {
        $parser = new Parser();
        $parser->setSource('user-agent: *' . "\n" . 'disallow: ' . $directivePath);

        $file = $parser->getFile();
        $inspector = new Inspector($file);

        $this->assertFalse($inspector->isAllowed($urlPath));
    }

    /**
     * robots-txt-rfc-draft-* data sets taken from:
     * http://www.robotstxt.org/norobots-rfc.txt
     *
     * Directive path     URL path         Matches
     * /tmp               /tmp               yes
     * /tmp               /tmp.html          yes
     * /tmp               /tmp/a.html        yes
     * /tmp/              /tmp/              yes
     * /tmp/              /tmp/a.html        yes

     * /a%3cd.html        /a%3cd.html        yes
     * /a%3Cd.html        /a%3cd.html        yes
     * /a%3cd.html        /a%3Cd.html        yes
     * /a%3Cd.html        /a%3Cd.html        yes

     * /a%2fb.html        /a%2fb.html        yes
     * /a/b.html          /a/b.html          yes

     * /%7ejoe/index.html /~joe/index.html   yes
     * /~joe/index.html   /%7Ejoe/index.html yes
     *
     * google-webmasters-* data sets taken from:
     * https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt#url-matching-based-on-path-values
     *
     * Directive path   URL path            Matches
     * /                <any valid URL>       yes
     * /*               <any valid URL>       yes
     * /fish            /fish
     *                  /fish.html
     *                  /fish/salmon.html
     *                  /fishheads
     *                  /fishheads/yummy.html
     *                  /fish.php?id=anything
     * /fish*           /fish
     *                  /fish.html
     *                  /fish/salmon.html
     *                  /fishheads
     *                  /fishheads/yummy.html
     *                  /fish.php?id=anything
     *
     * /fish/           /fish/
     *                  /fish/?id=anything
     *                  /fish/salmon.htm
     *
     * /*.php           /filename.php
     *                  /folder/filename.php
     *                  /folder/filename.php?parameters
     *                  /folder/any.php.file.html
     *                  /filename.php/
     *
     * /*.php$          /filename.php
     *                  /folder/filename.php
     *
     * /fish*.php       /fish.php
     *                  /fishheads/catfish.php?parameters
     *
     * @return array
     */
    public function matchesDataProvider(): array
    {
        return [
            'robots-txt-rfc-draft-1' => [
                'directivePath' => '/tmp',
                'urlPath' => '/tmp',
            ],
            'robots-txt-rfc-draft-2' => [
                'directivePath' => '/tmp',
                'urlPath' => '/tmp.html',
            ],
            'robots-txt-rfc-draft-3' => [
                'directivePath' => '/tmp',
                'urlPath' => '/tmp/a.html',
            ],
            'robots-txt-rfc-draft-4' => [
                'directivePath' => '/tmp/',
                'urlPath' => '/tmp/',
            ],
            'robots-txt-rfc-draft-5' => [
                'directivePath' => '/tmp/',
                'urlPath' => '/tmp/a.html',
            ],
            'robots-txt-rfc-draft-6' => [
                'directivePath' => '/a%3cd.html',
                'urlPath' => '/a%3cd.html',
            ],
            'robots-txt-rfc-draft-7' => [
                'directivePath' => '/a%3Cd.html',
                'urlPath' => '/a%3cd.html',
            ],
            'robots-txt-rfc-draft-8' => [
                'directivePath' => '/a%3cd.html',
                'urlPath' => '/a%3Cd.html',
            ],
            'robots-txt-rfc-draft-9' => [
                'directivePath' => '/a%3Cd.html',
                'urlPath' => '/a%3Cd.html',
            ],
            'robots-txt-rfc-draft-10' => [
                'directivePath' => '/a%2fb.html',
                'urlPath' => '/a%2fb.html',
            ],
            'robots-txt-rfc-draft-11' => [
                'directivePath' => '/a/b.html',
                'urlPath' => '/a/b.html ',
            ],
            'robots-txt-rfc-draft-12' => [
                'directivePath' => '/%7ejoe/index.html',
                'urlPath' => '/~joe/index.html',
            ],
            'robots-txt-rfc-draft-13' => [
                'directivePath' => '/~joe/index.html',
                'urlPath' => '/%7Ejoe/index.html',
            ],
            'google-webmasters-1' => [
                'directivePath' => '/',
                'urlPath' => '/foo',
            ],
            'google-webmasters-2' => [
                'directivePath' => '/*',
                'urlPath' => '/foo',
            ],
            'google-webmasters-4' => [
                'directivePath' => '/fish',
                'urlPath' => '/fish.html',
            ],
            'google-webmasters-5' => [
                'directivePath' => '/fish',
                'urlPath' => '/fish/salmon.html',
            ],
            'google-webmasters-6' => [
                'directivePath' => '/fish',
                'urlPath' => '/fishheads',
            ],
            'google-webmasters-7' => [
                'directivePath' => '/fish',
                'urlPath' => '/fishheads/yummy.html',
            ],
            'google-webmasters-8' => [
                'directivePath' => '/fish',
                'urlPath' => '/fish.php?id=anything',
            ],
            'google-webmasters-9' => [
                'directivePath' => '/fish*',
                'urlPath' => '/fish',
            ],
            'google-webmasters-10' => [
                'directivePath' => '/fish*',
                'urlPath' => '/fish.html',
            ],
            'google-webmasters-11' => [
                'directivePath' => '/fish*',
                'urlPath' => '/fish/salmon.html',
            ],
            'google-webmasters-12' => [
                'directivePath' => '/fish*',
                'urlPath' => '/fishheads',
            ],
            'google-webmasters-13' => [
                'directivePath' => '/fish*',
                'urlPath' => '/fishheads/yummy.html',
            ],
            'google-webmasters-14' => [
                'directivePath' => '/fish*',
                'urlPath' => '/fish.php?id=anything',
            ],
            'google-webmasters-16' => [
                'directivePath' => '/fish/',
                'urlPath' => '/fish/?id=anything',
            ],
            'google-webmasters-17' => [
                'directivePath' => '/fish/',
                'urlPath' => '/fish/salmon.htm',
            ],
            'google-webmasters-18' => [
                'directivePath' => '/*.php',
                'urlPath' => '/filename.php',
            ],
            'google-webmasters-19' => [
                'directivePath' => '/*.php',
                'urlPath' => '/folder/filename.php',
            ],
            'google-webmasters-20' => [
                'directivePath' => '/*.php',
                'urlPath' => '/folder/filename.php?parameters',
            ],
            'google-webmasters-21' => [
                'directivePath' => '/*.php',
                'urlPath' => '/folder/any.php.file.html',
            ],
            'google-webmasters-22' => [
                'directivePath' => '/*.php',
                'urlPath' => '/filename.php/',
            ],
            'google-webmasters-23' => [
                'directivePath' => '/*.php$',
                'urlPath' => '/filename.php',
            ],
            'google-webmasters-24' => [
                'directivePath' => '/*.php$',
                'urlPath' => '/folder/filename.php',
            ],
            'google-webmasters-25' => [
                'directivePath' => '/fish*.php',
                'urlPath' => '/fish.php',
            ],
            'google-webmasters-26' => [
                'directivePath' => '/fish*.php',
                'urlPath' => '/fishheads/catfish.php?parameters',
            ],
        ];
    }

    /**
     * @dataProvider allowDisallowDirectiveResolutionDataProvider
     *
     * @param string[] $directiveStrings
     * @param string $urlPath
     * @param bool $expectedAllowed
     */
    public function testMatchingAllowAndDisallowDirectiveResolution(
        array $directiveStrings,
        string $urlPath,
        bool $expectedAllowed
    ) {
        $parser = new Parser();
        $parser->setSource('user-agent: *' . "\n" . implode("\n", $directiveStrings));

        $file = $parser->getFile();
        $inspector = new Inspector($file);

        $this->assertEquals($expectedAllowed, $inspector->isAllowed($urlPath));
    }

    /**
     * Data sets derived from:
     * - https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt#order-of-precedence-for-group-member-records
     * - studying the behaviour of google webmasters robots txt checker
     *
     * @return array
     */
    public function allowDisallowDirectiveResolutionDataProvider(): array
    {
        return [
            'longer patternless allow supercedes patternless disallow' => [
                'directiveStrings' => [
                    'allow: /folder/',
                    'disallow: /folder',

                ],
                'urlPath' => '/folder/page',
                'expectedAllowed' => true,
            ],
            'longer patternless disallow supercedes patternless allow' => [
                'directiveStrings' => [
                    'allow: /folder',
                    'disallow: /folder/',

                ],
                'urlPath' => '/folder/page',
                'expectedAllowed' => false,
            ],
            'allow supercedes disallow if both are identical' => [
                'directiveStrings' => [
                    'allow: /folder',
                    'disallow: /folder',

                ],
                'urlPath' => '/folder/page',
                'expectedAllowed' => true,
            ],
            'disallow supercedes allow if both are of the same length' => [
                'directiveStrings' => [
                    'allow: /folder',
                    'disallow: /*/page',

                ],
                'urlPath' => '/folders/page',
                'expectedAllowed' => false,
            ],
            'longer patterned allow supercedes shorter disallow' => [
                'directiveStrings' => [
                    'allow: /$',
                    'disallow: /',

                ],
                'urlPath' => '/',
                'expectedAllowed' => true,
            ],
            'only disallow matches' => [
                'directiveStrings' => [
                    'allow: /$',
                    'disallow: /',

                ],
                'urlPath' => '/page.htm',
                'expectedAllowed' => false,
            ],
        ];
    }
}
