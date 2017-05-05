<?php

namespace webignition\Tests\RobotsTxt\File\GetDirectivesFor;

use webignition\RobotsTxt\Record\Record;
use webignition\Tests\RobotsTxt\File\FileTest;

class GetDirectivesForTest extends FileTest
{
    const DIRECTIVE_ALL_AGENTS_0 = 'allow:/allowed-path-for-*';
    const DIRECTIVE_ALL_AGENTS_1 = 'disallow:/disallowed-path-for-*';
    const DIRECTIVE_GOOGLEBOT_0 = 'allow:/allowed-path-for-googlebot';
    const DIRECTIVE_GOOGLEBOT_1 = 'disallow:/disallowed-path-for-googlebot';
    const DIRECTIVE_GOOGLEBOT_NEWS_0 = 'allow:/allowed-path-for-googlebot-news';
    const DIRECTIVE_GOOGLEBOT_NEWS_1 = 'disallow:/disallowed-path-for-googlebot-news';
    const DIRECTIVE_BINGBOT_SLURP_0 = 'allow:/allowed-path-for-bingbot-slurp';
    const DIRECTIVE_BINGBOT_SLURP_1 = 'disallow:/disallowed-path-for-bingbot-slurp';

    /**
     * @var string[]
     */
    private $expectedAllAgentsDirectives = [
        self::DIRECTIVE_ALL_AGENTS_0,
        self::DIRECTIVE_ALL_AGENTS_1,
    ];

    /**
     * @var string[]
     */
    private $expectedGooglebotDirectives = [
        self::DIRECTIVE_GOOGLEBOT_0,
        self::DIRECTIVE_GOOGLEBOT_1,
    ];

    /**
     * @var string[]
     */
    private $expectedGooglebotNewsDirectives = [
        self::DIRECTIVE_GOOGLEBOT_NEWS_0,
        self::DIRECTIVE_GOOGLEBOT_NEWS_1,
    ];

    /**
     * @var string[]
     */
    private $expectedBingbotSlurpDirectives = [
        self::DIRECTIVE_BINGBOT_SLURP_0,
        self::DIRECTIVE_BINGBOT_SLURP_1,
    ];

    private $userAgentStringFixtures = [];

    /**
     * @dataProvider testGetDirectivesForDefaultFileDataProvider
     *
     * @param $userAgentString
     * @param $expectedDirectives
     */
    public function testGetDirectivesForDefaultFile($userAgentString, $expectedDirectives)
    {
        $this->createDefaultFile();

        $this->assertEquals(
            $expectedDirectives,
            (string)$this->file->getDirectivesFor($userAgentString)
        );
    }

    /**
     * @return array
     */
    public function testGetDirectivesForDefaultFileDataProvider()
    {
        return [
            'googlebot-lowercase' => [
                'userAgentString' => 'googlebot',
                'expectedDirectives' => implode("\n", $this->expectedGooglebotDirectives)
            ],
            'googlebot-uppercase' => [
                'userAgentString' => 'GOOGLEBOT',
                'expectedDirectives' => implode("\n", $this->expectedGooglebotDirectives)
            ],
            'googlebot-mixedcase' => [
                'userAgentString' => 'GOOGLEbot',
                'expectedDirectives' => implode("\n", $this->expectedGooglebotDirectives)
            ],
            'googlebot-news' => [
                'userAgentString' => 'googlebot-news',
                'expectedDirectives' => implode("\n", $this->expectedGooglebotNewsDirectives)
            ],
            'no specific agent' => [
                'userAgentString' => '*',
                'expectedDirectives' => implode("\n", $this->expectedAllAgentsDirectives)
            ],
            'specific agent not present' => [
                'userAgentString' => 'foo',
                'expectedDirectives' => implode("\n", $this->expectedAllAgentsDirectives)
            ],
            'full googlebot string variant 1' => [
                'userAgentString' => $this->getUserAgentStringFixture('googlebot-1'),
                'expectedDirectives' => implode("\n", $this->expectedGooglebotDirectives)
            ],
            'full googlebot string variant 2' => [
                'userAgentString' => $this->getUserAgentStringFixture('googlebot-2'),
                'expectedDirectives' => implode("\n", $this->expectedGooglebotDirectives)
            ],
            'bingbot variant 1' => [
                'userAgentString' => $this->getUserAgentStringFixture('bingbot-1'),
                'expectedDirectives' => implode("\n", $this->expectedBingbotSlurpDirectives)
            ],
            'bingbot variant 2' => [
                'userAgentString' => $this->getUserAgentStringFixture('bingbot-2'),
                'expectedDirectives' => implode("\n", $this->expectedBingbotSlurpDirectives)
            ],
            'bingbot variant 3' => [
                'userAgentString' => $this->getUserAgentStringFixture('bingbot-3'),
                'expectedDirectives' => implode("\n", $this->expectedBingbotSlurpDirectives)
            ],
            'slurp' => [
                'userAgentString' => $this->getUserAgentStringFixture('slurp'),
                'expectedDirectives' => implode("\n", $this->expectedBingbotSlurpDirectives)
            ],
        ];
    }

    protected function createDefaultFile()
    {
        $defaultAgentRecord = new Record();
        $defaultAgentRecord->userAgentDirectiveList()->add('*');
        $defaultAgentRecord->directiveList()->add(self::DIRECTIVE_ALL_AGENTS_0);
        $defaultAgentRecord->directiveList()->add(self::DIRECTIVE_ALL_AGENTS_1);

        $googlebotRecord = new Record();
        $googlebotRecord->userAgentDirectiveList()->add('googlebot');
        $googlebotRecord->directiveList()->add(self::DIRECTIVE_GOOGLEBOT_0);
        $googlebotRecord->directiveList()->add(self::DIRECTIVE_GOOGLEBOT_1);

        $googlebotNewsRecord = new Record();
        $googlebotNewsRecord->userAgentDirectiveList()->add('googlebot-news');
        $googlebotNewsRecord->directiveList()->add(self::DIRECTIVE_GOOGLEBOT_NEWS_0);
        $googlebotNewsRecord->directiveList()->add(self::DIRECTIVE_GOOGLEBOT_NEWS_1);

        $bingbotAndSlurpRecord = new Record();
        $bingbotAndSlurpRecord->userAgentDirectiveList()->add('bingbot');
        $bingbotAndSlurpRecord->userAgentDirectiveList()->add('slurp');
        $bingbotAndSlurpRecord->directiveList()->add(self::DIRECTIVE_BINGBOT_SLURP_0);
        $bingbotAndSlurpRecord->directiveList()->add(self::DIRECTIVE_BINGBOT_SLURP_1);

        $this->file->addRecord($defaultAgentRecord);
        $this->file->addRecord($googlebotRecord);
        $this->file->addRecord($googlebotNewsRecord);
        $this->file->addRecord($bingbotAndSlurpRecord);
    }

    /**
     * @param string $fixtureIdentifier
     *
     * @return string
     */
    private function getUserAgentStringFixture($fixtureIdentifier)
    {
        if (empty($this->userAgentStringFixtures)) {
            $path = __DIR__ . '/../../fixtures/user-agent-strings.json';
            $this->userAgentStringFixtures = json_decode(file_get_contents($path), true);
        }

        return $this->userAgentStringFixtures[$fixtureIdentifier];
    }
}
