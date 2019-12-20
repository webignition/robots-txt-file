<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\File;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\File\Parser;
use webignition\RobotsTxt\Inspector\Inspector;

class ParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var string
     */
    private $dataSourceBasePath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new Parser();
        $this->dataSourceBasePath = __DIR__ . '/../fixtures/robots-txt-files';
    }

    public function testParsingStackoverflowDotCom()
    {
        $this->setParserSourceFromDataFile('stackoverflow.com.txt');
        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertNotEmpty((string)$file);

        $records = $file->getRecords();

        $this->assertCount(5, $records);

        $record1 = $records[0];

        $this->assertEquals(array('*'), $record1->getUserAgentDirectiveList()->getValues());
        $this->assertCount(48, $record1->getDirectiveList()->getDirectives());
        $this->assertTrue($record1->getDirectiveList()->contains(
            new Directive('disallow', '/users/login/global/request/')
        ));

        $inspector->setUserAgent('googlebot-image');
        $this->assertEquals(
            'disallow:/*/ivc/*' . "\n" . 'disallow:/users/flair/',
            (string)$inspector->getDirectives()
        );
        $this->assertEquals(
            'sitemap:/sitemap.xml',
            (string)$file->getNonGroupDirectives()->getByField('sitemap')
        );
    }

    public function testParsingWithSitemapAsLastLineInSingleRecord()
    {
        $this->setParserSourceFromDataFile('sitemapAsLastLineInSingleRecord.txt');

        $file = $this->parser->getFile();

        $this->assertCount(1, $file->getRecords());
        $this->assertCount(1, $file->getNonGroupDirectives()->getValues());

        $this->assertEquals(
            'sitemap:http://example.com/sitemap.xml',
            (string)$file->getNonGroupDirectives()->getByField('sitemap')
        );
    }

    public function testParsingWithSitemapWithinSingleRecord()
    {
        $this->setParserSourceFromDataFile('sitemapWithinSingleRecord.txt');

        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertCount(1, $file->getRecords());
        $this->assertCount(2, $inspector->getDirectives()->getValues());
        $this->assertCount(1, $file->getNonGroupDirectives()->getValues());

        $this->assertEquals(
            'sitemap:http://example.com/sitemap.xml',
            (string)$file->getNonGroupDirectives()->getByField('sitemap')
        );
    }

    public function testParsingInvalidSitemap()
    {
        $this->setParserSourceFromDataFile('newscientist.com.txt');

        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertCount(2, $file->getRecords());
        $this->assertCount(1, $inspector->getDirectives()->getValues());

        $inspector->setUserAgent('zibber');
        $this->assertCount(6, $inspector->getDirectives()->getValues());
        $this->assertCount(1, $file->getNonGroupDirectives()->getValues());
        $this->assertCount(1, $file->getNonGroupDirectives()->getByField('sitemap')->getValues());
    }

    public function testParsingWithStartingBOM()
    {
        $this->setParserSourceFromDataFile('withBom.txt');

        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertCount(1, $file->getRecords());
        $this->assertCount(2, $inspector->getDirectives()->getValues());

        $this->assertEquals(array(
            'disallow:/',
            'allow:/humans.txt'
        ), $inspector->getDirectives()->getValues());
    }

    public function testParsingInvalidLines()
    {
        $this->setParserSourceFromDataFile('contains-invalid-lines.txt');

        $file = $this->parser->getFile();
        $inspector = new Inspector($file);

        $this->assertCount(3, $file->getRecords());

        $inspector->setUserAgent('*');
        $this->assertCount(1, $inspector->getDirectives()->getValues());
        $this->assertEquals([
            'allow:/',
        ], $inspector->getDirectives()->getValues());

        $inspector->setUserAgent('foo');
        $this->assertCount(1, $inspector->getDirectives()->getValues());
        $this->assertEquals([
            'allow:/foo',
        ], $inspector->getDirectives()->getValues());

        $inspector->setUserAgent('bar');
        $this->assertCount(1, $inspector->getDirectives()->getValues());
        $this->assertEquals([
            'allow:/bar',
        ], $inspector->getDirectives()->getValues());

        $sitemapDirective = $file->getNonGroupDirectives()->getDirectives()[0];
        $this->assertEquals('sitemap', $sitemapDirective->getField());
        $this->assertEquals('/sitemap.xml', $sitemapDirective->getValue());
    }

    private function setParserSourceFromDataFile(string $relativePath): void
    {
        $this->parser->setSource((string) file_get_contents($this->dataSourceBasePath . '/' . $relativePath));
    }
}
